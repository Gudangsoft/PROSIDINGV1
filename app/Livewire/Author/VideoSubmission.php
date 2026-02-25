<?php

namespace App\Livewire\Author;

use App\Models\Paper;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class VideoSubmission extends Component
{
    public array $videoUrls = [];

    public function mount()
    {
        $papers = $this->getPapers();
        foreach ($papers as $paper) {
            $this->videoUrls[$paper->id] = $paper->video_presentation_url ?? '';
        }
    }

    protected function getPapers()
    {
        return Paper::where('user_id', Auth::id())
            ->whereIn('status', ['payment_verified', 'deliverables_pending', 'completed'])
            ->latest('accepted_at')
            ->get();
    }

    public function submitVideo(int $paperId)
    {
        $this->validate([
            "videoUrls.{$paperId}" => 'required|url|max:500',
        ], [
            "videoUrls.{$paperId}.required" => 'Link video wajib diisi.',
            "videoUrls.{$paperId}.url"      => 'Format link video tidak valid. Gunakan URL lengkap (https://...).',
        ]);

        $paper = Paper::where('id', $paperId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $paper->update(['video_presentation_url' => $this->videoUrls[$paperId]]);

        // Notify admins/editors
        $adminIds = \App\Models\User::whereIn('role', ['admin', 'editor'])->pluck('id');
        \App\Models\Notification::createForUsers(
            $adminIds,
            'info',
            'Video Pemaparan Disubmit',
            'Author telah mengirimkan link video pemaparan untuk paper "' . \Illuminate\Support\Str::limit($paper->title, 50) . '"',
            route('admin.paper.detail', $paper),
            'Lihat Paper'
        );

        session()->flash('success_' . $paperId, 'Link video berhasil disimpan!');
    }

    public function render()
    {
        $papers = $this->getPapers();
        return view('livewire.author.video-submission', compact('papers'))->layout('layouts.app');
    }
}
