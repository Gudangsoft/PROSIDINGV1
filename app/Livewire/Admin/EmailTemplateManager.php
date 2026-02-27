<?php

namespace App\Livewire\Admin;

use App\Models\Conference;
use App\Models\EmailAsset;
use App\Models\EmailTemplate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmailTemplateManager extends Component
{
    use WithFileUploads;

    public ?int $selectedConferenceId = null;
    public array $emailTemplates = [];

    // ── Asset CRUD state ─────────────────────────────
    public array  $assets        = [];
    public ?int   $editingAssetId = null;
    public string $assetName     = '';
    public string $assetType     = 'link';
    public string $assetUrl      = '';
    public string $assetDesc     = '';
    public bool   $assetGlobal   = false;
    public $assetFile            = null;   // Livewire temp file

    public function mount()
    {
        $conferences = Conference::orderByDesc('id')->get();
        if ($conferences->count() === 1) {
            $this->selectedConferenceId = $conferences->first()->id;
            $this->loadTemplates();
            $this->loadAssets();
        }
    }

    public function updatedSelectedConferenceId()
    {
        $this->loadTemplates();
        $this->loadAssets();
        $this->resetAssetForm();
    }

    // ── Templates ─────────────────────────────────────

    public function loadTemplates()
    {
        if (!$this->selectedConferenceId) {
            $this->emailTemplates = [];
            return;
        }

        $saved = EmailTemplate::where('conference_id', $this->selectedConferenceId)
            ->get()
            ->keyBy('key');

        $this->emailTemplates = [];
        foreach (EmailTemplate::TYPES as $key => $cfg) {
            $row = $saved->get($key);
            $this->emailTemplates[$key] = [
                'id'        => $row?->id,
                'subject'   => $row?->subject ?? '',
                'body'      => $row?->body ?? '',
                'is_active' => $row ? (bool) $row->is_active : true,
            ];
        }
    }

    public function save()
    {
        if (!$this->selectedConferenceId) {
            session()->flash('error', 'Pilih kegiatan terlebih dahulu.');
            return;
        }

        foreach ($this->emailTemplates as $key => $tpl) {
            if (empty(trim($tpl['subject'] ?? '')) && empty(trim($tpl['body'] ?? ''))) {
                if (!empty($tpl['id'])) {
                    EmailTemplate::find($tpl['id'])?->delete();
                }
                continue;
            }
            EmailTemplate::updateOrCreate(
                ['conference_id' => $this->selectedConferenceId, 'key' => $key],
                [
                    'subject'   => $tpl['subject'] ?? '',
                    'body'      => $tpl['body'] ?? '',
                    'is_active' => (bool) ($tpl['is_active'] ?? true),
                ]
            );
        }

        session()->flash('success', 'Template email berhasil disimpan.');
        $this->loadTemplates();
    }

    public function resetTemplate(string $key)
    {
        if (!empty($this->emailTemplates[$key]['id'])) {
            EmailTemplate::find($this->emailTemplates[$key]['id'])?->delete();
        }
        $this->emailTemplates[$key] = [
            'id'        => null,
            'subject'   => '',
            'body'      => '',
            'is_active' => true,
        ];
        session()->flash('success', 'Template "' . (EmailTemplate::TYPES[$key]['label'] ?? $key) . '" direset ke default.');
    }

    // ── Asset CRUD ────────────────────────────────────

    public function loadAssets()
    {
        $this->assets = EmailAsset::forConference($this->selectedConferenceId)
            ->map(fn ($a) => [
                'id'          => $a->id,
                'name'        => $a->name,
                'type'        => $a->type,
                'url'         => $a->publicUrl(),
                'description' => $a->description,
                'is_global'   => $a->is_global,
            ])
            ->toArray();
    }

    public function editAsset(int $id)
    {
        $asset = EmailAsset::find($id);
        if (!$asset) return;
        $this->editingAssetId = $id;
        $this->assetName      = $asset->name;
        $this->assetType      = $asset->type;
        $this->assetUrl       = $asset->type === 'link' ? $asset->url : '';
        $this->assetDesc      = $asset->description ?? '';
        $this->assetGlobal    = $asset->is_global;
        $this->assetFile      = null;
    }

    public function saveAsset()
    {
        $this->validate([
            'assetName' => 'required|string|max:255',
            'assetType' => 'required|in:link,file',
            'assetUrl'  => $this->assetType === 'link' ? 'required|url|max:1000' : 'nullable',
            'assetFile' => $this->assetType === 'file' && !$this->editingAssetId ? 'required|file|max:10240' : 'nullable|file|max:10240',
            'assetDesc' => 'nullable|string|max:500',
        ], [], [
            'assetName' => 'Nama',
            'assetUrl'  => 'URL',
            'assetFile' => 'File',
        ]);

        $data = [
            'conference_id' => $this->assetGlobal ? null : $this->selectedConferenceId,
            'name'          => $this->assetName,
            'type'          => $this->assetType,
            'description'   => $this->assetDesc ?: null,
            'is_global'     => $this->assetGlobal,
        ];

        if ($this->assetType === 'link') {
            $data['url'] = $this->assetUrl;
        } elseif ($this->assetFile) {
            $data['url'] = $this->assetFile->store('email-assets', 'public');
        }

        if ($this->editingAssetId) {
            $asset = EmailAsset::find($this->editingAssetId);
            if ($asset) {
                // Keep old file path if no new file was uploaded
                if ($this->assetType === 'file' && !$this->assetFile) {
                    unset($data['url']);
                }
                $asset->update($data);
            }
        } else {
            EmailAsset::create($data);
        }

        $this->resetAssetForm();
        $this->loadAssets();
        session()->flash('assetSuccess', $this->editingAssetId ? 'Asset diperbarui.' : 'Asset ditambahkan.');
    }

    public function deleteAsset(int $id)
    {
        $asset = EmailAsset::find($id);
        if ($asset) {
            if ($asset->type === 'file') {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($asset->url);
            }
            $asset->delete();
        }
        $this->loadAssets();
        session()->flash('assetSuccess', 'Asset dihapus.');
    }

    public function resetAssetForm()
    {
        $this->editingAssetId = null;
        $this->assetName      = '';
        $this->assetType      = 'link';
        $this->assetUrl       = '';
        $this->assetDesc      = '';
        $this->assetGlobal    = false;
        $this->assetFile      = null;
    }

    public function render()
    {
        return view('livewire.admin.email-template-manager', [
            'conferences' => Conference::orderByDesc('id')->get(['id', 'name', 'acronym']),
            'emailTypes'  => EmailTemplate::TYPES,
        ])->layout('layouts.app');
    }
}

