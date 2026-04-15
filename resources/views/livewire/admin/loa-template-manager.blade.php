<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Page Title --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Template LOA (Letter of Acceptance)</h1>
        <p class="text-gray-500 mt-1">Kelola template LOA yang akan digunakan saat paper diterima. Sesuaikan header, konten, tanggal penting, info pembayaran, dan tanda tangan.</p>
    </div>

    {{-- Flash Messages --}}
    @if($successMessage)
    <div class="mb-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="font-medium">{{ $successMessage }}</span>
            </div>
            <button @click="show = false" class="text-green-700 hover:text-green-900"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg></button>
        </div>
    </div>
    @endif
    @if($errorMessage)
    <div class="mb-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <span class="font-medium">{{ $errorMessage }}</span>
            </div>
            <button @click="show = false" class="text-red-700 hover:text-red-900"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg></button>
        </div>
    </div>
    @endif

    {{-- Conference Selector --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Konferensi</label>
                <select wire:model.live="conferenceId" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <option value="">-- Pilih Konferensi --</option>
                    @foreach($conferences as $conf)
                        <option value="{{ $conf->id }}">{{ $conf->name }} {{ $conf->is_active ? '(Aktif)' : '' }}</option>
                    @endforeach
                </select>
            </div>
            @if($conference)
            <div class="flex items-center gap-2 pt-6">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $conference->loa_generation_mode === 'auto' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                    Mode: {{ $conference->loa_generation_mode === 'auto' ? 'Otomatis' : 'Manual' }}
                </span>
            </div>
            @endif
        </div>
    </div>

    @if($conference)
    {{-- Tab Navigation --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px overflow-x-auto">
                <button wire:click="$set('activeTab', 'header')"
                    class="px-6 py-3.5 text-sm font-medium border-b-2 transition whitespace-nowrap
                    {{ $activeTab === 'header' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Kop Surat
                </button>
                <button wire:click="$set('activeTab', 'body')"
                    class="px-6 py-3.5 text-sm font-medium border-b-2 transition whitespace-nowrap
                    {{ $activeTab === 'body' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Konten Surat
                </button>
                <button wire:click="$set('activeTab', 'dates')"
                    class="px-6 py-3.5 text-sm font-medium border-b-2 transition whitespace-nowrap
                    {{ $activeTab === 'dates' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Tanggal & Info
                </button>
                <button wire:click="$set('activeTab', 'signature')"
                    class="px-6 py-3.5 text-sm font-medium border-b-2 transition whitespace-nowrap
                    {{ $activeTab === 'signature' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Tanda Tangan
                </button>
            </nav>
        </div>

        {{-- Tab Content --}}
        <div class="p-6">

            {{-- ═══ KOP SURAT (Header) ═══ --}}
            @if($activeTab === 'header')
            <div class="space-y-6">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Kop Surat LOA</h3>
                        <p class="text-sm text-gray-500">Atur logo, nama institusi, dan informasi kontak kop surat.</p>
                    </div>
                </div>

                {{-- Logo Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Kop Surat</label>
                    <div class="flex items-center gap-4">
                        @if($conference->loa_header_logo)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $conference->loa_header_logo) }}" alt="Header Logo" class="h-20 rounded-lg border border-gray-200 shadow-sm">
                                <button wire:click="deleteHeaderLogo" wire:confirm="Yakin ingin menghapus logo ini?"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" wire:model="loa_header_logo_upload" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, max 5MB. Rekomendasi: set logo yang menggabungkan semua logo institusi.</p>
                        </div>
                    </div>
                    @if($loa_header_logo_upload)
                        <div class="mt-2">
                            <img src="{{ $loa_header_logo_upload->temporaryUrl() }}" class="h-16 rounded-lg border border-gray-200" alt="Preview">
                        </div>
                    @endif
                </div>

                {{-- Header Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kop Surat</label>
                    <input type="text" wire:model="loa_header_title" placeholder="Contoh: COMMITTEE OF THE 2nd STIFAR INTERNATIONAL CONFERENCE - SINACON 2026"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Nama komite/institusi penyelenggara yang muncul di kop surat.</p>
                </div>

                {{-- Subtitle --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle Kop Surat</label>
                    <textarea wire:model="loa_header_subtitle" rows="3" placeholder="Contoh: Sekolah Tinggi Ilmu Farmasi Yayasan Pharmasi Semarang&#10;( Semarang College of Pharmaceutical Science )"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                    <p class="text-xs text-gray-400 mt-1">Info tambahan di bawah judul (nama lengkap institusi, dll). Gunakan baris baru untuk memisahkan.</p>
                </div>

                {{-- Address --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <input type="text" wire:model="loa_header_address" placeholder="Letnan Jendral Sarwo Edie Wibowo Plamongansari Street, Km 1, Semarang City, Indonesia"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                {{-- Contact Row --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" wire:model="loa_header_phone" placeholder="(+6224) 6706147; (+6224) 6725272"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fax</label>
                        <input type="text" wire:model="loa_header_fax" placeholder="(+6224) 6706148"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="text" wire:model="loa_header_email" placeholder="sinacon2026@gmail.com"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                {{-- Save Button --}}
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button wire:click="saveHeader" wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition shadow-sm disabled:opacity-50 cursor-pointer">
                        <svg wire:loading wire:target="saveHeader" class="animate-spin h-4 w-4 inline mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Simpan Kop Surat
                    </button>
                </div>
            </div>
            @endif

            {{-- ═══ KONTEN SURAT (Body) ═══ --}}
            @if($activeTab === 'body')
            <div class="space-y-6">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Konten Surat LOA</h3>
                        <p class="text-sm text-gray-500">Atur teks pembuka, penerimaan, dan penutup surat LOA.</p>
                    </div>
                    <button wire:click="loadDefaults" wire:confirm="Muat teks default? Teks yang sudah diisi akan diganti."
                        class="px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition cursor-pointer">
                        Muat Default
                    </button>
                </div>

                {{-- Intro --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teks Pembuka</label>
                    <textarea wire:model="loa_body_intro" rows="3" placeholder="Dear Author(s),&#10;We are pleased to inform you that your paper entitled"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                    <p class="text-xs text-gray-400 mt-1">Teks sebelum judul paper. Variabel: <code>{paper_title}</code>, <code>{author_name}</code>, <code>{paper_id}</code></p>
                </div>

                {{-- Acceptance Text --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teks Penerimaan</label>
                    <textarea wire:model="loa_body_acceptance" rows="3" placeholder="has been accepted for oral presentation at the..."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                    <p class="text-xs text-gray-400 mt-1">Teks setelah judul paper menjelaskan penerimaan. Variabel: <code>{conference_name}</code>, <code>{conference_date}</code></p>
                </div>

                {{-- Submission Info --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Informasi Pengiriman Naskah</label>
                    <textarea wire:model="loa_body_submission_info" rows="4"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                    <p class="text-xs text-gray-400 mt-1">Informasi tentang pengiriman full paper, template manuscript, dsb.</p>
                </div>

                {{-- Closing Text --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teks Penutup</label>
                    <textarea wire:model="loa_closing_text" rows="2"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                </div>

                {{-- Save Button --}}
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button wire:click="saveBody" wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition shadow-sm disabled:opacity-50 cursor-pointer">
                        <svg wire:loading wire:target="saveBody" class="animate-spin h-4 w-4 inline mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Simpan Konten
                    </button>
                </div>
            </div>
            @endif

            {{-- ═══ TANGGAL PENTING & INFO (Dates & Payment) ═══ --}}
            @if($activeTab === 'dates')
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Tanggal Penting & Informasi</h3>
                    <p class="text-sm text-gray-500">Atur tanggal penting, informasi pembayaran, dan kontak yang muncul di LOA.</p>
                </div>

                {{-- Important Dates --}}
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-medium text-gray-700">Important Dates</label>
                        <button wire:click="addImportantDate"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Tambah Tanggal
                        </button>
                    </div>

                    @forelse($loa_important_dates as $index => $dateItem)
                    <div class="flex items-center gap-3 mb-3" wire:key="date-{{ $index }}">
                        <div class="flex-1">
                            <input type="text" wire:model="loa_important_dates.{{ $index }}.label" placeholder="Contoh: Abstract Submission and Payment Deadline"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div class="w-48">
                            <input type="text" wire:model="loa_important_dates.{{ $index }}.date" placeholder="April 30, 2026"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <button wire:click="removeImportantDate({{ $index }})"
                            class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    @empty
                    <div class="py-8 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-gray-400">Belum ada tanggal penting. Klik "Tambah Tanggal" untuk menambahkan.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Payment Info --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Informasi Pembayaran</label>
                    <textarea wire:model="loa_payment_info" rows="5" placeholder="All payment should be transferred to the following account:&#10;STIFAR YAPHAR SEMARANG&#10;Bank: BRI (Bank Rakyat Indonesia)&#10;Account Number: 067801000499565&#10;Then, please kindly upload the proof of payment through the conference website."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                    <p class="text-xs text-gray-400 mt-1">Informasi bank dan instruksi pembayaran yang muncul di LOA.</p>
                </div>

                {{-- Contact Info --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Informasi Kontak</label>
                    <textarea wire:model="loa_contact_info" rows="3" placeholder="If you have any inquiries, please do not hesitate to contact us at:&#10;sinacon2026@gmail.com (WA : +62823-4227-2940)"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                </div>

                {{-- Save Button --}}
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button wire:click="saveBody" wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition shadow-sm disabled:opacity-50 cursor-pointer">
                        <svg wire:loading wire:target="saveBody" class="animate-spin h-4 w-4 inline mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Simpan Tanggal & Info
                    </button>
                </div>
            </div>
            @endif

            {{-- ═══ TANDA TANGAN (Signature) ═══ --}}
            @if($activeTab === 'signature')
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Tanda Tangan & Footer</h3>
                    <p class="text-sm text-gray-500">Atur penanda tangan, gambar tanda tangan (logo/stamp), dan teks footer LOA.</p>
                </div>

                {{-- City & Date placeholder info --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <div class="text-sm text-blue-700">
                            <p class="font-medium">Kota & tanggal pada tanda tangan</p>
                            <p class="mt-1">Lokasi dan tanggal akan otomatis diambil dari data konferensi (kota) dan tanggal generate LOA.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Signatory Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penanda Tangan</label>
                        <input type="text" wire:model="loa_signatory_name" placeholder="Bayu Tri Murti, Ph.D."
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>

                    {{-- Signatory Title --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Penanda Tangan</label>
                        <input type="text" wire:model="loa_signatory_title" placeholder="Conference Chair of 2nd SINACON 2026"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                {{-- Signature Image Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Tanda Tangan / Stamp / Logo</label>
                    <div class="flex items-center gap-4">
                        @if($conference->loa_signature_image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $conference->loa_signature_image) }}" alt="Signature" class="h-20 rounded-lg border border-gray-200 shadow-sm bg-white p-2">
                                <button wire:click="deleteSignatureImage" wire:confirm="Yakin ingin menghapus gambar tanda tangan?"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" wire:model="loa_signature_image_upload" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-400 mt-1">Gunakan gambar dengan background transparan (PNG) untuk hasil terbaik. Max 5MB.</p>
                        </div>
                    </div>
                    @if($loa_signature_image_upload)
                        <div class="mt-2">
                            <img src="{{ $loa_signature_image_upload->temporaryUrl() }}" class="h-16 rounded-lg border border-gray-200 bg-white p-2" alt="Preview">
                        </div>
                    @endif
                </div>

                {{-- Footer Text --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teks Footer LOA</label>
                    <input type="text" wire:model="loa_footer_text" placeholder="SINACON 2026"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Teks yang muncul di bagian bawah halaman LOA (opsional).</p>
                </div>

                {{-- Save Button --}}
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button wire:click="saveSignature" wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition shadow-sm disabled:opacity-50 cursor-pointer">
                        <svg wire:loading wire:target="saveSignature" class="animate-spin h-4 w-4 inline mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Simpan Tanda Tangan & Footer
                    </button>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Preview Section --}}
    @if($conference)
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-base font-semibold text-gray-800">Preview LOA</h3>
            <p class="text-sm text-gray-500 mt-0.5">Tampilan perkiraan LOA. Field dinamis (Paper ID, Author, dll) akan terisi otomatis saat generate.</p>
        </div>
        <div class="p-6 flex justify-center">
            <div class="w-full max-w-[700px] bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden" style="font-family: 'Times New Roman', Times, serif;">

                {{-- Header Preview --}}
                <div class="text-center px-8 pt-8 pb-4 border-b-2 border-gray-700">
                    @if($conference->loa_header_logo)
                        <img src="{{ asset('storage/' . $conference->loa_header_logo) }}" alt="Logo" class="h-16 mx-auto mb-3 object-contain">
                    @elseif($conference->logo)
                        <img src="{{ asset('storage/' . $conference->logo) }}" alt="Logo" class="h-16 mx-auto mb-3 object-contain">
                    @endif

                    @if($loa_header_title)
                        <p class="text-sm font-bold text-blue-800 uppercase">{{ $loa_header_title }}</p>
                    @endif
                    @if($loa_header_subtitle)
                        @foreach(explode("\n", $loa_header_subtitle) as $line)
                            <p class="text-xs text-gray-600 italic">{{ $line }}</p>
                        @endforeach
                    @endif
                    @if($loa_header_address)
                        <p class="text-[10px] text-gray-500 mt-1">{{ $loa_header_address }}</p>
                    @endif
                    <div class="flex items-center justify-center gap-4 mt-1 text-[10px] text-gray-500">
                        @if($loa_header_phone)<span>Phone: {{ $loa_header_phone }}</span>@endif
                        @if($loa_header_fax)<span>Fax: {{ $loa_header_fax }}</span>@endif
                        @if($loa_header_email)<span>Email: {{ $loa_header_email }}</span>@endif
                    </div>
                </div>

                {{-- Body Preview --}}
                <div class="px-8 py-6 text-sm leading-relaxed">
                    <h2 class="text-center font-bold text-base underline text-blue-800 mb-6">Letter of Acceptance (LoA)</h2>

                    @if($loa_body_intro)
                        @foreach(explode("\n", $loa_body_intro) as $line)
                            <p>{{ $line }}</p>
                        @endforeach
                    @endif

                    <p class="text-center my-4 text-gray-400 italic border border-dashed border-gray-300 py-2 rounded">............... [Paper Title] ...............</p>

                    <p class="text-center text-xs text-gray-500 my-2">Paper ID: ............ &nbsp;&nbsp; Author(s): ....................</p>

                    @if($loa_body_acceptance)
                        <p class="mt-4">{{ $loa_body_acceptance }}</p>
                    @endif

                    {{-- Important Dates --}}
                    @if(count($loa_important_dates) > 0)
                    <div class="mt-4">
                        <p class="font-bold">Important Dates:</p>
                        @foreach($loa_important_dates as $dateItem)
                            @if(!empty($dateItem['label']) || !empty($dateItem['date']))
                            <p class="ml-2">* {{ $dateItem['label'] ?? '' }} <span class="float-right">: {{ $dateItem['date'] ?? '' }}</span></p>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    {{-- Submission Info --}}
                    @if($loa_body_submission_info)
                    <div class="mt-4">
                        @foreach(explode("\n", $loa_body_submission_info) as $line)
                            <p>{{ $line }}</p>
                        @endforeach
                    </div>
                    @endif

                    {{-- Payment Info --}}
                    @if($loa_payment_info)
                    <div class="mt-4">
                        @foreach(explode("\n", $loa_payment_info) as $line)
                            <p>{!! preg_match('/^([\w\s]+\s*:\s*)(.+)$/', $line, $m) ? '<strong>' . e($m[1]) . '</strong>' . e($m[2]) : e($line) !!}</p>
                        @endforeach
                    </div>
                    @endif

                    {{-- Contact Info --}}
                    @if($loa_contact_info)
                    <div class="mt-4">
                        @foreach(explode("\n", $loa_contact_info) as $line)
                            <p>{{ $line }}</p>
                        @endforeach
                    </div>
                    @endif

                    {{-- Closing --}}
                    @if($loa_closing_text)
                        <p class="mt-4">{{ $loa_closing_text }}</p>
                    @endif

                    {{-- Signature Preview --}}
                    <div class="mt-8 text-right">
                        <p>{{ $conference->city ?? 'Semarang' }}, ..........</p>
                        <p>Sincerely,</p>
                        <div class="mt-2 mb-2 inline-block">
                            @if($conference->loa_signature_image)
                                <img src="{{ asset('storage/' . $conference->loa_signature_image) }}" alt="Signature" class="h-12 inline-block">
                            @else
                                <div class="h-12"></div>
                            @endif
                        </div>
                        @if($loa_signatory_name)
                            <p class="font-bold">{{ $loa_signatory_name }}</p>
                        @endif
                        @if($loa_signatory_title)
                            <p class="text-xs">{{ $loa_signatory_title }}</p>
                        @endif
                    </div>
                </div>

                {{-- Footer Preview --}}
                @if($loa_footer_text)
                <div class="px-8 py-3 text-right text-xs text-gray-400 italic border-t border-gray-200">
                    {{ $loa_footer_text }}
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    @else
    {{-- No Conference Selected --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="text-lg font-medium text-gray-600 mb-2">Belum Ada Konferensi</h3>
        <p class="text-sm text-gray-400">Buat konferensi terlebih dahulu untuk mengatur template LOA.</p>
    </div>
    @endif
</div>
