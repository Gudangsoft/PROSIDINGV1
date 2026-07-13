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
            'newId' => ['required', 'string', 'max:63', 'regex:/^[a-z0-9-]+$/', 'unique:tenants,id'],
            'newDomain' => ['required', 'string', 'max:255'],
        ];
    }

    protected $messages = [
        'newId.regex' => 'ID tenant cuma boleh huruf kecil, angka, dan tanda minus (mis. sinacon, kampus-abc).',
        'newId.unique' => 'ID tenant ini sudah dipakai.',
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

        return view('livewire.central.tenant-manager', compact('tenants'))
            ->layout('layouts.central');
    }
}
