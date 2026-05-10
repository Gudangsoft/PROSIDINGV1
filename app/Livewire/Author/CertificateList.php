<?php

namespace App\Livewire\Author;

use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class CertificateList extends Component
{
    public function render()
    {
        $certificates = collect();

        try {
            if (Schema::hasTable('certificates')) {
                $certificates = Certificate::where('user_id', Auth::id())
                    ->with(['conference', 'paper'])
                    ->latest('generated_at')
                    ->get();
            }
        } catch (\Throwable $e) {
            // table not yet migrated
        }

        return view('livewire.author.certificate-list', compact('certificates'))
            ->layout('layouts.app');
    }
}
