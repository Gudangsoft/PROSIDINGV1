<?php
// PATCH REVIEWER REGISTER - Pure PHP
// Akses: /patch-reviewer-form.php?token=reviewer2026
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'reviewer2026') {
    die('Token: ?token=reviewer2026');
}

echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace;line-height:1.6'>";
echo "<h2 style='color:#38bdf8'>PATCH REVIEWER REGISTRATION FORM</h2>\n\n";

$root = dirname(__DIR__);

// 1. Create directories if not exist
echo "<h3 style='color:#fbbf24'>1. CREATE DIRECTORIES</h3>\n";

$dirs = [
    $root . '/app/Livewire/Auth',
    $root . '/resources/views/livewire/auth',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "Created: " . str_replace($root, '', $dir) . "\n";
        } else {
            echo "<span style='color:#f87171'>Failed to create: " . str_replace($root, '', $dir) . "</span>\n";
        }
    } else {
        echo "Exists: " . str_replace($root, '', $dir) . "\n";
    }
}

// 2. Create Livewire Component
echo "\n<h3 style='color:#fbbf24'>2. CREATE LIVEWIRE COMPONENT</h3>\n";

$componentFile = $root . '/app/Livewire/Auth/ReviewerRegister.php';
$componentContent = '<?php

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

    public string $name = \'\';
    public string $email = \'\';
    public string $gender = \'\';
    public string $institution = \'\';
    public string $country = \'Indonesia\';
    public string $phone = \'+62\';
    public string $research_interest = \'\';
    public string $other_info = \'\';
    public string $expertise = \'\';
    public string $scopus_id = \'\';
    public string $google_scholar = \'\';
    public string $orcid = \'\';
    public string $qualification = \'\';
    public string $review_experience = \'\';
    public string $password = \'\';
    public string $password_confirmation = \'\';
    public $cv_file = null;
    public bool $success = false;

    protected function rules(): array
    {
        return [
            \'name\' => \'required|string|max:255\',
            \'email\' => \'required|email|max:255|unique:users,email\',
            \'gender\' => \'required|in:male,female\',
            \'institution\' => \'required|string|max:255\',
            \'country\' => \'required|string|max:100\',
            \'phone\' => \'required|string|max:30\',
            \'research_interest\' => \'required|string|max:500\',
            \'other_info\' => \'nullable|string|max:1000\',
            \'expertise\' => \'required|string|max:500\',
            \'scopus_id\' => \'nullable|string|max:100\',
            \'google_scholar\' => \'nullable|url|max:255\',
            \'orcid\' => \'nullable|string|max:50\',
            \'qualification\' => \'required|string|max:100\',
            \'review_experience\' => \'nullable|string|max:50\',
            \'password\' => \'required|string|min:8|confirmed\',
            \'cv_file\' => \'nullable|file|mimes:pdf,doc,docx|max:5120\',
        ];
    }

    protected $messages = [
        \'name.required\' => \'Nama lengkap wajib diisi.\',
        \'email.required\' => \'Email wajib diisi.\',
        \'email.email\' => \'Format email tidak valid.\',
        \'email.unique\' => \'Email sudah terdaftar.\',
        \'gender.required\' => \'Jenis kelamin wajib dipilih.\',
        \'institution.required\' => \'Institusi wajib diisi.\',
        \'country.required\' => \'Negara wajib dipilih.\',
        \'phone.required\' => \'Nomor telepon wajib diisi.\',
        \'research_interest.required\' => \'Bidang penelitian wajib diisi.\',
        \'expertise.required\' => \'Area keahlian wajib diisi.\',
        \'qualification.required\' => \'Kualifikasi pendidikan wajib diisi.\',
        \'password.required\' => \'Password wajib diisi.\',
        \'password.min\' => \'Password minimal 8 karakter.\',
        \'password.confirmed\' => \'Konfirmasi password tidak cocok.\',
    ];

    public function register()
    {
        $this->validate();

        $cvPath = null;
        if ($this->cv_file) {
            $cvPath = $this->cv_file->store(\'reviewer-cv\', \'public\');
        }

        $user = User::create([
            \'name\' => $this->name,
            \'email\' => $this->email,
            \'password\' => Hash::make($this->password),
            \'role\' => \'reviewer\',
            \'gender\' => $this->gender,
            \'institution\' => $this->institution,
            \'country\' => $this->country,
            \'phone\' => $this->phone,
            \'research_interest\' => $this->research_interest,
            \'other_info\' => $this->buildOtherInfo($cvPath),
        ]);

        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Throwable $e) {
            \Log::warning(\'Failed to send welcome email: \' . $e->getMessage());
        }

        $this->notifyAdmins($user);
        $this->success = true;
        
        $this->reset([\'name\', \'email\', \'gender\', \'institution\', \'phone\', \'research_interest\', 
            \'other_info\', \'expertise\', \'scopus_id\', \'google_scholar\', \'orcid\', 
            \'qualification\', \'review_experience\', \'password\', \'password_confirmation\', \'cv_file\']);
        $this->country = \'Indonesia\';
        $this->phone = \'+62\';
    }

    private function buildOtherInfo(?string $cvPath): string
    {
        $info = [];
        if ($this->other_info) $info[] = "Notes: {$this->other_info}";
        $info[] = "--- Reviewer Information ---";
        $info[] = "Expertise: {$this->expertise}";
        $info[] = "Qualification: {$this->qualification}";
        if ($this->review_experience) $info[] = "Review Experience: {$this->review_experience}";
        if ($this->scopus_id) $info[] = "Scopus ID: {$this->scopus_id}";
        if ($this->google_scholar) $info[] = "Google Scholar: {$this->google_scholar}";
        if ($this->orcid) $info[] = "ORCID: {$this->orcid}";
        if ($cvPath) $info[] = "CV: {$cvPath}";
        return implode("\n", $info);
    }

    private function notifyAdmins(User $user): void
    {
        try {
            $admins = User::where(\'role\', \'admin\')->get();
            foreach ($admins as $admin) {
                \App\Models\Notification::create([
                    \'user_id\' => $admin->id,
                    \'title\' => \'New Reviewer Registration\',
                    \'message\' => "A new reviewer has registered: {$user->name} ({$user->email})",
                    \'type\' => \'info\',
                    \'link\' => route(\'admin.users-roles\'),
                ]);
            }
        } catch (\Throwable $e) {
            \Log::warning(\'Failed to notify admins: \' . $e->getMessage());
        }
    }

    public function getCountriesProperty(): array
    {
        return [\'Afghanistan\',\'Albania\',\'Algeria\',\'Argentina\',\'Australia\',\'Austria\',\'Bangladesh\',\'Belgium\',\'Brazil\',\'Canada\',\'Chile\',\'China\',\'Colombia\',\'Czech Republic\',\'Denmark\',\'Egypt\',\'Finland\',\'France\',\'Germany\',\'Greece\',\'Hungary\',\'India\',\'Indonesia\',\'Iran\',\'Iraq\',\'Ireland\',\'Israel\',\'Italy\',\'Japan\',\'Jordan\',\'Kenya\',\'Korea (South)\',\'Kuwait\',\'Lebanon\',\'Malaysia\',\'Mexico\',\'Morocco\',\'Netherlands\',\'New Zealand\',\'Nigeria\',\'Norway\',\'Pakistan\',\'Peru\',\'Philippines\',\'Poland\',\'Portugal\',\'Qatar\',\'Romania\',\'Russia\',\'Saudi Arabia\',\'Singapore\',\'South Africa\',\'Spain\',\'Sri Lanka\',\'Sudan\',\'Sweden\',\'Switzerland\',\'Taiwan\',\'Thailand\',\'Tunisia\',\'Turkey\',\'Ukraine\',\'United Arab Emirates\',\'United Kingdom\',\'United States\',\'Vietnam\',\'Yemen\'];
    }

    public function render()
    {
        return view(\'livewire.auth.reviewer-register\')
            ->layout(\'layouts.guest\', [\'title\' => \'Reviewer Registration\']);
    }
}
';

if (file_put_contents($componentFile, $componentContent) !== false) {
    echo "<span style='color:#4ade80'>✓ Created: app/Livewire/Auth/ReviewerRegister.php</span>\n";
} else {
    echo "<span style='color:#f87171'>✗ Failed to create component</span>\n";
}

// 3. Create View
echo "\n<h3 style='color:#fbbf24'>3. CREATE VIEW</h3>\n";

$viewFile = $root . '/resources/views/livewire/auth/reviewer-register.blade.php';
$viewContent = '<div class="max-w-4xl mx-auto">
    @if($success)
    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Pendaftaran Berhasil!</h2>
        <p class="text-gray-600 mb-6">Terima kasih telah mendaftar sebagai reviewer. Anda dapat login sekarang.</p>
        <a href="{{ route(\'login\') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition">Login Sekarang</a>
    </div>
    @else
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl p-8 mb-6 text-white shadow-lg">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Reviewer Registration</h1>
                <p class="text-purple-200 text-sm mt-0.5">Daftar sebagai reviewer untuk me-review paper</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <form wire:submit="register">
            <div class="px-8 pt-8 pb-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Personal Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error(\'name\') border-red-400 @enderror" placeholder="Dr. John Doe">
                        @error(\'name\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select wire:model="gender" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 bg-white @error(\'gender\') border-red-400 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>
                        @error(\'gender\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Institusi <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="institution" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error(\'institution\') border-red-400 @enderror" placeholder="Universitas Indonesia">
                        @error(\'institution\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Negara <span class="text-red-500">*</span></label>
                        <select wire:model="country" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 bg-white @error(\'country\') border-red-400 @enderror">
                            <option value="">-- Pilih Negara --</option>
                            <option value="Indonesia">Indonesia</option>
                            @foreach($this->countries as $c)<option value="{{ $c }}">{{ $c }}</option>@endforeach
                        </select>
                        @error(\'country\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" wire:model="email" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error(\'email\') border-red-400 @enderror" placeholder="email@example.com">
                        @error(\'email\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Telepon/WA <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="phone" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error(\'phone\') border-red-400 @enderror" placeholder="+62xxx">
                        @error(\'phone\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Academic Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kualifikasi <span class="text-red-500">*</span></label>
                        <select wire:model="qualification" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 bg-white @error(\'qualification\') border-red-400 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Professor">Professor</option>
                            <option value="Associate Professor">Associate Professor</option>
                            <option value="PhD / Doctoral">PhD / Doctoral</option>
                            <option value="Master / S2">Master / S2</option>
                            <option value="Bachelor / S1">Bachelor / S1</option>
                        </select>
                        @error(\'qualification\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Pengalaman Review</label>
                        <select wire:model="review_experience" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 bg-white">
                            <option value="">-- Pilih --</option>
                            <option value="Belum pernah">Belum pernah</option>
                            <option value="< 1 tahun">< 1 tahun</option>
                            <option value="1-3 tahun">1-3 tahun</option>
                            <option value="3-5 tahun">3-5 tahun</option>
                            <option value="> 5 tahun">> 5 tahun</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Bidang Penelitian <span class="text-red-500">*</span></label>
                        <textarea wire:model="research_interest" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 resize-none @error(\'research_interest\') border-red-400 @enderror" placeholder="e.g. Pharmaceutical Technology, Pharmacology"></textarea>
                        @error(\'research_interest\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Area Keahlian untuk Review <span class="text-red-500">*</span></label>
                        <textarea wire:model="expertise" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 resize-none @error(\'expertise\') border-red-400 @enderror" placeholder="Area keahlian spesifik yang bisa Anda review"></textarea>
                        @error(\'expertise\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Academic Profiles <span class="text-gray-400 font-normal text-sm">(Optional)</span></h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Scopus Author ID</label>
                        <input type="text" wire:model="scopus_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200" placeholder="e.g. 57200000000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">ORCID ID</label>
                        <input type="text" wire:model="orcid" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200" placeholder="e.g. 0000-0002-1234-5678">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Google Scholar URL</label>
                        <input type="url" wire:model="google_scholar" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error(\'google_scholar\') border-red-400 @enderror" placeholder="https://scholar.google.com/citations?user=...">
                        @error(\'google_scholar\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload CV (PDF/DOC, max 5MB)</label>
                        <input type="file" wire:model="cv_file" accept=".pdf,.doc,.docx" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm @error(\'cv_file\') border-red-400 @enderror">
                        @error(\'cv_file\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        <div wire:loading wire:target="cv_file" class="text-sm text-purple-600 mt-2">Uploading...</div>
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Account Security</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input type="password" wire:model="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error(\'password\') border-red-400 @enderror" placeholder="Minimal 8 karakter">
                        @error(\'password\')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" wire:model="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200" placeholder="Ulangi password">
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-500">Sudah punya akun? <a href="{{ route(\'login\') }}" class="text-purple-600 hover:underline font-medium">Login di sini</a></p>
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 transition disabled:opacity-50" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="register">Daftar sebagai Reviewer</span>
                    <span wire:loading wire:target="register">Processing...</span>
                </button>
            </div>
        </form>
    </div>
    @endif
</div>';

if (file_put_contents($viewFile, $viewContent) !== false) {
    echo "<span style='color:#4ade80'>✓ Created: resources/views/livewire/auth/reviewer-register.blade.php</span>\n";
} else {
    echo "<span style='color:#f87171'>✗ Failed to create view</span>\n";
}

// 4. Check route in web.php
echo "\n<h3 style='color:#fbbf24'>4. CHECK/ADD ROUTE</h3>\n";

$webRoutes = $root . '/routes/web.php';
$routeContent = file_get_contents($webRoutes);

if (str_contains($routeContent, 'register/reviewer')) {
    echo "Route already exists\n";
} else {
    // Add route after verify-certificate route
    $marker = "})->where('code', '.+')->name('verify-certificate');";
    $newRoute = $marker . "\n\n// ─── Reviewer Registration Route ───\nRoute::get('/register/reviewer', \\App\\Livewire\\Auth\\ReviewerRegister::class)->name('register.reviewer');";
    
    $newContent = str_replace($marker, $newRoute, $routeContent);
    if (file_put_contents($webRoutes, $newContent) !== false) {
        echo "<span style='color:#4ade80'>✓ Route added to web.php</span>\n";
    } else {
        echo "<span style='color:#f87171'>✗ Failed to add route</span>\n";
    }
}

// 5. Clear caches
echo "\n<h3 style='color:#fbbf24'>5. CLEAR CACHES</h3>\n";

$cacheFiles = [
    $root . '/bootstrap/cache/config.php',
    $root . '/bootstrap/cache/routes-v7.php',
    $root . '/bootstrap/cache/services.php',
    $root . '/bootstrap/cache/packages.php',
];

foreach ($cacheFiles as $cacheFile) {
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
        echo "Deleted: " . basename($cacheFile) . "\n";
    }
}

// Clear views
$viewCachePath = $root . '/storage/framework/views';
if (is_dir($viewCachePath)) {
    $count = 0;
    foreach (glob($viewCachePath . '/*.php') as $file) {
        unlink($file);
        $count++;
    }
    echo "Deleted: $count view cache files\n";
}

// 6. Verify files
echo "\n<h3 style='color:#fbbf24'>6. VERIFICATION</h3>\n";

$checks = [
    'Component' => $componentFile,
    'View' => $viewFile,
];

$allOk = true;
foreach ($checks as $name => $file) {
    $exists = file_exists($file);
    $size = $exists ? filesize($file) : 0;
    echo "$name: " . ($exists ? "<span style='color:#4ade80'>OK ({$size} bytes)</span>" : "<span style='color:#f87171'>MISSING</span>") . "\n";
    if (!$exists) $allOk = false;
}

if ($allOk) {
    echo "\n<span style='color:#4ade80;font-size:18px'>✓ ALL FILES CREATED!</span>\n";
    echo "\nSekarang coba akses: <a href='/register/reviewer' style='color:#38bdf8'>/register/reviewer</a>\n";
} else {
    echo "\n<span style='color:#f87171;font-size:18px'>✗ Some files are missing!</span>\n";
}

echo "\n<span style='color:#f87171'>HAPUS FILE INI SETELAH SELESAI!</span>\n";
echo "</pre>";
