<div class="p-6 max-w-5xl mx-auto">

    {{-- ── Header ── --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zm-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884zm8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WA Blaster
        </h1>
        <p class="text-sm text-gray-500 mt-1">Kirim pesan WhatsApp massal ke pengguna terdaftar via Fonnte API</p>
    </div>

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</div>
            <div class="text-xs text-gray-500 mt-1">Total Blast</div>
        </div>
        <div class="bg-white rounded-xl border p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</div>
            <div class="text-xs text-gray-500 mt-1">Berhasil</div>
        </div>
        <div class="bg-white rounded-xl border p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-red-500">{{ $stats['failed'] }}</div>
            <div class="text-xs text-gray-500 mt-1">Gagal</div>
        </div>
        <div class="bg-white rounded-xl border p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_sent']) }}</div>
            <div class="text-xs text-gray-500 mt-1">Total Terkirim</div>
        </div>
    </div>

    {{-- ── Tabs ── --}}
    <div class="flex gap-1 mb-6 bg-gray-100 p-1 rounded-xl w-fit">
        <button wire:click="$set('activeTab','compose')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition
            {{ $activeTab === 'compose' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
            ✉️ Kirim Blast
        </button>
        <button wire:click="$set('activeTab','history')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition
            {{ $activeTab === 'history' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
            📋 Riwayat
        </button>
        <button wire:click="$set('activeTab','settings')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition
            {{ $activeTab === 'settings' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
            ⚙️ Pengaturan
        </button>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- TAB: COMPOSE --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    @if($activeTab === 'compose')

    {{-- Flash messages --}}
    @if(session('compose_success'))
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center gap-2 text-sm">
        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('compose_success') }}
    </div>
    @endif
    @if(session('compose_error'))
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg flex items-center gap-2 text-sm">
        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        {{ session('compose_error') }}
    </div>
    @endif

    @if(empty(config('app.wa_token')) && empty(\App\Models\Setting::getValue('wa_token')))
    <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 text-amber-800 rounded-r-lg text-sm">
        <strong>⚠️ Perhatian:</strong> Token API Fonnte belum dikonfigurasi.
        <button wire:click="$set('activeTab','settings')" class="underline font-semibold ml-1">Atur sekarang di tab Pengaturan →</button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Compose Form --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Title --}}
            <div class="bg-white rounded-xl border shadow-sm p-5">
                <h2 class="font-semibold text-gray-800 mb-4">Compose Pesan</h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Blast <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" wire:model="blastTitle"
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500"
                        placeholder="Cth: Reminder Pembayaran Registrasi">
                </div>

                {{-- Recipient Type --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Penerima</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['all' => '🌐 Semua Pengguna', 'role' => '👥 Per Role', 'custom' => '📝 Nomor Manual'] as $val => $label)
                        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer text-sm font-medium transition
                            {{ $recipientType === $val ? 'border-green-500 bg-green-50 text-green-700' : 'border-gray-200 hover:border-gray-300 text-gray-700' }}">
                            <input type="radio" wire:model.live="recipientType" value="{{ $val }}" class="text-green-600 focus:ring-green-500">
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Role selector --}}
                @if($recipientType === 'role')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Role</label>
                    <select wire:model.live="recipientRole" class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">-- Pilih Role --</option>
                        <option value="author">Author / Pemakalah</option>
                        <option value="reviewer">Reviewer</option>
                        <option value="editor">Editor</option>
                        <option value="participant">Peserta</option>
                        <option value="keuangan">Keuangan</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('recipientRole') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                @endif

                {{-- Custom phones --}}
                @if($recipientType === 'custom')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Daftar Nomor WA <span class="text-gray-400 font-normal">(1 nomor per baris)</span></label>
                    <textarea wire:model.lazy="customPhones" rows="5"
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500 font-mono"
                        placeholder="08123456789&#10;628234567890&#10;+62812345678"></textarea>
                    <p class="text-xs text-gray-400 mt-1">Format 08xx, +62xx, atau 62xx — otomatis dikonversi ke format internasional.</p>
                </div>
                @endif

                {{-- Message --}}
                <div class="mb-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                    <textarea wire:model="message" rows="8"
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500"
                        placeholder="Tulis pesan WhatsApp Anda di sini..."></textarea>
                    @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">
                        Variabel tersedia: <code class="bg-gray-100 px-1 rounded">{name}</code>
                        <code class="bg-gray-100 px-1 rounded">{email}</code>
                        <code class="bg-gray-100 px-1 rounded">{phone}</code>
                        <code class="bg-gray-100 px-1 rounded">{role}</code>
                    </p>
                </div>
            </div>

            {{-- Test Send --}}
            <div class="bg-white rounded-xl border shadow-sm p-5">
                <h2 class="font-semibold text-gray-800 mb-3">Test Kirim</h2>
                <div class="flex gap-3">
                    <input type="text" wire:model="testPhone"
                        class="flex-1 border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500"
                        placeholder="Nomor WA Anda (cth: 08123456789)">
                    <button wire:click="sendTest" wire:loading.attr="disabled"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition disabled:opacity-50 flex items-center gap-2 whitespace-nowrap">
                        <span wire:loading.remove wire:target="sendTest">📤 Test Kirim</span>
                        <span wire:loading wire:target="sendTest">⏳ Mengirim...</span>
                    </button>
                </div>
                @error('testPhone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Send Blast Button --}}
            <button wire:click="sendBlast" wire:loading.attr="disabled"
                wire:confirm="Anda yakin ingin mengirim blast ke {{ $recipientCount }} penerima?"
                class="w-full py-3 bg-green-600 text-white rounded-xl font-bold text-sm hover:bg-green-700 transition disabled:opacity-50 flex items-center justify-center gap-2 shadow-md">
                <span wire:loading.remove wire:target="sendBlast">
                    <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zm-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884zm8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Kirim Blast ke {{ $recipientCount }} Penerima
                </span>
                <span wire:loading wire:target="sendBlast">⏳ Menjadwalkan...</span>
            </button>
        </div>

        {{-- Recipient Preview --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-xl border shadow-sm p-5 sticky top-4">
                <h2 class="font-semibold text-gray-800 mb-3">Preview Penerima</h2>

                <button wire:click="previewRecipients" class="mb-3 text-xs text-blue-600 hover:underline flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Refresh
                </button>

                <div class="flex items-center justify-between mb-3 p-3 bg-green-50 rounded-lg">
                    <span class="text-sm text-gray-600">Total penerima dengan nomor WA:</span>
                    <span class="text-xl font-bold text-green-700">{{ $recipientCount }}</span>
                </div>

                @if(!empty($recipientPreview))
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Contoh (5 pertama)</p>
                    @foreach($recipientPreview as $r)
                    <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                        <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-xs shrink-0">
                            {{ strtoupper(substr($r['name'], 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-medium text-gray-800 truncate">{{ $r['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $r['phone'] }}</p>
                        </div>
                        <span class="ml-auto text-[10px] px-1.5 py-0.5 rounded bg-blue-100 text-blue-700 font-semibold shrink-0">{{ $r['role'] }}</span>
                    </div>
                    @endforeach
                    @if($recipientCount > 5)
                    <p class="text-xs text-gray-400 text-center pt-1">+{{ $recipientCount - 5 }} penerima lainnya</p>
                    @endif
                </div>
                @elseif($recipientType === 'custom')
                <p class="text-sm text-gray-400 text-center py-4">Masukkan nomor di kolom kiri, lalu klik Refresh.</p>
                @else
                <p class="text-sm text-gray-400 text-center py-4">Klik Refresh untuk melihat preview penerima.</p>
                @endif

                {{-- Message preview --}}
                @if(!empty($message))
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Preview Pesan</p>
                    <div class="bg-green-50 border border-green-200 rounded-xl p-3 text-sm text-gray-800 whitespace-pre-wrap max-h-48 overflow-y-auto">{{ $message }}</div>
                    <p class="text-xs text-gray-400 mt-1">{{ mb_strlen($message) }} karakter</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- TAB: HISTORY --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    @if($activeTab === 'history')

    @if(session('history_success'))
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center gap-2 text-sm">
        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('history_success') }}
    </div>
    @endif

    {{-- Delete confirm modal --}}
    @if($confirmDeleteId)
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Log Blast?</h3>
            <p class="text-sm text-gray-600 mb-5">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3 justify-end">
                <button wire:click="cancelDelete" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                <button wire:click="deleteBlast" class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Riwayat Blast</h2>
        </div>

        @if($blasts->isEmpty())
        <div class="py-16 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-sm">Belum ada riwayat blast.</p>
            <button wire:click="$set('activeTab','compose')" class="mt-3 text-sm text-blue-600 hover:underline">Buat blast pertama →</button>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Judul</th>
                        <th class="px-4 py-3 text-left">Penerima</th>
                        <th class="px-4 py-3 text-left">Pesan</th>
                        <th class="px-4 py-3 text-center">Total</th>
                        <th class="px-4 py-3 text-center">Terkirim</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-left">Waktu</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($blasts as $blast)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4">
                            <p class="font-medium text-gray-800 max-w-[160px] truncate">{{ $blast->title }}</p>
                            <p class="text-xs text-gray-400">oleh {{ $blast->creator?->name ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-4">
                            @if($blast->recipient_type === 'all')
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Semua</span>
                            @elseif($blast->recipient_type === 'role')
                                <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">{{ ucfirst($blast->recipient_role ?? '-') }}</span>
                            @else
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Custom</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 max-w-[200px]">
                            <p class="text-xs text-gray-600 line-clamp-2">{{ Str::limit($blast->message, 80) }}</p>
                        </td>
                        <td class="px-4 py-4 text-center font-semibold text-gray-700">{{ $blast->total_recipients }}</td>
                        <td class="px-4 py-4 text-center">
                            <div class="text-green-600 font-semibold">{{ $blast->sent_count }}</div>
                            @if($blast->failed_count > 0)
                            <div class="text-red-500 text-xs">{{ $blast->failed_count }} gagal</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            @php
                                $colors = ['completed'=>'green','failed'=>'red','sending'=>'yellow','draft'=>'gray'];
                                $color = $colors[$blast->status] ?? 'gray';
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                bg-{{ $color }}-100 text-{{ $color }}-700">
                                @if($blast->status === 'sending')
                                <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                @endif
                                {{ $blast->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-xs text-gray-500 whitespace-nowrap">
                            {{ $blast->sent_at ? $blast->sent_at->format('d/m/Y H:i') : $blast->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            <button wire:click="confirmDelete({{ $blast->id }})"
                                class="text-red-500 hover:text-red-700 transition p-1 rounded hover:bg-red-50" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $blasts->links() }}
        </div>
        @endif
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- TAB: SETTINGS --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    @if($activeTab === 'settings')

    @if(session('settings_success'))
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center gap-2 text-sm">
        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('settings_success') }}
    </div>
    @endif

    @if(session('settings_error'))
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg flex items-center gap-2 text-sm">
        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        {{ session('settings_error') }}
    </div>
    @endif

    <div class="bg-white rounded-xl border shadow-sm p-6 max-w-2xl">
        <h2 class="font-bold text-gray-800 text-lg mb-1">Konfigurasi WA Gateway</h2>
        <p class="text-sm text-gray-500 mb-6">Gunakan <a href="https://fonnte.com" target="_blank" class="text-blue-600 hover:underline">Fonnte.com</a> sebagai gateway pengiriman WhatsApp.</p>

        {{-- Status disconnected warning --}}
        <div class="mb-6 p-4 bg-orange-50 border border-orange-300 rounded-xl">
            <p class="font-semibold text-orange-800 mb-2">⚠️ Jika muncul error "disconnected device":</p>
            <ol class="list-decimal ml-4 space-y-1 text-sm text-orange-800">
                <li>Buka <a href="https://app.fonnte.com" target="_blank" class="underline font-medium">app.fonnte.com</a> dan login</li>
                <li>Klik menu <strong>Device</strong> di sidebar</li>
                <li>Pilih device Anda → klik tombol <strong>Reconnect</strong></li>
                <li>Scan ulang QR code menggunakan WhatsApp di HP Anda<br>
                    <span class="text-xs">(WA → Linked Devices → Link a Device)</span></li>
                <li>Tunggu status berubah menjadi <strong>Connected</strong></li>
                <li>Kembali ke sini dan coba kirim ulang</li>
            </ol>
        </div>

        {{-- Info box --}}
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-800">
            <p class="font-semibold mb-2">📋 Cara mendapatkan Token Fonnte:</p>
            <ol class="list-decimal ml-4 space-y-1 text-sm">
                <li>Daftar di <a href="https://fonnte.com" target="_blank" class="underline font-medium">fonnte.com</a> dan login</li>
                <li>Hubungkan device WhatsApp Anda via QR code</li>
                <li>Salin <strong>Token Device</strong> dari dashboard Fonnte</li>
                <li>Tempel token di kolom di bawah ini dan simpan</li>
            </ol>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Provider Gateway</label>
                <select wire:model="waProvider" class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">
                    <option value="fonnte">Fonnte (fonnte.com)</option>
                </select>
                <p class="text-xs text-gray-400 mt-1">Saat ini hanya mendukung Fonnte. Provider lain akan ditambahkan segera.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Token API / Device Token <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" wire:model="waToken"
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500 pr-24"
                        placeholder="Masukkan token dari dashboard Fonnte">
                    <button type="button" onclick="const i = this.previousElementSibling; i.type = i.type === 'password' ? 'text' : 'password'; this.textContent = i.type === 'password' ? 'Tampilkan' : 'Sembunyikan';"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-blue-600 hover:underline">Tampilkan</button>
                </div>
                @error('waToken') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Pengirim <span class="text-gray-400 font-normal">(opsional, untuk referensi)</span></label>
                <input type="text" wire:model="waSenderNumber"
                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500"
                    placeholder="62812345678">
                <p class="text-xs text-gray-400 mt-1">Nomor WA yang terhubung di Fonnte. Hanya untuk catatan.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Delay Antar Pesan <span class="text-gray-400 font-normal">(detik)</span></label>
                <input type="number" wire:model="waDelay" min="1" max="60"
                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500"
                    placeholder="2">
                @error('waDelay') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 mt-1">Jeda waktu antar pengiriman pesan untuk menghindari spam/rate limit. Minimum 1 detik.</p>
            </div>

            <div class="pt-4 border-t border-gray-100 flex gap-3 flex-wrap">
                <button wire:click="saveSettings" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition disabled:opacity-50">
                    <span wire:loading.remove wire:target="saveSettings">💾 Simpan Pengaturan</span>
                    <span wire:loading wire:target="saveSettings">Menyimpan...</span>
                </button>
                <button wire:click="testConnection" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition disabled:opacity-50">
                    <span wire:loading.remove wire:target="testConnection">🔌 Test Koneksi Device</span>
                    <span wire:loading wire:target="testConnection">Mengecek...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

</div>
