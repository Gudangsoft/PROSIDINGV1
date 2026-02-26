<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.announcements') }}" class="text-sm text-blue-600 hover:text-blue-800">&larr; Kembali ke Daftar Pengumuman</a>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $isEdit ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}</h2>
    </div>

    <form wire:submit="save" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul *</label>
                <input wire:model="title" type="text" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konten *</label>
                <textarea wire:model="content" rows="8" class="w-full px-3 py-2 border rounded-lg text-sm" required></textarea>
                @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <select wire:model="type" class="w-full px-3 py-2 border rounded-lg text-sm">
                        @foreach(\App\Models\Announcement::TYPE_LABELS as $val => $lbl)<option value="{{ $val }}">{{ $lbl }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                    <select wire:model="priority" class="w-full px-3 py-2 border rounded-lg text-sm">
                        @foreach(\App\Models\Announcement::PRIORITY_LABELS as $val => $lbl)<option value="{{ $val }}">{{ $lbl }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Audience *</label>
                    <div class="space-y-2">
                        @php
                            $audiences = [
                                'all' => 'Semua',
                                'web' => 'Website Publik',
                                'author' => 'Author',
                                'reviewer' => 'Reviewer',
                                'editor' => 'Editor',
                                'admin' => 'Admin',
                                'participant' => 'Partisipan'
                            ];
                        @endphp
                        @foreach($audiences as $val => $label)
                            <label class="inline-flex items-center gap-2 text-sm mr-4">
                                <input type="checkbox" wire:model="audience" value="{{ $val }}" 
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">💡 Centang "Website Publik" untuk menampilkan pengumuman di halaman depan website.</p>
                    @error('audience')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kegiatan Terkait</label>
                    <select wire:model="conference_id" class="w-full px-3 py-2 border rounded-lg text-sm">
                        <option value="">-- Tidak terkait kegiatan --</option>
                        @foreach($conferences as $conf)<option value="{{ $conf->id }}">{{ $conf->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kedaluwarsa</label>
                    <input wire:model="expires_at" type="date" class="w-full px-3 py-2 border rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran</label>
                    <input wire:model="attachment" type="file" class="w-full text-sm">
                    @error('attachment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select wire:model="status" class="w-full px-3 py-2 border rounded-lg text-sm">
                        <option value="draft">Draft</option>
                        <option value="published">Publikasikan</option>
                        <option value="archived">Arsipkan</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-wrap gap-6">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input wire:model="is_pinned" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-gray-700">Pinned (tampilkan di atas)</span>
                </label>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input wire:model="show_popup" type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <span class="text-gray-700 flex items-center gap-1.5">
                        <span class="inline-block w-2 h-2 rounded-full bg-purple-500"></span>
                        Pop-up setelah login peserta
                    </span>
                </label>
            </div>
            @if($show_popup)
            <div class="mt-2 p-3 bg-purple-50 border border-purple-200 rounded-lg text-xs text-purple-700 flex items-start gap-2">
                <svg class="w-4 h-4 shrink-0 mt-0.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Pengumuman ini akan muncul sebagai <strong>pop-up modal</strong> ketika peserta membuka dashboard setelah login. Pop-up hanya muncul sekali per sesi (tidak berulang setiap halaman reload).</span>
            </div>
            @endif
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.announcements') }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                <span wire:loading.remove wire:target="save">{{ $isEdit ? 'Simpan Perubahan' : 'Buat Pengumuman' }}</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
