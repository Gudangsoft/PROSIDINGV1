<?php

namespace App\Livewire\Author;

use App\Models\Paper;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PaperDetail extends Component
{
    public Paper $paper;
    public string $videoUrl = '';

    // Discussion
    public ?int $activeDiscussionId = null;
    public string $replyMessage = '';

    public function mount(Paper $paper)
    {
        $user = Auth::user();
        $isAdminOrEditor = in_array($user?->role, ['admin', 'editor']);
        $isImpersonating = session()->has('impersonating_from');

        if (! $isAdminOrEditor && ! $isImpersonating && (int) $paper->user_id !== (int) Auth::id()) {
            abort(403);
        }
        $this->paper = $paper;
        // Guard against missing column if migration not yet run on production
        $this->videoUrl = Schema::hasColumn('papers', 'video_presentation_url')
            ? ($paper->video_presentation_url ?? '')
            : '';
    }



    public function submitVideoUrl()
    {
        if (! Schema::hasColumn('papers', 'video_presentation_url')) {
            session()->flash('error', 'Fitur ini belum tersedia. Hubungi administrator.');
            return;
        }

        $this->validate([
            'videoUrl' => 'required|url|max:500',
        ], [
            'videoUrl.required' => 'Link video wajib diisi.',
            'videoUrl.url'      => 'Format link video tidak valid.',
        ]);

        $this->paper->update(['video_presentation_url' => $this->videoUrl]);
        $this->paper->refresh();

        // Notify admins/editors
        $adminIds = \App\Models\User::whereIn('role', ['admin', 'editor'])->pluck('id');
        \App\Models\Notification::createForUsers(
            $adminIds,
            'info',
            'Video Pemaparan Disubmit',
            'Author telah mengirimkan link video pemaparan untuk paper "' . \Illuminate\Support\Str::limit($this->paper->title, 50) . '"',
            route('admin.paper.detail', $this->paper),
            'Lihat Paper'
        );

        session()->flash('success', 'Link video pemaparan berhasil disimpan!');
    }

    public function openDiscussion(int $id)
    {
        $this->activeDiscussionId = ($this->activeDiscussionId === $id) ? null : $id;
        $this->replyMessage = '';
    }

    public function sendReply()
    {
        $this->validate([
            'replyMessage'     => 'required|min:1',
            'activeDiscussionId' => 'required',
        ]);

        $discussion = \App\Models\Discussion::findOrFail($this->activeDiscussionId);

        // Pastikan diskusi ini milik paper author ini
        abort_unless($discussion->paper_id === $this->paper->id, 403);

        // Jangan izinkan reply ke diskusi yang sudah ditutup
        if ($discussion->is_closed) {
            session()->flash('error', 'Diskusi ini sudah ditutup.');
            return;
        }

        \App\Models\DiscussionMessage::create([
            'discussion_id' => $this->activeDiscussionId,
            'user_id'       => \Illuminate\Support\Facades\Auth::id(),
            'message'       => $this->replyMessage,
        ]);

        // Notify admins/editors
        $adminIds = \App\Models\User::whereIn('role', ['admin', 'editor'])->pluck('id');
        \App\Models\Notification::createForUsers(
            $adminIds,
            'info',
            'Balasan Diskusi dari Author',
            'Author membalas diskusi "' . \Illuminate\Support\Str::limit($discussion->subject, 50) . '" untuk paper "' . \Illuminate\Support\Str::limit($this->paper->title, 40) . '"',
            route('admin.paper.detail', $this->paper),
            'Lihat Diskusi'
        );

        $this->replyMessage = '';
        $this->paper->refresh();
        session()->flash('success', 'Balasan berhasil dikirim.');
    }

    public function render()
    {
        $relations = ['files', 'reviews.reviewer', 'payment'];
        if (Schema::hasTable('deliverables')) {
            $relations[] = 'deliverables';
        }
        // Always load discussions
        $relations[] = 'discussions.user';
        $relations[] = 'discussions.messages.user';
        $relations[] = 'discussions.latestMessage';

        $this->paper->load($relations);

        // Ensure deliverables is always a collection to avoid undefined errors in view
        if (! $this->paper->relationLoaded('deliverables')) {
            $this->paper->setRelation('deliverables', collect());
        }

        return view('livewire.author.paper-detail')->layout('layouts.app');
    }
}
