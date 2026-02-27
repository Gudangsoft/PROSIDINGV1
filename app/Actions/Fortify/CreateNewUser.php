<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Payment;
use App\Models\Notification;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $role = $input['role'] ?? 'author';
        $isParticipant = $role === 'participant';

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string', 'in:author,participant'],
            'gender' => ['required', 'in:male,female'],
            'institution' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
        ];

        // Common optional fields for all roles
        $rules['research_interest'] = ['required', 'string', 'max:255'];
        $rules['other_info'] = ['nullable', 'string', 'max:1000'];
        $rules['signature'] = ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'];

        // Check if selected package is free (before validation)
        $isFreePackage = false;
        $packageObj = null;
        if ($isParticipant && isset($input['registration_package_id'])) {
            $packageObj = \App\Models\RegistrationPackage::find((int) $input['registration_package_id']);
            $isFreePackage = $packageObj && $packageObj->is_free;
        }

        // Preselected paid package with require_payment_proof flag: require proof at registration
        $requireProofAtRegistration = $packageObj && !$isFreePackage && $packageObj->require_payment_proof;
        if ($requireProofAtRegistration) {
            $rules['payment_amount'] = ['required', 'numeric', 'min:1'];
            $rules['proof_of_payment'] = ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'];
        }

        Validator::make($input, $rules)->validate();

        $data = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $role,
            'gender' => $input['gender'],
            'institution' => $input['institution'],
            'country' => $input['country'],
            'phone' => $input['phone'],
            'research_interest' => $input['research_interest'] ?? null,
            'other_info' => $input['other_info'] ?? null,
        ];

        if (isset($input['signature']) && $input['signature'] instanceof \Illuminate\Http\UploadedFile) {
            $data['signature'] = $input['signature']->store('signatures', 'public');
        }

        // Save proof of payment file if provided (package with require_payment_proof flag)
        $requireProofAtRegistration = $packageObj && !$isFreePackage && $packageObj->require_payment_proof;
        if ($requireProofAtRegistration && isset($input['proof_of_payment']) && $input['proof_of_payment'] instanceof \Illuminate\Http\UploadedFile) {
            $data['proof_of_payment'] = $input['proof_of_payment']->store('proof-of-payment', 'public');
        }

        $user = User::create($data);

        // Create Payment record for participant
        $packageId = $isParticipant && isset($input['registration_package_id']) ? (int) $input['registration_package_id'] : null;
        $packageName = $packageObj ? ' — ' . $packageObj->name : '';

        if ($isParticipant && $isFreePackage) {
            // Free package: auto-create verified payment
            Payment::create([
                'type' => Payment::TYPE_PARTICIPANT,
                'user_id' => $user->id,
                'paper_id' => null,
                'registration_package_id' => $packageId,
                'invoice_number' => Payment::generateInvoiceNumber(),
                'amount' => 0,
                'description' => 'Registrasi Gratis' . $packageName,
                'status' => 'verified',
                'payment_method' => 'Gratis',
                'payment_proof' => null,
                'paid_at' => now(),
            ]);
        } elseif ($isParticipant && !$isFreePackage && !empty($data['proof_of_payment'])) {
            // Paid package with proof uploaded at registration (require_payment_proof = true)
            Payment::create([
                'type' => Payment::TYPE_PARTICIPANT,
                'user_id' => $user->id,
                'paper_id' => null,
                'registration_package_id' => $packageId,
                'invoice_number' => Payment::generateInvoiceNumber(),
                'amount' => $input['payment_amount'] ?? ($packageObj ? $packageObj->price : 0),
                'description' => 'Pembayaran registrasi partisipan' . $packageName,
                'status' => 'uploaded',
                'payment_proof' => $data['proof_of_payment'],
                'paid_at' => now(),
            ]);
        } elseif ($isParticipant && !$isFreePackage) {
            // Paid package without proof — pending, upload via dashboard
            if (!$packageName && $packageId) {
                $pkg = \App\Models\RegistrationPackage::find($packageId);
                $packageName = $pkg ? ' — ' . $pkg->name : '';
            }
            Payment::create([
                'type' => Payment::TYPE_PARTICIPANT,
                'user_id' => $user->id,
                'paper_id' => null,
                'registration_package_id' => $packageId,
                'invoice_number' => Payment::generateInvoiceNumber(),
                'amount' => $packageObj ? $packageObj->price : 0,
                'description' => 'Pembayaran registrasi partisipan' . $packageName,
                'status' => 'pending',
                'payment_method' => null,
                'payment_proof' => null,
                'paid_at' => null,
            ]);
        }

        // Send welcome notification to newly registered user
        Notification::createForUser(
            userId: $user->id,
            type: 'success',
            title: 'Welcome! 🎉',
            message: 'Your account has been successfully registered. ' . ($isFreePackage ? 'Your free package is now active, welcome aboard!' : ($isParticipant && !empty($data['proof_of_payment']) ? 'Your payment proof has been received and will be verified shortly.' : ($isParticipant ? 'Please log in and upload your payment proof in the Payment menu on the dashboard.' : 'Please log in and start submitting your paper.'))),
            actionUrl: url('/dashboard'),
            actionText: 'Go to Dashboard'
        );

        // Determine registration status label for the welcome email
        if ($role === 'participant') {
            if ($isFreePackage) {
                $registrationStatus = 'Terdaftar (Gratis)';
            } elseif (!empty($data['proof_of_payment'])) {
                $registrationStatus = 'Bukti Pembayaran Diterima — Menunggu Verifikasi';
            } else {
                $registrationStatus = 'Menunggu Upload Bukti Pembayaran';
            }
        } else {
            $registrationStatus = 'Terdaftar sebagai Penulis';
        }

        // Send welcome email
        try {
            Mail::to($user->email)->send(
                new WelcomeMail($user->name, $role, url('/dashboard'), $packageObj?->conference_id, $registrationStatus)
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send welcome email: ' . $e->getMessage());
        }

        return $user;
    }
}
