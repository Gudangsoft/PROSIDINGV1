<?php

namespace App\Livewire\Central;

use App\Models\Domain;
use App\Models\Scopes\VerifiedDomainScope;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantProvisioningService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class TenantManager extends Component
{
    public string $search = '';

    // Create tenant form
    public string $newId = '';
    public string $newDomain = '';
    public bool $copyFromCentral = false;
    public string $adminName = '';
    public string $adminEmail = '';
    public string $adminPassword = '';
    public array $lastLog = [];
    public bool $provisioning = false;

    // Add domain to an existing tenant
    public ?string $addDomainTenantId = null;
    public string $addDomainValue = '';

    // Edit an existing domain
    public ?int $editingDomainId = null;
    public string $editDomainValue = '';

    // Manage admins (list + add + edit) for an existing tenant
    public ?string $addAdminTenantId = null;
    public array $tenantAdmins = [];
    public string $addAdminName = '';
    public string $addAdminEmail = '';
    public string $addAdminPassword = '';

    // Edit an existing admin within the open manage-admins panel
    public ?int $editingAdminId = null;
    public string $editAdminName = '';
    public string $editAdminEmail = '';
    public string $editAdminPassword = '';

    // Delete confirmation
    public ?string $confirmingDeleteId = null;
    public string $deleteConfirmText = '';

    protected function rules(): array
    {
        return [
            // No 'unique:tenants,id' here on purpose: that string rule
            // resolves against whatever DB connection is currently
            // default, which is the TENANT's connection when this page is
            // accessed via a tenant domain (App\Models\Tenant itself always
            // forces the central connection, but raw validation strings
            // don't). TenantProvisioningService already handles an existing
            // id gracefully (reuses it), so this isn't needed for
            // correctness — just skip straight to provisioning.
            'newId' => ['required', 'string', 'max:63', 'regex:/^[a-z0-9-]+$/'],
            'newDomain' => ['required', 'string', 'max:255'],
            // All three optional as a group, but filling any one requires
            // the other two — either create a full admin account or none.
            'adminName' => ['nullable', 'required_with:adminEmail,adminPassword', 'string', 'max:255'],
            'adminEmail' => ['nullable', 'required_with:adminName,adminPassword', 'email', 'max:255'],
            'adminPassword' => ['nullable', 'required_with:adminName,adminEmail', 'string', 'min:8'],
        ];
    }

    protected $messages = [
        'newId.regex' => 'ID tenant cuma boleh huruf kecil, angka, dan tanda minus (mis. sinacon, kampus-abc).',
        'newDomain.required' => 'Domain wajib diisi.',
        'adminName.required_with' => 'Isi nama, email, dan password admin sekaligus (atau kosongkan ketiganya).',
        'adminEmail.required_with' => 'Isi nama, email, dan password admin sekaligus (atau kosongkan ketiganya).',
        'adminPassword.required_with' => 'Isi nama, email, dan password admin sekaligus (atau kosongkan ketiganya).',
        'adminPassword.min' => 'Password admin minimal 8 karakter.',
    ];

    public function create(TenantProvisioningService $service)
    {
        $this->validate();

        $this->provisioning = true;

        try {
            $result = $service->provision($this->newId, $this->newDomain, $this->copyFromCentral);
            $this->lastLog = $result['log'];

            if ($this->adminEmail !== '') {
                $this->lastLog = array_merge($this->lastLog, $this->createAdminUser(
                    $result['tenant'], $this->adminName, $this->adminEmail, $this->adminPassword
                ));
            }

            session()->flash('success', "Tenant '{$this->newId}' berhasil di-provision.");
            $this->reset(['newId', 'newDomain', 'copyFromCentral', 'adminName', 'adminEmail', 'adminPassword']);
        } catch (\Throwable $e) {
            $this->lastLog = ["ERROR: " . $e->getMessage()];
            $this->addError('newId', 'Provisioning gagal — lihat detail di bawah form.');
        }

        $this->provisioning = false;
    }

    /**
     * @return string[]
     */
    private function createAdminUser(Tenant $tenant, string $name, string $email, string $password): array
    {
        $log = [];

        // Must always end() even if User::create() throws below — this runs
        // inside the same web request that's rendering this very page, so
        // leaving tenancy switched to the newly created tenant would corrupt
        // the rest of this request (e.g. this page re-rendering against the
        // wrong tenant's database afterwards).
        tenancy()->initialize($tenant);
        try {
            if (User::where('email', $email)->exists()) {
                $log[] = "  User admin '{$email}' sudah ada — dilewati.";
            } else {
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                ]);
                $log[] = "  User admin '{$email}' dibuat.";
            }
        } finally {
            tenancy()->end();
        }

        return $log;
    }

    /**
     * @return array<int, array{id: int, name: string, email: string}>
     */
    private function loadTenantAdmins(Tenant $tenant): array
    {
        tenancy()->initialize($tenant);
        try {
            return User::where('role', 'admin')
                ->orderBy('name')
                ->get(['id', 'name', 'email'])
                ->map(fn ($u) => ['id' => $u->id, 'name' => $u->name, 'email' => $u->email])
                ->all();
        } finally {
            tenancy()->end();
        }
    }

    public function startAddAdmin(string $tenantId)
    {
        $this->addAdminTenantId = $tenantId;
        $this->addAdminName = '';
        $this->addAdminEmail = '';
        $this->addAdminPassword = '';
        $this->editingAdminId = null;
        $this->resetErrorBag(['addAdminName', 'addAdminEmail', 'addAdminPassword']);

        $this->tenantAdmins = $this->loadTenantAdmins(Tenant::findOrFail($tenantId));
    }

    public function cancelAddAdmin()
    {
        $this->addAdminTenantId = null;
        $this->addAdminName = '';
        $this->addAdminEmail = '';
        $this->addAdminPassword = '';
        $this->tenantAdmins = [];
        $this->editingAdminId = null;
    }

    public function addAdmin()
    {
        $this->validate([
            'addAdminName' => ['required', 'string', 'max:255'],
            'addAdminEmail' => ['required', 'email', 'max:255'],
            'addAdminPassword' => ['required', 'string', 'min:8'],
        ], [
            'addAdminName.required' => 'Nama wajib diisi.',
            'addAdminEmail.required' => 'Email wajib diisi.',
            'addAdminPassword.required' => 'Password wajib diisi.',
            'addAdminPassword.min' => 'Password minimal 8 karakter.',
        ]);

        $tenant = Tenant::findOrFail($this->addAdminTenantId);

        $log = $this->createAdminUser($tenant, $this->addAdminName, $this->addAdminEmail, $this->addAdminPassword);

        session()->flash('success', trim(implode(' ', $log)) ?: "Admin ditambahkan ke tenant '{$tenant->id}'.");

        $this->addAdminName = '';
        $this->addAdminEmail = '';
        $this->addAdminPassword = '';
        $this->tenantAdmins = $this->loadTenantAdmins($tenant);
    }

    public function startEditAdmin(int $userId)
    {
        $admin = collect($this->tenantAdmins)->firstWhere('id', $userId);
        if (! $admin) {
            return;
        }

        $this->editingAdminId = $userId;
        $this->editAdminName = $admin['name'];
        $this->editAdminEmail = $admin['email'];
        $this->editAdminPassword = '';
        $this->resetErrorBag(['editAdminName', 'editAdminEmail', 'editAdminPassword']);
    }

    public function cancelEditAdmin()
    {
        $this->editingAdminId = null;
        $this->editAdminName = '';
        $this->editAdminEmail = '';
        $this->editAdminPassword = '';
    }

    public function updateAdmin()
    {
        $this->validate([
            'editAdminName' => ['required', 'string', 'max:255'],
            'editAdminEmail' => ['required', 'email', 'max:255'],
            'editAdminPassword' => ['nullable', 'string', 'min:8'],
        ], [
            'editAdminName.required' => 'Nama wajib diisi.',
            'editAdminEmail.required' => 'Email wajib diisi.',
            'editAdminPassword.min' => 'Password minimal 8 karakter (kosongkan kalau tidak mau ganti password).',
        ]);

        $tenant = Tenant::findOrFail($this->addAdminTenantId);

        tenancy()->initialize($tenant);
        try {
            $user = User::findOrFail($this->editingAdminId);

            $emailTaken = User::where('email', $this->editAdminEmail)->where('id', '!=', $user->id)->exists();
            if ($emailTaken) {
                tenancy()->end();
                $this->addError('editAdminEmail', 'Email ini sudah dipakai user lain di tenant yang sama.');
                return;
            }

            $user->name = $this->editAdminName;
            $user->email = $this->editAdminEmail;
            if ($this->editAdminPassword !== '') {
                $user->password = Hash::make($this->editAdminPassword);
            }
            $user->save();
        } finally {
            if (tenancy()->initialized) {
                tenancy()->end();
            }
        }

        session()->flash('success', "Admin '{$this->editAdminEmail}' berhasil diperbarui.");
        $this->cancelEditAdmin();
        $this->tenantAdmins = $this->loadTenantAdmins($tenant);
    }

    public function deleteAdmin(int $userId)
    {
        $tenant = Tenant::findOrFail($this->addAdminTenantId);

        if (count($this->tenantAdmins) <= 1) {
            session()->flash('error', 'Tidak bisa hapus admin terakhir di tenant ini — tenant akan terkunci tanpa admin.');
            return;
        }

        tenancy()->initialize($tenant);
        try {
            User::where('id', $userId)->delete();
        } finally {
            tenancy()->end();
        }

        session()->flash('success', 'Admin dihapus.');
        $this->tenantAdmins = $this->loadTenantAdmins($tenant);
    }

    /**
     * Signs the current central-admin session into a tenant's own admin
     * account and redirects there. Sessions are scoped per domain (each
     * tenant's session storage is suffixed separately), so this can't just
     * copy the current session across — instead it builds a short-lived
     * signed URL for the target domain; the target's own tenant.login-as
     * route verifies the signature (via APP_KEY, shared across every
     * domain/tenant on this installation) and logs the admin in there.
     */
    public function loginAsAdmin(string $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);

        $domain = $tenant->domains()->whereNotNull('verified_at')->first();
        if (! $domain) {
            session()->flash('error', "Tenant '{$tenantId}' belum punya domain terverifikasi untuk login.");
            return;
        }

        tenancy()->initialize($tenant);
        try {
            $admin = User::where('role', 'admin')->first();
        } finally {
            tenancy()->end();
        }

        if (! $admin) {
            session()->flash('error', "Tenant '{$tenantId}' belum punya user admin. Tambahkan admin dulu lewat \"+ Tambah admin\".");
            return;
        }

        $signedPath = URL::temporarySignedRoute(
            'tenant.login-as',
            now()->addSeconds(60),
            ['user' => $admin->id],
            absolute: false
        );

        $this->redirect('https://' . $domain->domain . $signedPath, navigate: false);
    }

    public function startAddDomain(string $tenantId)
    {
        $this->addDomainTenantId = $tenantId;
        $this->addDomainValue = '';
        $this->resetErrorBag('addDomainValue');
    }

    public function cancelAddDomain()
    {
        $this->addDomainTenantId = null;
        $this->addDomainValue = '';
    }

    public function addDomain()
    {
        $this->validate([
            'addDomainValue' => ['required', 'string', 'max:255'],
        ], [
            'addDomainValue.required' => 'Domain wajib diisi.',
        ]);

        $domainName = TenantProvisioningService::normalizeDomain($this->addDomainValue);

        $tenant = Tenant::findOrFail($this->addDomainTenantId);

        $exists = Domain::withoutGlobalScope(VerifiedDomainScope::class)
            ->where('domain', $domainName)
            ->exists();

        if ($exists) {
            $this->addError('addDomainValue', 'Domain ini sudah terdaftar (di tenant manapun).');
            return;
        }

        $tenant->domains()->create(['domain' => $domainName]);

        session()->flash('success', "Domain '{$domainName}' ditambahkan ke tenant '{$tenant->id}'. Menunggu verifikasi DNS.");
        $this->cancelAddDomain();
    }

    public function verifyDomainNow(int $domainId)
    {
        $domain = Domain::withoutGlobalScope(VerifiedDomainScope::class)->findOrFail($domainId);
        $domain->markVerified();

        session()->flash('success', "Domain '{$domain->domain}' ditandai terverifikasi.");
    }

    public function checkDomainDns(int $domainId)
    {
        $domain = Domain::withoutGlobalScope(VerifiedDomainScope::class)->findOrFail($domainId);

        if ($domain->dnsRecordMatches()) {
            $domain->markVerified();
            session()->flash('success', "DNS cocok — domain '{$domain->domain}' otomatis terverifikasi.");
        } else {
            session()->flash('error', "Record TXT untuk '{$domain->domain}' belum ditemukan/cocok. Coba lagi setelah DNS di-set.");
        }
    }

    public function startEditDomain(int $domainId)
    {
        $domain = Domain::withoutGlobalScope(VerifiedDomainScope::class)->findOrFail($domainId);
        $this->editingDomainId = $domainId;
        $this->editDomainValue = $domain->domain;
        $this->resetErrorBag('editDomainValue');
    }

    public function cancelEditDomain()
    {
        $this->editingDomainId = null;
        $this->editDomainValue = '';
    }

    public function updateDomain()
    {
        $this->validate([
            'editDomainValue' => ['required', 'string', 'max:255'],
        ], [
            'editDomainValue.required' => 'Domain wajib diisi.',
        ]);

        $domainName = TenantProvisioningService::normalizeDomain($this->editDomainValue);
        $domain = Domain::withoutGlobalScope(VerifiedDomainScope::class)->findOrFail($this->editingDomainId);

        $exists = Domain::withoutGlobalScope(VerifiedDomainScope::class)
            ->where('domain', $domainName)
            ->where('id', '!=', $domain->id)
            ->exists();

        if ($exists) {
            $this->addError('editDomainValue', 'Domain ini sudah terdaftar (di tenant manapun).');
            return;
        }

        $changed = $domainName !== $domain->domain;
        $domain->domain = $domainName;
        if ($changed) {
            // Domain identity changed — re-verification required, same as
            // adding a brand new domain, so it can't silently start serving
            // traffic for a host nobody actually confirmed ownership of.
            $domain->verified_at = null;
            $domain->verification_token = null;
        }
        $domain->save();

        session()->flash('success', $changed
            ? "Domain diubah jadi '{$domainName}'. Menunggu verifikasi ulang."
            : "Domain '{$domainName}' disimpan (tidak berubah).");
        $this->cancelEditDomain();
    }

    public function deleteDomain(int $domainId)
    {
        $domain = Domain::withoutGlobalScope(VerifiedDomainScope::class)->findOrFail($domainId);
        $tenant = $domain->tenant;

        if ($tenant->domains()->count() <= 1) {
            session()->flash('error', 'Tidak bisa hapus satu-satunya domain tenant ini — tenant akan tidak bisa diakses sama sekali. Tambahkan domain lain dulu kalau memang mau ganti.');
            return;
        }

        $domainName = $domain->domain;
        $domain->delete();

        session()->flash('success', "Domain '{$domainName}' dihapus dari tenant '{$tenant->id}'.");
    }

    public function confirmDelete(string $tenantId)
    {
        $this->confirmingDeleteId = $tenantId;
        $this->deleteConfirmText = '';
    }

    public function cancelDelete()
    {
        $this->confirmingDeleteId = null;
        $this->deleteConfirmText = '';
    }

    public function deleteTenant()
    {
        if ($this->deleteConfirmText !== $this->confirmingDeleteId) {
            $this->addError('deleteConfirmText', 'Ketik ID tenant dengan tepat untuk konfirmasi.');
            return;
        }

        $tenant = Tenant::findOrFail($this->confirmingDeleteId);
        $id = $tenant->id;
        $tenant->delete(); // cascades: domains removed, tenant database dropped

        session()->flash('success', "Tenant '{$id}' dan database-nya telah dihapus permanen.");
        $this->cancelDelete();
    }

    public function render()
    {
        // Admin needs to see pending (unverified) domains too, not just
        // the ones eligible to actually resolve tenant traffic.
        $tenants = Tenant::with(['domains' => function ($query) {
            $query->withoutGlobalScope(VerifiedDomainScope::class);
        }])
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';
                $query->where('id', 'like', $term)
                    ->orWhereHas('domains', function ($q) use ($term) {
                        $q->withoutGlobalScope(VerifiedDomainScope::class)->where('domain', 'like', $term);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $allDomains = Domain::withoutGlobalScope(VerifiedDomainScope::class)->get();

        $stats = [
            'tenants' => Tenant::count(),
            'verified' => $allDomains->whereNotNull('verified_at')->count(),
            'pending' => $allDomains->whereNull('verified_at')->count(),
        ];

        // Same component works from both a central domain (routes/central.php,
        // no tenant context) and a tenant domain (routes/tenant.php, via the
        // "Kelola Tenant" sidebar link) — match whichever shell it's in.
        $layout = tenancy()->initialized ? 'layouts.app' : 'layouts.central';

        return view('livewire.central.tenant-manager', compact('tenants', 'stats'))
            ->layout($layout);
    }
}
