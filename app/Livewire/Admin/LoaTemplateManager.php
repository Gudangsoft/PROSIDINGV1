<?php

namespace App\Livewire\Admin;

use App\Models\Conference;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class LoaTemplateManager extends Component
{
    use WithFileUploads;

    // Conference selection
    public string $conferenceId = '';
    public ?Conference $conference = null;

    // Header fields
    public $loa_header_logo_upload = null;
    public string $loa_header_title = '';
    public string $loa_header_subtitle = '';
    public string $loa_header_address = '';
    public string $loa_header_phone = '';
    public string $loa_header_fax = '';
    public string $loa_header_email = '';

    // Body fields
    public string $loa_body_intro = '';
    public string $loa_body_acceptance = '';
    public array $loa_important_dates = [];
    public string $loa_body_submission_info = '';
    public string $loa_payment_info = '';
    public string $loa_contact_info = '';
    public string $loa_closing_text = '';

    // Signature fields
    public string $loa_signatory_name = '';
    public string $loa_signatory_title = '';
    public $loa_signature_image_upload = null;

    // Footer
    public string $loa_footer_text = '';

    // UI state
    public string $activeTab = 'header';
    public string $successMessage = '';
    public string $errorMessage = '';

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
        if (!$conf) {
            return;
        }

        $this->conference = $conf;
        $this->conferenceId = (string) $conf->id;

        // Load header
        $this->loa_header_title = $conf->loa_header_title ?? '';
        $this->loa_header_subtitle = $conf->loa_header_subtitle ?? '';
        $this->loa_header_address = $conf->loa_header_address ?? '';
        $this->loa_header_phone = $conf->loa_header_phone ?? '';
        $this->loa_header_fax = $conf->loa_header_fax ?? '';
        $this->loa_header_email = $conf->loa_header_email ?? '';

        // Load body
        $this->loa_body_intro = $conf->loa_body_intro ?? $this->getDefaultIntro();
        $this->loa_body_acceptance = $conf->loa_body_acceptance ?? $this->getDefaultAcceptance();
        $this->loa_important_dates = $conf->loa_important_dates ?? [];
        $this->loa_body_submission_info = $conf->loa_body_submission_info ?? $this->getDefaultSubmissionInfo();
        $this->loa_payment_info = $conf->loa_payment_info ?? '';
        $this->loa_contact_info = $conf->loa_contact_info ?? '';
        $this->loa_closing_text = $conf->loa_closing_text ?? $this->getDefaultClosing();

        // Load signature
        $this->loa_signatory_name = $conf->loa_signatory_name ?? '';
        $this->loa_signatory_title = $conf->loa_signatory_title ?? '';

        // Load footer
        $this->loa_footer_text = $conf->loa_footer_text ?? '';
    }

    // ── Important Dates Management ──

    public function addImportantDate(): void
    {
        $this->loa_important_dates[] = ['label' => '', 'date' => ''];
    }

    public function removeImportantDate(int $index): void
    {
        unset($this->loa_important_dates[$index]);
        $this->loa_important_dates = array_values($this->loa_important_dates);
    }

    // ── Save Methods ──

    public function saveHeader(): void
    {
        $this->validate([
            'loa_header_title'         => 'nullable|string|max:500',
            'loa_header_subtitle'      => 'nullable|string|max:2000',
            'loa_header_address'       => 'nullable|string|max:500',
            'loa_header_phone'         => 'nullable|string|max:255',
            'loa_header_fax'           => 'nullable|string|max:255',
            'loa_header_email'         => 'nullable|string|max:255',
            'loa_header_logo_upload'   => 'nullable|image|max:5120',
        ]);

        if (!$this->conference) {
            $this->errorMessage = 'Pilih konferensi terlebih dahulu.';
            return;
        }

        $data = [
            'loa_header_title'    => $this->loa_header_title,
            'loa_header_subtitle' => $this->loa_header_subtitle,
            'loa_header_address'  => $this->loa_header_address,
            'loa_header_phone'    => $this->loa_header_phone,
            'loa_header_fax'      => $this->loa_header_fax,
            'loa_header_email'    => $this->loa_header_email,
        ];

        if ($this->loa_header_logo_upload) {
            if ($this->conference->loa_header_logo) {
                Storage::disk('public')->delete($this->conference->loa_header_logo);
            }
            $data['loa_header_logo'] = $this->loa_header_logo_upload->storeAs(
                'loa-templates',
                'header-logo-' . $this->conference->id . '.' . $this->loa_header_logo_upload->getClientOriginalExtension(),
                'public'
            );
            $this->loa_header_logo_upload = null;
        }

        $this->conference->update($data);
        $this->conference = $this->conference->fresh();

        $this->successMessage = 'Header LOA berhasil disimpan!';
        $this->errorMessage = '';
    }

    public function saveBody(): void
    {
        if (!$this->conference) {
            $this->errorMessage = 'Pilih konferensi terlebih dahulu.';
            return;
        }

        $this->conference->update([
            'loa_body_intro'          => $this->loa_body_intro,
            'loa_body_acceptance'     => $this->loa_body_acceptance,
            'loa_important_dates'     => $this->loa_important_dates,
            'loa_body_submission_info'=> $this->loa_body_submission_info,
            'loa_payment_info'        => $this->loa_payment_info,
            'loa_contact_info'        => $this->loa_contact_info,
            'loa_closing_text'        => $this->loa_closing_text,
        ]);
        $this->conference = $this->conference->fresh();

        $this->successMessage = 'Konten LOA berhasil disimpan!';
        $this->errorMessage = '';
    }

    public function saveSignature(): void
    {
        $this->validate([
            'loa_signatory_name'          => 'nullable|string|max:255',
            'loa_signatory_title'         => 'nullable|string|max:255',
            'loa_signature_image_upload'  => 'nullable|image|max:5120',
        ]);

        if (!$this->conference) {
            $this->errorMessage = 'Pilih konferensi terlebih dahulu.';
            return;
        }

        $data = [
            'loa_signatory_name'  => $this->loa_signatory_name,
            'loa_signatory_title' => $this->loa_signatory_title,
            'loa_footer_text'     => $this->loa_footer_text,
        ];

        if ($this->loa_signature_image_upload) {
            if ($this->conference->loa_signature_image) {
                Storage::disk('public')->delete($this->conference->loa_signature_image);
            }
            $data['loa_signature_image'] = $this->loa_signature_image_upload->storeAs(
                'loa-templates',
                'signature-' . $this->conference->id . '.' . $this->loa_signature_image_upload->getClientOriginalExtension(),
                'public'
            );
            $this->loa_signature_image_upload = null;
        }

        $this->conference->update($data);
        $this->conference = $this->conference->fresh();

        $this->successMessage = 'Tanda tangan & footer berhasil disimpan!';
        $this->errorMessage = '';
    }

    public function deleteHeaderLogo(): void
    {
        if (!$this->conference || !$this->conference->loa_header_logo) {
            return;
        }

        Storage::disk('public')->delete($this->conference->loa_header_logo);
        $this->conference->update(['loa_header_logo' => null]);
        $this->conference = $this->conference->fresh();
        $this->successMessage = 'Logo header LOA berhasil dihapus.';
    }

    public function deleteSignatureImage(): void
    {
        if (!$this->conference || !$this->conference->loa_signature_image) {
            return;
        }

        Storage::disk('public')->delete($this->conference->loa_signature_image);
        $this->conference->update(['loa_signature_image' => null]);
        $this->conference = $this->conference->fresh();
        $this->successMessage = 'Gambar tanda tangan berhasil dihapus.';
    }

    public function loadDefaults(): void
    {
        $this->loa_body_intro = $this->getDefaultIntro();
        $this->loa_body_acceptance = $this->getDefaultAcceptance();
        $this->loa_body_submission_info = $this->getDefaultSubmissionInfo();
        $this->loa_closing_text = $this->getDefaultClosing();
        $this->successMessage = 'Teks default berhasil dimuat. Jangan lupa simpan!';
    }

    // ── Default Templates ──

    private function getDefaultIntro(): string
    {
        return "Dear Author(s),\nWe are pleased to inform you that your paper entitled";
    }

    private function getDefaultAcceptance(): string
    {
        $name = $this->conference->name ?? 'the Conference';
        $date = $this->conference->start_date ? $this->conference->start_date->format('F d, Y') : '[Conference Date]';
        return "has been accepted for oral presentation at the {$name}, which scheduled to be held on {$date}.";
    }

    private function getDefaultSubmissionInfo(): string
    {
        return "Full Paper must be written in English and submitted via the Online Submission at:\nhttps://conference.stifar.ac.id/. Please ensure that the manuscript adheres to the official conference template.";
    }

    private function getDefaultClosing(): string
    {
        return "We look forward to your valuable contribution and participation in the conference.";
    }

    public function render()
    {
        $conferences = Conference::orderBy('name')->get();

        return view('livewire.admin.loa-template-manager', [
            'conferences' => $conferences,
        ])->layout('layouts.app');
    }
}
