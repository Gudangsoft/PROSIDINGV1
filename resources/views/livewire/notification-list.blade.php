<div class="py-6">
    @section('page-title', 'Notifikasi')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Notifikasi</h1>
            <p class="text-gray-600 mt-1">Kelola semua notifikasi Anda di sini</p>
        </div>

        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                {{ session('message') }}
            </div>
        @endif

        {{-- Filter & Actions --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                {{-- Filter Tabs --}}
                <div class="flex items-center gap-2">
                    <button wire:click="setFilter('all')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $filter === 'all' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        Semua
                    </button>
                    <button wire:click="setFilter('unread')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 {{ $filter === 'unread' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        Belum Dibaca
                        @if($unreadCount > 0)
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    <button wire:click="setFilter('read')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $filter === 'read' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        Sudah Dibaca
                    </button>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2">
                    @if($unreadCount > 0)
                        <button wire:click="markAllAsRead" wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
                            <span wire:loading.remove wire:target="markAllAsRead">Tandai Semua Dibaca</span>
                            <span wire:loading wire:target="markAllAsRead">Memproses...</span>
                        </button>
                    @endif
                    @if($notifications->where('is_read', true)->count() > 0)
                        <button wire:click="deleteAllRead" wire:confirm="Hapus semua notifikasi yang sudah dibaca?" wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition">
                            <span wire:loading.remove wire:target="deleteAllRead">Hapus Dibaca</span>
                            <span wire:loading wire:target="deleteAllRead">Menghapus...</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Notification List --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @forelse($notifications as $notification)
                <div class="p-4 border-b border-gray-100 last:border-b-0 {{ !$notification->is_read ? 'bg-blue-50' : '' }} hover:bg-gray-50 transition">
                    <div class="flex items-start gap-4">
                        {{-- Icon --}}
                        <div class="shrink-0 mt-1">
                            @switch($notification->type)
                                @case('success')
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    @break
                                @case('warning')
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    @break
                                @case('danger')
                                @case('error')
                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    @break
                                @default
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                            @endswitch
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <h3 class="font-semibold text-gray-800 {{ !$notification->is_read ? 'font-bold' : '' }}">
                                        {{ $notification->title }}
                                        @if(!$notification->is_read)
                                            <span class="inline-block w-2 h-2 bg-blue-500 rounded-full ml-2"></span>
                                        @endif
                                    </h3>
                                    <p class="text-gray-600 mt-1">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-400 mt-2">
                                        {{ $notification->created_at->diffForHumans() }}
                                        @if($notification->is_read && $notification->read_at)
                                            &bull; Dibaca {{ $notification->read_at->diffForHumans() }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-3 flex items-center gap-2 flex-wrap">
                                @if($notification->action_url)
                                    <a href="{{ $notification->action_url }}" 
                                       wire:click="markAsRead({{ $notification->id }})"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                        {{ $notification->action_text ?? 'Lihat Detail' }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                @endif

                                @if(!$notification->is_read)
                                    <button wire:click="markAsRead({{ $notification->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Tandai Dibaca
                                    </button>
                                @endif

                                <button wire:click="deleteNotification({{ $notification->id }})" 
                                        wire:confirm="Hapus notifikasi ini?"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Tidak Ada Notifikasi</h3>
                    <p class="text-gray-500">
                        @if($filter === 'unread')
                            Tidak ada notifikasi yang belum dibaca.
                        @elseif($filter === 'read')
                            Tidak ada notifikasi yang sudah dibaca.
                        @else
                            Anda belum memiliki notifikasi.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
