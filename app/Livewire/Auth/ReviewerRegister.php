<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class ReviewerRegister extends Component
{
    use WithFileUploads;

    // Personal Information
    public string $name = '';
    public string $email = '';
    public string $gender = '';
    public string $institution = '';
    public string $country = 'Indonesia';
    public string $phone = '+62';
    public string $research_interest = '';
    public string $other_info = '';
    
    // Reviewer-specific fields
    public string $expertise = '';           // Area of expertise
    public string $scopus_id = '';           // Scopus Author ID (optional)
    public string $google_scholar = '';      // Google Scholar profile URL (optional)
    public string $orcid = '';               // ORCID ID (optional)
    public string $qualification = '';       // Highest qualification (e.g., PhD, MSc)
    public string $review_experience = '';   // Years of review experience
    
    // Account
    public string $password = '';
    public string $password_confirmation = '';
    
    // CV/Resume upload
    public $cv_file = null;
    
    public bool $success = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'gender' => 'required|in:male,female',
            'institution' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'research_interest' => 'required|string|max:500',
            'other_info' => 'nullable|string|max:1000',
            'expertise' => 'required|string|max:500',
            'scopus_id' => 'nullable|string|max:100',
            'google_scholar' => 'nullable|url|max:255',
            'orcid' => 'nullable|string|max:50',
            'qualification' => 'required|string|max:100',
            'review_experience' => 'nullable|string|max:50',
            'password' => 'required|string|min:8|confirmed',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',
        'gender.required' => 'Jenis kelamin wajib dipilih.',
        'institution.required' => 'Institusi wajib diisi.',
        'country.required' => 'Negara wajib dipilih.',
        'phone.required' => 'Nomor telepon wajib diisi.',
        'research_interest.required' => 'Bidang penelitian wajib diisi.',
        'expertise.required' => 'Area keahlian wajib diisi.',
        'qualification.required' => 'Kualifikasi pendidikan wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'cv_file.mimes' => 'File CV harus berformat PDF, DOC, atau DOCX.',
        'cv_file.max' => 'Ukuran file CV maksimal 5MB.',
    ];

    public function register()
    {
        $this->validate();

        // Handle CV upload
        $cvPath = null;
        if ($this->cv_file) {
            $cvPath = $this->cv_file->store('reviewer-cv', 'public');
        }

        // Create user with role 'reviewer' but status pending
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'reviewer', // Set role as reviewer
            'gender' => $this->gender,
            'institution' => $this->institution,
            'country' => $this->country,
            'phone' => $this->phone,
            'research_interest' => $this->research_interest,
            'other_info' => $this->buildOtherInfo($cvPath),
        ]);

        // Send welcome email
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Throwable $e) {
            // Log error but don't fail registration
            \Log::warning('Failed to send welcome email to reviewer: ' . $e->getMessage());
        }

        // Notify admins about new reviewer registration
        $this->notifyAdmins($user);

        $this->success = true;
        
        // Reset form
        $this->reset(['name', 'email', 'gender', 'institution', 'phone', 'research_interest', 
            'other_info', 'expertise', 'scopus_id', 'google_scholar', 'orcid', 
            'qualification', 'review_experience', 'password', 'password_confirmation', 'cv_file']);
        $this->country = 'Indonesia';
        $this->phone = '+62';
    }

    /**
     * Build other_info field with reviewer-specific data
     */
    private function buildOtherInfo(?string $cvPath): string
    {
        $info = [];
        
        if ($this->other_info) {
            $info[] = "Notes: {$this->other_info}";
        }
        
        $info[] = "--- Reviewer Information ---";
        $info[] = "Expertise: {$this->expertise}";
        $info[] = "Qualification: {$this->qualification}";
        
        if ($this->review_experience) {
            $info[] = "Review Experience: {$this->review_experience}";
        }
        if ($this->scopus_id) {
            $info[] = "Scopus ID: {$this->scopus_id}";
        }
        if ($this->google_scholar) {
            $info[] = "Google Scholar: {$this->google_scholar}";
        }
        if ($this->orcid) {
            $info[] = "ORCID: {$this->orcid}";
        }
        if ($cvPath) {
            $info[] = "CV: {$cvPath}";
        }
        
        return implode("\n", $info);
    }

    /**
     * Notify admins about new reviewer registration
     */
    private function notifyAdmins(User $user): void
    {
        try {
            $admins = User::where('role', 'admin')->get();
            
            foreach ($admins as $admin) {
                \App\Models\Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'New Reviewer Registration',
                    'message' => "A new reviewer has registered: {$user->name} ({$user->email}) from {$user->institution}",
                    'type' => 'info',
                    'link' => route('admin.users-roles'),
                ]);
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed to notify admins about new reviewer: ' . $e->getMessage());
        }
    }

    public function getCountriesProperty(): array
    {
        return [
            'Afghanistan','Albania','Algeria','Andorra','Angola','Antigua and Barbuda','Argentina','Armenia','Australia','Austria',
            'Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan',
            'Bolivia','Bosnia and Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi','Cabo Verde','Cambodia',
            'Cameroon','Canada','Central African Republic','Chad','Chile','China','Colombia','Comoros','Congo','Costa Rica',
            'Croatia','Cuba','Cyprus','Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','Ecuador','Egypt',
            'El Salvador','Equatorial Guinea','Eritrea','Estonia','Eswatini','Ethiopia','Fiji','Finland','France','Gabon',
            'Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana',
            'Haiti','Honduras','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel',
            'Italy','Jamaica','Japan','Jordan','Kazakhstan','Kenya','Kiribati','Korea (North)','Korea (South)','Kuwait',
            'Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg',
            'Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico',
            'Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar','Namibia','Nauru',
            'Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','North Macedonia','Norway','Oman','Pakistan',
            'Palau','Palestine','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Qatar',
            'Romania','Russia','Rwanda','Saint Kitts and Nevis','Saint Lucia','Saint Vincent and the Grenadines','Samoa','San Marino',
            'Sao Tome and Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia',
            'Solomon Islands','Somalia','South Africa','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Sweden','Switzerland',
            'Syria','Taiwan','Tajikistan','Tanzania','Thailand','Timor-Leste','Togo','Tonga','Trinidad and Tobago','Tunisia',
            'Turkey','Turkmenistan','Tuvalu','Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay',
            'Uzbekistan','Vanuatu','Vatican City','Venezuela','Vietnam','Yemen','Zambia','Zimbabwe'
        ];
    }

    public function render()
    {
        return view('livewire.auth.reviewer-register')
            ->layout('layouts.guest', ['title' => 'Reviewer Registration']);
    }
}
