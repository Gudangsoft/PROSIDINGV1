<?php

namespace App\Livewire\Admin;

use App\Models\Conference;
use App\Models\Deliverable;
use App\Models\Paper;
use App\Models\User;
use App\Services\DocumentGenerator;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CertificateManager extends Component
{
    use WithFileUploads;

    // Selected conference
    public string $conferenceId = '';
    public ?Conference $conference = null;

    // Signatory settings
    public string $chairman_name = '';
    public string $chairman_title = '';
    public string $secretary_name = '';
    public string $secretary_title = '';

    // Institute chairman (3rd signatory)
    public string $institute_chairman_name = '';
    public string $institute_chairman_title = '';

    // Visibility toggles
    public bool $show_chairman = true;
    public bool $show_secretary = true;
    public bool $show_institute_chairman = false;

    // Signature image uploads
    public $chairman_signature_upload = null;
    public $secretary_signature_upload = null;
    public $institute_chairman_signature_upload = null;

    // UI tabs
    public string $activeTab = 'settings';

    // Preview
    public string $previewType = 'author';
    public string $successMessage = '';
    public string $errorMessage = '';

    // Batch generation
    public bool $batchLoading = false;
    public array $batchStats = [];

    // Search/filter for certificate list
    public string $certSearch = '';
    public string $certTypeFilter = '';

    public function mount(): void
    {
        $conf = Conference::where('is_active', true)->first()
            ?? Conference::latest()->first();

        if ($conf) {
            $this->loadConference($conf->id);
        }
    }

    public function updatedConferenceId(string $value): void
    {
        $this->loadConference($value);
    }

    private function loadConference(string $id): void
    {
        $conf = Conference::find($id);
        if (! $conf) {
            return;
        }

        $this->conference    = $conf;
        $this->conferenceId  = (string) $conf->id;
        $this->chairman_name  = $conf->chairman_name ?? '';
        $this->chairman_title = $conf->chairman_title ?? '';
        $this->secretary_name  = $conf->secretary_name ?? '';
        $this->secretary_title = $conf->secretary_title ?? '';
        $this->institute_chairman_name  = $conf->institute_chairman_name ?? '';
        $this->institute_chairman_title = $conf->institute_chairman_title ?? '';
        $this->show_chairman             = $conf->show_chairman ?? true;
        $this->show_secretary            = $conf->show_secretary ?? true;
        $this->show_institute_chairman   = $conf->show_institute_chairman ?? false;
    }

    public function saveSettings(): void
    {
        $this->validate([
            'chairman_name'           => 'nullable|string|max:100',
            'chairman_title'          => 'nullable|string|max:100',
            'secretary_name'          => 'nullable|string|max:100',
            'secretary_title'         => 'nullable|string|max:100',
            'institute_chairman_name'  => 'nullable|string|max:100',
            'institute_chairman_title' => 'nullable|string|max:100',
            'chairman_signature_upload'             => 'nullable|image|max:2048',
            'secretary_signature_upload'            => 'nullable|image|max:2048',
            'institute_chairman_signature_upload'   => 'nullable|image|max:2048',
        ]);

        if (! $this->conference) {
            $this->errorMessage = 'Pilih konferensi terlebih dahulu.';
            return;
        }

        $data = [
            'chairman_name'  => $this->chairman_name,
            'chairman_title' => $this->chairman_title,
            'secretary_name'  => $this->secretary_name,
            'secretary_title' => $this->secretary_title,
            'institute_chairman_name'  => $this->institute_chairman_name,
            'institute_chairman_title' => $this->institute_chairman_title,
            'show_chairman'           => $this->show_chairman,
            'show_secretary'          => $this->show_secretary,
            'show_institute_chairman' => $this->show_institute_chairman,
        ];

        if ($this->chairman_signature_upload) {
            // Remove old
            if ($this->conference->chairman_signature) {
                Storage::disk('public')->delete($this->conference->chairman_signature);
            }
            $data['chairman_signature'] = $this->chairman_signature_upload->storeAs(
                'signatures',
                'chairman-' . $this->conference->id . '.png',
                'public'
            );
            $this->chairman_signature_upload = null;
        }

        if ($this->secretary_signature_upload) {
            if ($this->conference->secretary_signature) {
                Storage::disk('public')->delete($this->conference->secretary_signature);
            }
            $data['secretary_signature'] = $this->secretary_signature_upload->storeAs(
                'signatures',
                'secretary-' . $this->conference->id . '.png',
                'public'
            );
            $this->secretary_signature_upload = null;
        }

        if ($this->institute_chairman_signature_upload) {
            if ($this->conference->institute_chairman_signature) {
                Storage::disk('public')->delete($this->conference->institute_chairman_signature);
            }
            $data['institute_chairman_signature'] = $this->institute_chairman_signature_upload->storeAs(
                'signatures',
                'institute-chairman-' . $this->conference->id . '.png',
                'public'
            );
            $this->institute_chairman_signature_upload = null;
        }

        $this->conference->update($data);
        $this->conference = $this->conference->fresh();

        $this->successMessage = 'Pengaturan sertifikat berhasil disimpan!';
        $this->errorMessage   = '';
    }

    public function deleteSignature(string $role): void
    {
        if (! $this->conference) {
            return;
        }

        $field = $role . '_signature';

        if ($this->conference->$field) {
            Storage::disk('public')->delete($this->conference->$field);
            $this->conference->update([$field => null]);
            $this->conference = $this->conference->fresh();
            $this->successMessage = 'Tanda tangan berhasil dihapus.';
        }
    }

    public function batchGenerate(): void
    {
        if (! $this->conference) {
            $this->errorMessage = 'Pilih konferensi terlebih dahulu.';
            return;
        }

        $this->batchLoading = true;
        $this->batchStats   = [];

        try {
            $generator = new DocumentGenerator();
            $stats     = $generator->batchGenerateCertificates($this->conference);
            $this->batchStats   = $stats;
            $this->successMessage = "Batch selesai: {$stats['authors']} sertifikat dibuat, {$stats['failed']} gagal.";
        } catch (\Exception $e) {
            $this->errorMessage = 'Gagal: ' . $e->getMessage();
        }

        $this->batchLoading = false;
    }

    /**
     * Tarik (hapus) satu sertifikat berdasarkan ID Deliverable.
     */
    public function revokeCertificate(int $deliverableId): void
    {
        $cert = Deliverable::find($deliverableId);

        if (! $cert || $cert->type !== 'certificate') {
            $this->errorMessage = 'Sertifikat tidak ditemukan.';
            return;
        }

        // Hapus file fisik jika ada
        if ($cert->file_path && Storage::disk('public')->exists($cert->file_path)) {
            Storage::disk('public')->delete($cert->file_path);
        }

        $cert->delete();

        $this->successMessage = 'Sertifikat berhasil ditarik.';
        $this->errorMessage   = '';
    }

    /**
     * Tarik semua sertifikat untuk konferensi yang dipilih.
     */
    public function revokeAllCertificates(): void
    {
        if (! $this->conference) {
            $this->errorMessage = 'Pilih konferensi terlebih dahulu.';
            return;
        }

        $certs = Deliverable::where('type', 'certificate')
            ->where('direction', 'admin_send')
            ->whereHas('paper', fn ($q) => $q->where('conference_id', $this->conference->id))
            ->get();

        $count = 0;
        foreach ($certs as $cert) {
            if ($cert->file_path && Storage::disk('public')->exists($cert->file_path)) {
                Storage::disk('public')->delete($cert->file_path);
            }
            $cert->delete();
            $count++;
        }

        $this->batchStats     = [];
        $this->successMessage = "{$count} sertifikat berhasil ditarik.";
        $this->errorMessage   = '';
    }

    public function getCertificatesProperty()
    {
        if (! $this->conference) {
            return collect();
        }

        return Deliverable::with(['user', 'paper'])
            ->where('type', 'certificate')
            ->where('direction', 'admin_send')
            ->whereHas('paper', fn ($q) => $q->where('conference_id', $this->conference->id))
            ->when($this->certSearch, fn ($q) =>
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', '%' . $this->certSearch . '%'))
            )
            ->latest('sent_at')
            ->get();
    }

    public function render()
    {
        $conferences = Conference::orderBy('name')->get();

        return view('livewire.admin.certificate-manager', [
            'conferences'  => $conferences,
            'certificates' => $this->certificates,
        ])->layout('layouts.app');
    }
}
