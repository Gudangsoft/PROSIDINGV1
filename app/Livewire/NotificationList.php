<?php

namespace App\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationList extends Component
{
    use WithPagination;

    public string $filter = 'all'; // all, unread, read
    public int $unreadCount = 0;

    protected $queryString = ['filter'];

    public function mount(): void
    {
        $this->unreadCount = Auth::user()->unreadNotifications()->count();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function markAsRead(int $id): void
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification && !$notification->is_read) {
            $notification->markAsRead();
            $this->unreadCount = Auth::user()->unreadNotifications()->count();
            session()->flash('message', 'Notifikasi ditandai sudah dibaca.');
        }
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications()->update([
            'is_read' => true,
            'read_at' => now()
        ]);
        $this->unreadCount = 0;
        session()->flash('message', 'Semua notifikasi ditandai sudah dibaca.');
    }

    public function deleteNotification(int $id): void
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->delete();
            $this->unreadCount = Auth::user()->unreadNotifications()->count();
            session()->flash('message', 'Notifikasi dihapus.');
        }
    }

    public function deleteAllRead(): void
    {
        Auth::user()->notifications()->where('is_read', true)->delete();
        session()->flash('message', 'Semua notifikasi yang sudah dibaca telah dihapus.');
    }

    public function render()
    {
        $query = Auth::user()->notifications();

        if ($this->filter === 'unread') {
            $query = $query->where('is_read', false);
        } elseif ($this->filter === 'read') {
            $query = $query->where('is_read', true);
        }

        $notifications = $query->latest()->paginate(15);

        return view('livewire.notification-list', [
            'notifications' => $notifications,
        ])->layout('layouts.app', ['pageTitle' => 'Notifikasi']);
    }
}
