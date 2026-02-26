<?php

namespace App\Livewire\Admin;

use App\Models\Tutorial;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TutorialManager extends Component
{
    use WithFileUploads;

    // Form fields
    public ?int $editingId = null;
    public string $title = '';
    public string $content = '';
    public string $pdf_label = 'Download Panduan PDF';
    public $pdfFile = null;
    public int $sort_order = 0;
    public bool $is_active = true;

    public bool $showForm = false;
    public string $successMessage = '';
    public string $deleteConfirmId = '';

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $tutorial = Tutorial::findOrFail($id);
        $this->editingId   = $id;
        $this->title       = $tutorial->title;
        $this->content     = $tutorial->content ?? '';
        $this->pdf_label   = $tutorial->pdf_label ?? 'Download Panduan PDF';
        $this->sort_order  = $tutorial->sort_order;
        $this->is_active   = $tutorial->is_active;
        $this->pdfFile     = null;
        $this->showForm    = true;
    }

    public function save(): void
    {
        $this->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'nullable|string',
            'pdf_label'  => 'nullable|string|max:100',
            'sort_order' => 'integer|min:0',
            'pdfFile'    => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $data = [
            'title'      => $this->title,
            'content'    => $this->content,
            'pdf_label'  => $this->pdf_label ?: 'Download Panduan PDF',
            'sort_order' => $this->sort_order,
            'is_active'  => $this->is_active,
        ];

        if ($this->pdfFile) {
            // Delete old PDF if editing
            if ($this->editingId) {
                $old = Tutorial::find($this->editingId)?->pdf_path;
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $data['pdf_path'] = $this->pdfFile->store('tutorials', 'public');
        }

        if ($this->editingId) {
            Tutorial::findOrFail($this->editingId)->update($data);
            $this->successMessage = 'Tutorial berhasil diperbarui.';
        } else {
            Tutorial::create($data);
            $this->successMessage = 'Tutorial berhasil ditambahkan.';
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function toggleActive(int $id): void
    {
        $t = Tutorial::findOrFail($id);
        $t->update(['is_active' => ! $t->is_active]);
    }

    public function delete(int $id): void
    {
        $t = Tutorial::findOrFail($id);
        if ($t->pdf_path) {
            Storage::disk('public')->delete($t->pdf_path);
        }
        $t->delete();
        $this->successMessage = 'Tutorial berhasil dihapus.';
    }

    private function resetForm(): void
    {
        $this->editingId  = null;
        $this->title      = '';
        $this->content    = '';
        $this->pdf_label  = 'Download Panduan PDF';
        $this->pdfFile    = null;
        $this->sort_order = 0;
        $this->is_active  = true;
    }

    public function render()
    {
        $tutorials = collect();
        try {
            if (Schema::hasTable('tutorials')) {
                $tutorials = Tutorial::ordered()->get();
            }
        } catch (\Throwable) {}

        return view('livewire.admin.tutorial-manager', compact('tutorials'))
            ->layout('layouts.app');
    }
}
