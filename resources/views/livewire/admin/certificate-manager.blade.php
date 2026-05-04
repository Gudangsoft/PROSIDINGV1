<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Sertifikat</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola desain, penandatangan, dan generate sertifikat peserta</p>
        </div>
        {{-- Conference Selector --}}
        <div class="flex items-center gap-3">
            <label class="text-sm font-medium text-gray-600 shrink-0">Konferensi:</label>
            <select wire:model.live="conferenceId" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 min-w-[220px]">
                <option value="">-- Pilih Konferensi --</option>
                @foreach($conferences as $conf)
                    <option value="{{ $conf->id }}">{{ $conf->acronym ?? $conf->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Flash messages --}}
    @if($successMessage)
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(()=>show=false,4000)"
         class="mb-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
        <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ $successMessage }}
    </div>
    @endif
    @if($errorMessage)
    <div class="mb-4 flex items-center gap-2 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
        <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ $errorMessage }}
    </div>
    @endif

    @if(!$conference)
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-8 text-center">
        <svg class="w-12 h-12 text-amber-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p class="text-amber-800 font-medium">Pilih konferensi untuk mulai mengelola sertifikat.</p>
    </div>
    @else

    {{-- Tabs --}}
    <div class="flex gap-1 mb-6 border-b border-gray-200">
        @foreach([
            ['settings',      'Pengaturan',         'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            ['signatures',    'Tanda Tangan',       'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z'],
            ['preview',       'Preview',             'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
            ['certificates',  'Sertifikat Dibuat',  'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
        ] as [$key, $label, $icon])
        <button wire:click="$set('activeTab','{{ $key }}')"
                class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium border-b-2 transition -mb-px
                       {{ $activeTab === $key ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
            </svg>
            {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- ────────────── TAB: SETTINGS ────────────── --}}
    @if($activeTab === 'settings')
    <form wire:submit="saveSettings" class="space-y-6">
        <div class="bg-white rounded-xl border shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Penandatangan Sertifikat
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Chairman --}}
                <div class="space-y-3">
                    <h4 class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>
                        Ketua / Chairperson
                    </h4>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Nama Lengkap</label>
                        <input wire:model="chairman_name" type="text" placeholder="Prof. Dr. ..."
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        @error('chairman_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Jabatan / Gelar</label>
                        <input wire:model="chairman_title" type="text" placeholder="Conference Chairperson"
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        @error('chairman_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer mt-1">
                        <input wire:model="show_chairman" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs text-gray-600">Tampilkan di sertifikat</span>
                    </label>
                </div>

                {{-- Institute Chairman --}}
                <div class="space-y-3">
                    <h4 class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                        Ketua Institusi / Head of Institution
                    </h4>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Nama Lengkap</label>
                        <input wire:model="institute_chairman_name" type="text" placeholder="Prof. Dr. ..."
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500">
                        @error('institute_chairman_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Jabatan / Gelar</label>
                        <input wire:model="institute_chairman_title" type="text" placeholder="Rektor / Dekan / ..."
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500">
                        @error('institute_chairman_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer mt-1">
                        <input wire:model="show_institute_chairman" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-xs text-gray-600">Tampilkan di sertifikat</span>
                    </label>
                </div>

                {{-- Secretary --}}
                <div class="space-y-3">
                    <h4 class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 inline-block"></span>
                        Sekretaris / Secretary
                    </h4>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Nama Lengkap</label>
                        <input wire:model="secretary_name" type="text" placeholder="Dr. ..."
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        @error('secretary_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Jabatan / Gelar</label>
                        <input wire:model="secretary_title" type="text" placeholder="Conference Secretary"
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        @error('secretary_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer mt-1">
                        <input wire:model="show_secretary" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs text-gray-600">Tampilkan di sertifikat</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                <span wire:loading.remove wire:target="saveSettings">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
                <span wire:loading wire:target="saveSettings">
                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="4" class="opacity-25"/><path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" class="opacity-75" fill="currentColor"/></svg>
                </span>
                <span wire:loading.remove wire:target="saveSettings">Simpan Pengaturan</span>
                <span wire:loading wire:target="saveSettings">Menyimpan...</span>
            </button>
        </div>
    </form>
    @endif

    {{-- ────────────── TAB: SIGNATURES ────────────── --}}
    @if($activeTab === 'signatures')
    <form wire:submit="saveSettings">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Chairman Signature --}}
            <div class="bg-white rounded-xl border shadow-sm p-6 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Tanda Tangan Ketua</h3>
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input wire:model="show_chairman" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs {{ $show_chairman ? 'text-blue-700 font-medium' : 'text-gray-400' }}">
                            {{ $show_chairman ? 'Tampil di sertifikat' : 'Disembunyikan' }}
                        </span>
                    </label>
                </div>

                @if($conference->chairman_signature)
                <div class="mb-4 p-3 bg-gray-50 rounded-lg text-center border">
                    <p class="text-xs text-gray-400 mb-2">Tanda tangan saat ini:</p>
                    <img src="{{ Storage::url($conference->chairman_signature) }}" alt="Chairman Signature"
                         class="max-h-20 mx-auto object-contain">
                    <button type="button" wire:click="deleteSignature('chairman')"
                            wire:confirm="Hapus tanda tangan ketua?"
                            class="mt-2 text-xs text-red-600 hover:text-red-800 hover:underline">
                        Hapus tanda tangan
                    </button>
                </div>
                @else
                <div class="mb-4 p-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200 text-center">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    <p class="text-xs text-gray-400">Belum ada tanda tangan</p>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Tanda Tangan Baru</label>
                    <input wire:model="chairman_signature_upload" type="file" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">Format: PNG / JPG / transparent PNG. Maks 2MB.</p>
                    @error('chairman_signature_upload')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                @if($chairman_signature_upload)
                <div class="mt-3 p-3 bg-blue-50 rounded-lg text-center border border-blue-100">
                    <p class="text-xs text-blue-600 mb-2">Preview:</p>
                    <img src="{{ $chairman_signature_upload->temporaryUrl() }}" class="max-h-20 mx-auto object-contain">
                </div>
                @endif

                <p class="text-xs text-gray-500 mt-3 bg-amber-50 border border-amber-100 rounded p-2">
                    💡 <strong>Tips:</strong> Gunakan gambar PNG dengan latar belakang transparan untuk tampilan terbaik di sertifikat.
                </p>
            </div>

            {{-- Institute Chairman Signature --}}
            <div class="bg-white rounded-xl border shadow-sm p-6 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Tanda Tangan Ketua Institusi</h3>
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input wire:model="show_institute_chairman" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-xs {{ $show_institute_chairman ? 'text-emerald-700 font-medium' : 'text-gray-400' }}">
                            {{ $show_institute_chairman ? 'Tampil di sertifikat' : 'Disembunyikan' }}
                        </span>
                    </label>
                </div>

                @if($conference->institute_chairman_signature)
                <div class="mb-4 p-3 bg-gray-50 rounded-lg text-center border">
                    <p class="text-xs text-gray-400 mb-2">Tanda tangan saat ini:</p>
                    <img src="{{ Storage::url($conference->institute_chairman_signature) }}" alt="Institute Chairman Signature"
                         class="max-h-20 mx-auto object-contain">
                    <button type="button" wire:click="deleteSignature('institute_chairman')"
                            wire:confirm="Hapus tanda tangan ketua institusi?"
                            class="mt-2 text-xs text-red-600 hover:text-red-800 hover:underline">
                        Hapus tanda tangan
                    </button>
                </div>
                @else
                <div class="mb-4 p-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200 text-center">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    <p class="text-xs text-gray-400">Belum ada tanda tangan</p>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Tanda Tangan Baru</label>
                    <input wire:model="institute_chairman_signature_upload" type="file" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-xs text-gray-400 mt-1">Format: PNG / JPG / transparent PNG. Maks 2MB.</p>
                    @error('institute_chairman_signature_upload')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                @if($institute_chairman_signature_upload)
                <div class="mt-3 p-3 bg-emerald-50 rounded-lg text-center border border-emerald-100">
                    <p class="text-xs text-emerald-600 mb-2">Preview:</p>
                    <img src="{{ $institute_chairman_signature_upload->temporaryUrl() }}" class="max-h-20 mx-auto object-contain">
                </div>
                @endif

                <p class="text-xs text-gray-500 mt-3 bg-amber-50 border border-amber-100 rounded p-2">
                    💡 <strong>Tips:</strong> Gunakan gambar PNG dengan latar belakang transparan untuk tampilan terbaik di sertifikat.
                </p>
            </div>

            {{-- Secretary Signature --}}
            <div class="bg-white rounded-xl border shadow-sm p-6 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Tanda Tangan Sekretaris</h3>
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input wire:model="show_secretary" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs {{ $show_secretary ? 'text-indigo-700 font-medium' : 'text-gray-400' }}">
                            {{ $show_secretary ? 'Tampil di sertifikat' : 'Disembunyikan' }}
                        </span>
                    </label>
                </div>

                @if($conference->secretary_signature)
                <div class="mb-4 p-3 bg-gray-50 rounded-lg text-center border">
                    <p class="text-xs text-gray-400 mb-2">Tanda tangan saat ini:</p>
                    <img src="{{ Storage::url($conference->secretary_signature) }}" alt="Secretary Signature"
                         class="max-h-20 mx-auto object-contain">
                    <button type="button" wire:click="deleteSignature('secretary')"
                            wire:confirm="Hapus tanda tangan sekretaris?"
                            class="mt-2 text-xs text-red-600 hover:text-red-800 hover:underline">
                        Hapus tanda tangan
                    </button>
                </div>
                @else
                <div class="mb-4 p-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200 text-center">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    <p class="text-xs text-gray-400">Belum ada tanda tangan</p>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Tanda Tangan Baru</label>
                    <input wire:model="secretary_signature_upload" type="file" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-1">Format: PNG / JPG / transparent PNG. Maks 2MB.</p>
                    @error('secretary_signature_upload')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                @if($secretary_signature_upload)
                <div class="mt-3 p-3 bg-indigo-50 rounded-lg text-center border border-indigo-100">
                    <p class="text-xs text-indigo-600 mb-2">Preview:</p>
                    <img src="{{ $secretary_signature_upload->temporaryUrl() }}" class="max-h-20 mx-auto object-contain">
                </div>
                @endif

                <p class="text-xs text-gray-500 mt-3 bg-amber-50 border border-amber-100 rounded p-2">
                    💡 <strong>Tips:</strong> Gunakan gambar PNG dengan latar belakang transparan untuk tampilan terbaik di sertifikat.
                </p>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                <span wire:loading.remove wire:target="saveSettings">Simpan Tanda Tangan</span>
                <span wire:loading wire:target="saveSettings">Menyimpan...</span>
            </button>
        </div>
    </form>
    @endif

    {{-- ────────────── TAB: PREVIEW ────────────── --}}
    @if($activeTab === 'preview')
    <div class="bg-white rounded-xl border shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-semibold text-gray-800">Preview Sertifikat</h3>
                <p class="text-sm text-gray-500 mt-0.5">Lihat tampilan sertifikat sebelum di-generate</p>
            </div>
            <div class="flex items-center gap-3">
                <label class="text-sm text-gray-600 font-medium">Tipe:</label>
                <select wire:model="previewType" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="author">Presenter (Author)</option>
                    <option value="participant">Partisipan</option>
                    <option value="reviewer">Reviewer</option>
                    <option value="committee">Panitia</option>
                </select>
                <a href="{{ route('admin.certificate.preview', ['conference' => $conference->id, 'type' => $previewType]) }}"
                   target="_blank"
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Buka Preview PDF
                </a>
            </div>
        </div>

        {{-- Embedded preview iframe --}}
        <div class="border-2 border-dashed border-gray-200 rounded-xl overflow-hidden bg-gray-100">
            <div class="bg-amber-50 border-b border-amber-100 px-4 py-2 flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-xs text-amber-700">Preview menggunakan data dummy. Klik "Buka Preview PDF" untuk melihat tampilan lengkap.</span>
            </div>
            <object
                data="{{ route('admin.certificate.preview', ['conference' => $conference->id, 'type' => $previewType]) }}#view=FitH"
                type="application/pdf"
                class="w-full"
                style="height: 560px;">
                <div class="p-8 text-center bg-gray-50">
                    <p class="text-gray-500 mb-2">Browser Anda tidak mendukung preview PDF langsung.</p>
                    <a href="{{ route('admin.certificate.preview', ['conference' => $conference->id, 'type' => $previewType]) }}"
                       target="_blank"
                       class="text-blue-600 hover:underline font-medium">Klik di sini untuk melihat PDF</a>
                </div>
            </object>
        </div>

        {{-- Info cards --}}
        <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="bg-gray-50 rounded-lg p-3 border text-sm">
                <div class="flex items-center justify-between">
                    <div class="font-medium text-gray-700">Ketua</div>
                    <span class="text-xs px-1.5 py-0.5 rounded {{ ($conference->show_chairman ?? true) ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-400' }}">
                        {{ ($conference->show_chairman ?? true) ? 'Tampil' : 'Sembunyi' }}
                    </span>
                </div>
                <div class="text-gray-500 mt-0.5">{{ $conference->chairman_name ?: '(belum diisi)' }}</div>
                <div class="text-gray-400 text-xs">{{ $conference->chairman_title ?: '' }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3 border text-sm">
                <div class="flex items-center justify-between">
                    <div class="font-medium text-gray-700">Ketua Institusi</div>
                    <span class="text-xs px-1.5 py-0.5 rounded {{ ($conference->show_institute_chairman ?? false) ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-200 text-gray-400' }}">
                        {{ ($conference->show_institute_chairman ?? false) ? 'Tampil' : 'Sembunyi' }}
                    </span>
                </div>
                <div class="text-gray-500 mt-0.5">{{ $conference->institute_chairman_name ?: '(belum diisi)' }}</div>
                <div class="text-gray-400 text-xs">{{ $conference->institute_chairman_title ?: '' }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3 border text-sm">
                <div class="flex items-center justify-between">
                    <div class="font-medium text-gray-700">Sekretaris</div>
                    <span class="text-xs px-1.5 py-0.5 rounded {{ ($conference->show_secretary ?? true) ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-200 text-gray-400' }}">
                        {{ ($conference->show_secretary ?? true) ? 'Tampil' : 'Sembunyi' }}
                    </span>
                </div>
                <div class="text-gray-500 mt-0.5">{{ $conference->secretary_name ?: '(belum diisi)' }}</div>
                <div class="text-gray-400 text-xs">{{ $conference->secretary_title ?: '' }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3 border text-sm">
                <div class="font-medium text-gray-700 mb-1">Gambar TTD</div>
                <div class="flex flex-col gap-1">
                    <span class="flex items-center gap-1 text-xs {{ $conference->chairman_signature ? 'text-green-600' : 'text-gray-400' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $conference->chairman_signature ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                        Ketua
                    </span>
                    <span class="flex items-center gap-1 text-xs {{ $conference->institute_chairman_signature ? 'text-green-600' : 'text-gray-400' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $conference->institute_chairman_signature ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                        Ketua Institusi
                    </span>
                    <span class="flex items-center gap-1 text-xs {{ $conference->secretary_signature ? 'text-green-600' : 'text-gray-400' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $conference->secretary_signature ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                        Sekretaris
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ────────────── TAB: CERTIFICATES ────────────── --}}
    @if($activeTab === 'certificates')
    <div class="space-y-5">

        {{-- Batch Generate Card --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl text-white p-5 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-lg">Generate Sertifikat Massal</h3>
                <p class="text-blue-100 text-sm mt-0.5">Buat sertifikat otomatis untuk semua presenter yang sudah diverifikasi pembayarannya.</p>
            </div>
            <div class="flex items-center gap-3 shrink-0 ml-4">
                {{-- Tarik Semua --}}
                @if($certificates->count() > 0)
                <button wire:click="revokeAllCertificates"
                        wire:confirm="⚠️ Tarik SEMUA {{ $certificates->count() }} sertifikat? File akan dihapus permanen dan peserta tidak dapat mengaksesnya lagi. Lanjutkan?"
                        wire:loading.attr="disabled"
                        class="flex items-center gap-2 px-4 py-2.5 bg-red-500 bg-opacity-90 text-white border border-red-300 border-opacity-40 rounded-lg text-sm font-semibold hover:bg-red-600 transition disabled:opacity-60">
                    <span wire:loading.remove wire:target="revokeAllCertificates">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </span>
                    <span wire:loading wire:target="revokeAllCertificates">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/><path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" fill="currentColor" class="opacity-75"/></svg>
                    </span>
                    <span wire:loading.remove wire:target="revokeAllCertificates">Tarik Semua</span>
                    <span wire:loading wire:target="revokeAllCertificates">Menarik...</span>
                </button>
                @endif

                {{-- Generate Sekarang --}}
                <button wire:click="batchGenerate"
                        wire:confirm="Generate sertifikat untuk semua presenter yang memenuhi syarat?"
                        wire:loading.attr="disabled"
                        class="flex items-center gap-2 px-5 py-2.5 bg-white text-blue-700 rounded-lg text-sm font-semibold hover:bg-blue-50 transition disabled:opacity-60">
                    <span wire:loading.remove wire:target="batchGenerate">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </span>
                    <span wire:loading wire:target="batchGenerate">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/><path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" fill="currentColor" class="opacity-75"/></svg>
                    </span>
                    <span wire:loading.remove wire:target="batchGenerate">Generate Sekarang</span>
                    <span wire:loading wire:target="batchGenerate">Memproses...</span>
                </button>
            </div>
        </div>

        @if(!empty($batchStats))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <span class="font-medium text-green-800">Batch selesai!</span>
                <span class="text-green-700"> Berhasil: {{ $batchStats['authors'] ?? 0 }} sertifikat, Gagal: {{ $batchStats['failed'] ?? 0 }}.</span>
            </div>
        </div>
        @endif

        {{-- Filter & Search --}}
        <div class="bg-white rounded-xl border shadow-sm">
            <div class="px-5 py-4 border-b flex items-center gap-3">
                <div class="relative flex-1 max-w-xs">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input wire:model.live.debounce.300ms="certSearch" type="text"
                           placeholder="Cari nama penerima..."
                           class="pl-9 pr-3 py-2 border rounded-lg text-sm w-full focus:ring-2 focus:ring-blue-500">
                </div>
                <span class="text-sm text-gray-500">{{ $certificates->count() }} sertifikat ditemukan</span>
            </div>

            @if($certificates->isEmpty())
            <div class="py-12 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm">Belum ada sertifikat yang dibuat untuk konferensi ini.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">Penerima</th>
                            <th class="px-4 py-3 text-left font-medium">Judul Paper</th>
                            <th class="px-4 py-3 text-left font-medium">Dibuat</th>
                            <th class="px-4 py-3 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($certificates as $cert)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800">{{ $cert->user->name ?? '—' }}</div>
                                <div class="text-xs text-gray-400">{{ $cert->user->email ?? '' }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 max-w-xs truncate">
                                {{ $cert->paper->title ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                {{ $cert->sent_at?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Download --}}
                                    <a href="{{ Storage::url($cert->file_path) }}" target="_blank"
                                       class="inline-flex items-center gap-1 text-xs px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Download
                                    </a>

                                    {{-- Tarik Ulang --}}
                                    <button wire:click="revokeCertificate({{ $cert->id }})"
                                            wire:confirm="Tarik sertifikat milik {{ $cert->user->name ?? 'peserta ini' }}? File akan dihapus permanen."
                                            wire:loading.attr="disabled"
                                            class="inline-flex items-center gap-1 text-xs px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition font-medium border border-red-100"
                                            title="Tarik ulang sertifikat">
                                        <span wire:loading.remove wire:target="revokeCertificate({{ $cert->id }})">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </span>
                                        <span wire:loading wire:target="revokeCertificate({{ $cert->id }})">
                                            <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/><path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" fill="currentColor" class="opacity-75"/></svg>
                                        </span>
                                        Tarik
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
    @endif

    @endif {{-- end if $conference --}}
</div>
