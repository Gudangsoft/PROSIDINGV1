<?php

namespace App\Livewire\Reviewer;

use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReviewList extends Component
{
    public string $statusFilter = '';

    public function render()
    {
        $user = Auth::user();
        $isAdminOrEditor = in_array($user->role, ['admin', 'editor']);
        
        $reviews = Review::with(['paper.user', 'paper.files', 'reviewer'])
            ->when(!$isAdminOrEditor, fn($q) => $q->where('reviewer_id', $user->id))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(10);

        return view('livewire.reviewer.review-list', compact('reviews', 'isAdminOrEditor'))->layout('layouts.app');
    }
}
