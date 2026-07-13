<?php

namespace App\Livewire\Central;

use App\Models\Domain;
use App\Models\Scopes\VerifiedDomainScope;
use App\Models\Tenant;
use App\Services\TenantProvisioningService;
use Livewire\Component;

class TenantManager extends Component
{
    public string $search = '';

    // Create tenant form
    public string $newId = '';
    public string $newDomain = '';
    public bool $copyFromCentral = false;
    public array $lastLog = [];
    public bool $provisioning = false;

    // Add domain to an existing tenant
    public ?string $addDomainTenantId = null;
    public string $addDomainValue = '';

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
        ];
    }

    protected $messages = [
        'newId.regex' => 'ID tenant cuma boleh huruf kecil, angka, dan tanda minus (mis. sinacon, kampus-abc).',
        'newDomain.required' => 'Domain wajib diisi.',
    ];

    public function create(TenantProvisioningService $service)
    {
        $this->validate();

        $this->provisioning = true;

        try {
            $result = $service->provision($this->newId, $this->newDomain, $this->copyFromCentral);
            $this->lastLog = $result['log'];
            session()->flash('success', "Tenant '{$this->newId}' berhasil di-provision.");
            $this->reset(['newId', 'newDomain', 'copyFromCentral']);
        } catch (\Throwable $e) {
            $this->lastLog = ["ERROR: " . $e->getMessage()];
            $this->addError('newId', 'Provisioning gagal — lihat detail di bawah form.');
        }

        $this->provisioning = false;
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

        $tenant = Tenant::findOrFail($this->addDomainTenantId);

        $exists = Domain::withoutGlobalScope(VerifiedDomainScope::class)
            ->where('domain', $this->addDomainValue)
            ->exists();

        if ($exists) {
            $this->addError('addDomainValue', 'Domain ini sudah terdaftar (di tenant manapun).');
            return;
        }

        $tenant->domains()->create(['domain' => $this->addDomainValue]);

        session()->flash('success', "Domain '{$this->addDomainValue}' ditambahkan ke tenant '{$tenant->id}'. Menunggu verifikasi DNS.");
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
