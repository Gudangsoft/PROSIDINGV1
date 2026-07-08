<?php

namespace App\Livewire\Participant;

use App\Helpers\FileUploadValidator;
use App\Models\Payment;
use App\Models\Conference;
use App\Models\RegistrationPackage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentProof extends Component
{
    use WithFileUploads;

    public $payment;
    public $newProof;

    // Display-only — derived server-side from the selected package/payment
    // method. Locked so a crafted request can't set it directly; the actual
    // amount charged is still recomputed from scratch in reupload().
    #[Locked]
    public $newAmount;

    // Package selection
    public $selectedPackageId;
    public $selectedPackage;
    public $packages = [];

    // Payment method selection
    public $selectedPaymentMethodIndex;
    public $paymentMethods = [];

    #[Locked]
    public $finalAmount = 0;

    public function mount()
    {
        $this->payment = Payment::where('user_id', Auth::id())
            ->where('type', Payment::TYPE_PARTICIPANT)
            ->first();

        // Load available packages
        $conference = Conference::active()->first();
        if ($conference) {
            $this->packages = RegistrationPackage::where('conference_id', $conference->id)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();
            
            // Load payment methods from conference
            $this->paymentMethods = $conference->payment_methods ?? [];
            
            // Fallback to legacy payment fields if paymentMethods is empty but legacy fields exist
            if (empty($this->paymentMethods) && !empty($conference->payment_bank_name) && !empty($conference->payment_bank_account)) {
                $this->paymentMethods = [
                    [
                        'type' => 'Bank Transfer',
                        'name' => $conference->payment_bank_name,
                        'account_number' => $conference->payment_bank_account,
                        'account_holder' => $conference->payment_account_holder,
                        'instructions' => $conference->payment_instructions,
                        'amount' => null,
                        'is_active' => true,
                    ]
                ];
            }
        }

        // If payment exists, pre-select the package
        if ($this->payment && $this->payment->registration_package_id) {
            $this->selectedPackageId = $this->payment->registration_package_id;
            $this->updatedSelectedPackageId($this->selectedPackageId);
        } elseif (request()->filled('package')) {
            // Pre-select from query string ?package=ID (dari tombol "Daftar Sekarang")
            $packageId = (int) request()->query('package');
            $valid = $this->packages->firstWhere('id', $packageId);
            if ($valid) {
                $this->selectedPackageId = $packageId;
                $this->updatedSelectedPackageId($this->selectedPackageId);
            }
        }

        $this->newAmount = $this->payment?->amount ?? 0;
    }

    public function updatedSelectedPackageId($value)
    {
        if ($value) {
            $this->selectedPackage = RegistrationPackage::find($value);
            if ($this->selectedPackage->is_free) {
                $this->finalAmount = 0;
                $this->newAmount = 0;
            } else {
                $this->finalAmount = $this->selectedPackage->price;
                $this->newAmount = $this->finalAmount;
            }
            // Reset payment method selection when package changes
            $this->selectedPaymentMethodIndex = null;
        } else {
            $this->selectedPackage = null;
            $this->finalAmount = 0;
            $this->newAmount = 0;
            $this->selectedPaymentMethodIndex = null;
        }
    }

    public function updatedSelectedPaymentMethodIndex($value)
    {
        if ($value !== null && $this->selectedPackage) {
            $method = $this->paymentMethods[$value] ?? null;
            
            if ($method && isset($method['amount'])) {
                // Use the amount from payment method
                $this->finalAmount = $method['amount'];
                $this->newAmount = $this->finalAmount;
            } else {
                // Use base package price
                $this->finalAmount = $this->selectedPackage->price;
                $this->newAmount = $this->finalAmount;
            }
        }
    }

    public function registerFree()
    {
        $this->validate([
            'selectedPackageId' => ['required', 'exists:registration_packages,id'],
        ], [
            'selectedPackageId.required' => 'Pilih paket registrasi terlebih dahulu.',
        ]);

        // Double check the package is actually free
        $pkg = RegistrationPackage::find($this->selectedPackageId);
        if (!$pkg || !$pkg->is_free) {
            $this->addError('selectedPackageId', 'Paket ini bukan paket gratis.');
            return;
        }

        if ($this->payment) {
            $this->payment->update([
                'registration_package_id' => $this->selectedPackageId,
                'amount' => 0,
                'payment_method' => 'Gratis',
                'status' => 'verified',
                'paid_at' => now(),
                'verified_at' => now(),
                'admin_notes' => null,
            ]);
        } else {
            $this->payment = Payment::create([
                'type' => Payment::TYPE_PARTICIPANT,
                'user_id' => Auth::id(),
                'paper_id' => null,
                'registration_package_id' => $this->selectedPackageId,
                'invoice_number' => Payment::generateInvoiceNumber(),
                'amount' => 0,
                'description' => 'Registrasi gratis - ' . $pkg->name,
                'status' => 'verified',
                'payment_method' => 'Gratis',
                'paid_at' => now(),
                'verified_at' => now(),
            ]);
        }

        session()->flash('success', 'Pendaftaran gratis berhasil dikonfirmasi. Akun Anda sudah aktif!');
        $this->redirect(request()->url(), navigate: true);
    }

    public function reupload()
    {
        $this->validate([
            'selectedPackageId' => ['required', 'exists:registration_packages,id'],
            'newProof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'selectedPackageId.required' => 'Pilih paket registrasi terlebih dahulu.',
            'selectedPackageId.exists' => 'Paket registrasi tidak valid.',
            'newProof.required' => 'Pilih file bukti pembayaran.',
            'newProof.mimes' => 'Format file harus JPG, PNG, atau PDF.',
            'newProof.max' => 'Ukuran file maksimal 5MB.',
        ]);

        // Recompute the authoritative amount/package/method fresh from the
        // database — never trust $this->newAmount / $this->finalAmount /
        // $this->selectedPackage for the actual money value. Livewire public
        // properties can be tampered with independently of what the form
        // renders, so the only safe source of truth is a fresh DB read keyed
        // off the validated selectedPackageId.
        $package = RegistrationPackage::findOrFail($this->selectedPackageId);
        if ($package->is_free) {
            $this->addError('selectedPackageId', 'Paket ini gratis, gunakan tombol daftar gratis.');
            return;
        }

        $amount = $package->price;
        $paymentMethodName = null;
        if ($this->selectedPaymentMethodIndex !== null) {
            $conference = Conference::find($package->conference_id) ?? Conference::active()->first();
            $methods = $conference?->payment_methods ?? [];
            $method = $methods[$this->selectedPaymentMethodIndex] ?? null;
            if ($method) {
                if (isset($method['amount']) && $method['amount'] !== null) {
                    $amount = $method['amount'];
                }
                $paymentMethodName = ($method['type'] ?? '') . ' - ' . ($method['name'] ?? '');
            }
        }

        $scan = FileUploadValidator::validatePayment($this->newProof);
        if (!$scan['valid']) {
            $this->addError('newProof', implode(' ', $scan['errors']));
            return;
        }

        // Delete old proof if exists
        if ($this->payment && $this->payment->payment_proof) {
            Storage::disk('public')->delete($this->payment->payment_proof);
        }

        $path = $this->newProof->store('proof-of-payment', 'public');

        if ($this->payment) {
            $this->payment->update([
                'registration_package_id' => $this->selectedPackageId,
                'payment_proof' => $path,
                'amount' => $amount,
                'payment_method' => $paymentMethodName,
                'status' => 'uploaded',
                'paid_at' => now(),
                'admin_notes' => null,
            ]);
        } else {
            // Create new payment record if none exists
            $this->payment = Payment::create([
                'type' => Payment::TYPE_PARTICIPANT,
                'user_id' => Auth::id(),
                'paper_id' => null,
                'registration_package_id' => $this->selectedPackageId,
                'invoice_number' => Payment::generateInvoiceNumber(),
                'amount' => $amount,
                'description' => 'Pembayaran registrasi partisipan - ' . $package->name,
                'status' => 'uploaded',
                'payment_proof' => $path,
                'payment_method' => $paymentMethodName,
                'paid_at' => now(),
            ]);
        }

        // Also update user's proof_of_payment field for backward compatibility
        Auth::user()->update(['proof_of_payment' => $path]);

        $this->newProof = null;
        $this->newAmount = $amount;
        session()->flash('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    public function render()
    {
        return view('livewire.participant.payment-proof')
            ->layout('layouts.app');
    }
}

