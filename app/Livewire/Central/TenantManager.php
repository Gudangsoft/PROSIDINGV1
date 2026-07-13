<?php

namespace App\Livewire\Central;

use App\Models\Scopes\VerifiedDomainScope;
use App\Models\Tenant;
use App\Services\TenantProvisioningService;
use Livewire\Component;

class TenantManager extends Component
{
    public string $newId = '';
    public string $newDomain = '';
    public bool $copyFromCentral = false;

    public array $lastLog = [];
    public bool $provisioning = false;

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

    public function render()
    {
        // Admin needs to see pending (unverified) domains too, not just
        // the ones eligible to actually resolve tenant traffic.
        $tenants = Tenant::with(['domains' => function ($query) {
            $query->withoutGlobalScope(VerifiedDomainScope::class);
        }])->orderBy('created_at', 'desc')->get();

        // Same component works from both a central domain (routes/central.php,
        // no tenant context) and a tenant domain (routes/tenant.php, via the
        // "Kelola Tenant" sidebar link) — match whichever shell it's in.
        $layout = tenancy()->initialized ? 'layouts.app' : 'layouts.central';

        return view('livewire.central.tenant-manager', compact('tenants'))
            ->layout($layout);
    }
}
