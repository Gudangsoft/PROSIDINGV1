<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Tenant</h1>
            <p class="text-sm text-gray-500">Provisioning tenant, domain, dan database — satu tempat untuk semua site di platform ini.</p>
        </div>
    </div>

    {{-- Tutorial / Panduan Penggunaan --}}
    <div x-data="{ open: false }" class="bg-indigo-50 border border-indigo-200 rounded-xl mb-6 overflow-hidden">
        <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-5 py-3.5 text-left">
            <span class="flex items-center gap-2 font-semibold text-indigo-900 text-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Panduan Penggunaan — Kelola Tenant
            </span>
            <svg class="w-5 h-5 text-indigo-500 transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div x-show="open" x-cloak class="px-5 pb-5 text-sm text-indigo-900 space-y-4">
            <div>
                <p class="font-semibold mb-1">1. Membuat tenant baru</p>
                <p class="text-indigo-800/90">Isi <strong>ID Tenant</strong> (huruf kecil, angka, tanda minus — mis. <code class="bg-white px-1 rounded">kampus-abc</code>) dan <strong>Domain</strong> di form "Tambah Tenant Baru", lalu klik <strong>Buat Tenant</strong>. Sistem otomatis membuat database baru, menjalankan migrasi, dan mendaftarkan domainnya. Proses ini aman dijalankan ulang — kalau ID sudah ada atau sempat gagal di tengah jalan (mis. karena izin database), tinggal klik lagi dan sistem melanjutkan dari langkah yang belum selesai.</p>
                <p class="text-indigo-800/90 mt-1">Centang <strong>"Salin data dari central"</strong> hanya kalau ini situs lama yang datanya mau dipindah jadi tenant pertama (seperti SINACON kemarin) — untuk tenant baru yang belum punya data, biarkan tidak dicentang.</p>
                <p class="text-indigo-800/90 mt-1">Isi juga <strong>Nama/Email/Password Admin</strong> kalau mau langsung punya akun admin pertama begitu tenant selesai dibuat — kalau dikosongkan, tenant tetap kebuat tapi belum ada usernya sama sekali (perlu dibuatkan manual belakangan).</p>
            </div>
            <div>
                <p class="font-semibold mb-1">2. Verifikasi domain</p>
                <p class="text-indigo-800/90">Domain baru selalu berstatus <span class="bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded-full text-xs">pending</span> sampai kepemilikannya terbukti. Sistem menampilkan record <strong>TXT</strong> yang perlu ditambahkan ke DNS domain tersebut (nama record + kode unik). Setelah pemilik domain menambahkan record itu:</p>
                <ul class="list-disc list-inside text-indigo-800/90 mt-1 space-y-0.5">
                    <li>Klik <strong>"Cek DNS"</strong> — sistem cek otomatis, langsung verified kalau cocok.</li>
                    <li>Atau klik <strong>"Verifikasi manual"</strong> kalau yakin domain itu memang sah tanpa perlu menunggu DNS (skip pengecekan).</li>
                </ul>
            </div>
            <div>
                <p class="font-semibold mb-1">3. Aktifkan HTTPS untuk domain baru</p>
                <p class="text-indigo-800/90">Verifikasi di sini <strong>belum otomatis mengaktifkan SSL</strong> di server (server ini pakai Apache/aaPanel, bukan Caddy). Setelah domain verified, tambahkan secara manual: aaPanel → <strong>Website → Add Site</strong> dengan domain tsb, arahkan ke folder project yang sama, lalu <strong>SSL → Let's Encrypt</strong> untuk sertifikat gratis.</p>
            </div>
            <div>
                <p class="font-semibold mb-1">4. Menambah domain ke tenant yang sudah ada</p>
                <p class="text-indigo-800/90">Klik <strong>"+ Tambah domain"</strong> pada baris tenant yang dituju. Berguna kalau satu tenant perlu diakses dari lebih dari satu domain (mis. domain lama & domain baru sekaligus).</p>
            </div>
            <div>
                <p class="font-semibold mb-1">5. Menghapus tenant</p>
                <p class="text-indigo-800/90 flex items-start gap-1.5">
                    <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span><strong>Ini menghapus database tenant secara permanen</strong> — semua paper, pembayaran, dan user di tenant itu ikut hilang, tidak bisa dikembalikan. Klik "Hapus", lalu ketik persis ID tenant-nya untuk konfirmasi sebelum benar-benar terhapus.</span>
                </p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 mb-4 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['tenants'] }}</p>
                    <p class="text-xs text-gray-500">Total Tenant</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['verified'] }}</p>
                    <p class="text-xs text-gray-500">Domain Terverifikasi</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
                    <p class="text-xs text-gray-500">Domain Pending Verifikasi</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Tenant Form --}}
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-8">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
            <h2 class="font-semibold text-gray-800">Tambah Tenant Baru</h2>
        </div>
        <form wire:submit="create" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">ID Tenant</label>
                <input type="text" wire:model="newId" placeholder="mis. kampus-abc"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('newId') border-red-400 @enderror">
                @error('newId')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Domain</label>
                <input type="text" wire:model="newDomain" placeholder="mis. prosiding.kampusabc.ac.id"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('newDomain') border-red-400 @enderror">
                @error('newDomain')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-3 h-[42px]">
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" wire:model="copyFromCentral" class="rounded border-gray-300">
                    Salin data dari central
                </label>
            </div>

            <div class="md:col-span-3 pt-2 mt-1 border-t border-gray-100">
                <p class="text-xs font-medium text-gray-500 mb-3">Akun admin pertama (opsional — kosongkan kalau mau dibuat manual nanti)</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Admin</label>
                <input type="text" wire:model="adminName" placeholder="mis. Admin Kampus ABC"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('adminName') border-red-400 @enderror">
                @error('adminName')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Admin</label>
                <input type="email" wire:model="adminEmail" placeholder="admin@kampusabc.ac.id"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('adminEmail') border-red-400 @enderror">
                @error('adminEmail')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Admin</label>
                <input type="password" wire:model="adminPassword" placeholder="minimal 8 karakter"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('adminPassword') border-red-400 @enderror">
                @error('adminPassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-3 flex items-center gap-3">
                <button type="submit" wire:loading.attr="disabled" wire:target="create"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition disabled:opacity-50 text-sm">
                    <svg wire:loading wire:target="create" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    <span wire:loading.remove wire:target="create">Buat Tenant</span>
                    <span wire:loading wire:target="create">Memproses (bisa beberapa detik)...</span>
                </button>
                <p class="text-xs text-gray-400">Kalau ID sudah ada, sistem otomatis menyambung dari mana proses terakhir berhenti — aman dijalankan ulang.</p>
            </div>
        </form>

        @if (!empty($lastLog))
            <div class="mt-5 bg-gray-900 text-gray-100 text-xs font-mono rounded-lg p-4 overflow-x-auto max-h-64 overflow-y-auto">
                @foreach ($lastLog as $line)
                    <div class="{{ str_contains($line, 'ERROR') ? 'text-red-400' : '' }}">{{ $line }}</div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Search --}}
    <div class="mb-4">
        <div class="relative max-w-sm">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari ID tenant atau domain..."
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
        </div>
    </div>

    {{-- Tenant List --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-5 py-3">Tenant</th>
                    <th class="px-5 py-3">Domain</th>
                    <th class="px-5 py-3">Database</th>
                    <th class="px-5 py-3">Dibuat</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($tenants as $tenant)
                    <tr class="align-top">
                        <td class="px-5 py-4 font-medium text-gray-800 whitespace-nowrap">{{ $tenant->id }}</td>
                        <td class="px-5 py-4">
                            <div class="space-y-2">
                                @forelse ($tenant->domains as $domain)
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <a href="https://{{ $domain->domain }}" target="_blank" rel="noopener"
                                                class="text-gray-700 hover:text-indigo-600 hover:underline inline-flex items-center gap-1">
                                                {{ $domain->domain }}
                                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            </a>
                                            @if ($domain->verified_at)
                                                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">verified</span>
                                            @else
                                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">pending</span>
                                                <button wire:click="checkDomainDns({{ $domain->id }})" wire:loading.attr="disabled"
                                                    class="text-xs text-indigo-600 hover:underline">Cek DNS</button>
                                                <button wire:click="verifyDomainNow({{ $domain->id }})"
                                                    wire:confirm="Tandai domain ini terverifikasi tanpa cek DNS? Cuma lakukan ini kalau Anda yakin domain ini memang milik tenant tsb."
                                                    class="text-xs text-gray-500 hover:underline">Verifikasi manual</button>
                                            @endif
                                        </div>
                                        @if (!$domain->verified_at)
                                            <p class="text-[11px] text-gray-400 mt-0.5">
                                                TXT record: <code class="bg-gray-100 px-1 rounded">{{ $domain->verificationRecordName() }}</code>
                                                = <code class="bg-gray-100 px-1 rounded">{{ $domain->verification_token }}</code>
                                            </p>
                                        @endif
                                    </div>
                                @empty
                                    <span class="text-gray-400">—</span>
                                @endforelse

                                @if ($addDomainTenantId === $tenant->id)
                                    <div class="mt-2 flex items-start gap-2">
                                        <div>
                                            <input type="text" wire:model="addDomainValue" placeholder="domain-baru.com"
                                                class="px-3 py-1.5 border border-gray-300 rounded-lg text-xs outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('addDomainValue') border-red-400 @enderror">
                                            @error('addDomainValue')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <button wire:click="addDomain" class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700">Simpan</button>
                                        <button wire:click="cancelAddDomain" class="text-xs text-gray-500 px-2 py-1.5 hover:underline">Batal</button>
                                    </div>
                                @else
                                    <button wire:click="startAddDomain('{{ $tenant->id }}')" class="text-xs text-indigo-600 hover:underline mt-1">+ Tambah domain</button>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-500 font-mono text-xs whitespace-nowrap">{{ $tenant->database()->getName() }}</td>
                        <td class="px-5 py-4 text-gray-500 whitespace-nowrap">{{ $tenant->created_at->format('d M Y H:i') }}</td>
                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            @if ($addAdminTenantId === $tenant->id)
                                <div class="text-left bg-indigo-50 border border-indigo-200 rounded-lg p-3 inline-block w-64">
                                    <p class="text-xs text-indigo-700 mb-2 font-medium">Tambah admin ke '{{ $tenant->id }}':</p>
                                    <div class="space-y-1.5">
                                        <div>
                                            <input type="text" wire:model="addAdminName" placeholder="Nama"
                                                class="w-full px-2 py-1 border border-gray-300 rounded text-xs outline-none @error('addAdminName') border-red-400 @enderror">
                                            @error('addAdminName')<p class="text-red-500 text-[11px] mt-0.5">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <input type="email" wire:model="addAdminEmail" placeholder="Email"
                                                class="w-full px-2 py-1 border border-gray-300 rounded text-xs outline-none @error('addAdminEmail') border-red-400 @enderror">
                                            @error('addAdminEmail')<p class="text-red-500 text-[11px] mt-0.5">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <input type="password" wire:model="addAdminPassword" placeholder="Password (min 8 karakter)"
                                                class="w-full px-2 py-1 border border-gray-300 rounded text-xs outline-none @error('addAdminPassword') border-red-400 @enderror">
                                            @error('addAdminPassword')<p class="text-red-500 text-[11px] mt-0.5">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <button wire:click="addAdmin" wire:loading.attr="disabled" wire:target="addAdmin"
                                            class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700">Simpan</button>
                                        <button wire:click="cancelAddAdmin" class="text-xs text-gray-500 px-2 py-1.5 hover:underline">Batal</button>
                                    </div>
                                </div>
                            @elseif ($confirmingDeleteId === $tenant->id)
                                <div class="text-left bg-red-50 border border-red-200 rounded-lg p-3 inline-block">
                                    <p class="text-xs text-red-700 mb-2">Ketik <strong>{{ $tenant->id }}</strong> untuk hapus permanen tenant beserta database-nya:</p>
                                    <div class="flex items-center gap-2">
                                        <input type="text" wire:model="deleteConfirmText"
                                            class="px-2 py-1 border border-red-300 rounded text-xs w-32 outline-none">
                                        <button wire:click="deleteTenant" class="text-xs bg-red-600 text-white px-3 py-1.5 rounded-lg hover:bg-red-700">Hapus</button>
                                        <button wire:click="cancelDelete" class="text-xs text-gray-500 hover:underline">Batal</button>
                                    </div>
                                    @error('deleteConfirmText')<p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>@enderror
                                </div>
                            @else
                                <div class="flex items-center justify-end gap-3">
                                    <button wire:click="startAddAdmin('{{ $tenant->id }}')" class="text-xs text-indigo-600 hover:underline">+ Tambah admin</button>
                                    <button wire:click="confirmDelete('{{ $tenant->id }}')" class="text-xs text-red-600 hover:underline">Hapus</button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                            @if ($search)
                                Tidak ada tenant yang cocok dengan pencarian "{{ $search }}".
                            @else
                                Belum ada tenant. Buat yang pertama lewat form di atas.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
