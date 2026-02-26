<?php

namespace App\Livewire\Participant;

use App\Models\Conference;
use App\Models\ConferenceMaterial;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class MaterialList extends Component
{
    public function render()
    {
        try {
            $user = Auth::user();

            $verifiedConferenceIds = collect();

            $hasTypeColumn    = Schema::hasColumn('payments', 'type');
            $hasPackageColumn = Schema::hasColumn('payments', 'registration_package_id');

            if ($hasTypeColumn) {
                $query = Payment::where('user_id', $user->id)
                    ->where('type', Payment::TYPE_PARTICIPANT)
                    ->where('status', 'verified');

                if ($hasPackageColumn) {
                    $query->with('registrationPackage');
                }

                $verifiedConferenceIds = $query->get()
                    ->map(function ($payment) use ($hasPackageColumn) {
                        if ($hasPackageColumn && $payment->registrationPackage) {
                            return $payment->registrationPackage->conference_id;
                        }
                        return Conference::active()->value('id');
                    })
                    ->filter()->unique()->values();
            } else {
                // Fallback: type column not yet migrated — treat any verified payment as valid
                $verifiedConferenceIds = Payment::where('user_id', $user->id)
                    ->where('status', 'verified')
                    ->get()
                    ->map(fn() => Conference::active()->value('id'))
                    ->filter()->unique()->values();
            }

            $conferenceGroups = collect();

            if ($verifiedConferenceIds->isNotEmpty() && Schema::hasTable('conference_materials')) {
                $conferences = Conference::whereIn('id', $verifiedConferenceIds)
                    ->orderByDesc('start_date')
                    ->get();

                foreach ($conferences as $conference) {
                    $materials = ConferenceMaterial::where('conference_id', $conference->id)
                        ->active()
                        ->orderBy('sort_order')
                        ->orderBy('type')
                        ->get()
                        ->groupBy('type');

                    $conferenceGroups->push([
                        'conference' => $conference,
                        'materials'  => $materials,
                        'total'      => $materials->flatten()->count(),
                    ]);
                }
            }

            $hasAccess = $verifiedConferenceIds->isNotEmpty();

        } catch (\Throwable $e) {
            // Graceful fallback — show empty state instead of crashing
            $conferenceGroups = collect();
            $hasAccess = false;
            \Illuminate\Support\Facades\Log::error('MaterialList render error: ' . $e->getMessage());
        }

        return view('livewire.participant.material-list', compact('conferenceGroups', 'hasAccess'))
            ->layout('layouts.app');
    }
}
