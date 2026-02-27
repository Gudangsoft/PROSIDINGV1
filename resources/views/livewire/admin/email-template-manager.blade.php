<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Template Email</h2>
        <p class="text-sm text-gray-500 mt-1">Kustomisasi subjek dan isi email otomatis yang dikirim sistem per kegiatan. Jika dikosongkan, sistem menggunakan template default.</p>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 text-sm flex items-center gap-2">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 text-sm">{{ session('error') }}</div>
    @endif

    {{-- Select Conference --}}
    <div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kegiatan / Konferensi</label>
        <select wire:model.live="selectedConferenceId" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 max-w-lg">
            <option value="">— Pilih kegiatan —</option>
            @foreach($conferences as $conf)
            <option value="{{ $conf->id }}">{{ $conf->name }}{{ $conf->acronym ? ' (' . $conf->acronym . ')' : '' }}</option>
            @endforeach
        </select>
        @if($conferences->isEmpty())
        <p class="text-xs text-amber-600 mt-2">Belum ada kegiatan. <a href="{{ route('admin.conferences.create') }}" class="underline">Buat kegiatan terlebih dahulu</a>.</p>
        @endif
    </div>

    @if($selectedConferenceId)
    <form wire:submit="save">
        @php
            $colorMap = [
                'blue'    => ['bg' => 'bg-blue-50',    'border' => 'border-blue-200',   'badge' => 'bg-blue-100 text-blue-700',    'icon' => 'text-blue-500'],
                'green'   => ['bg' => 'bg-green-50',   'border' => 'border-green-200',  'badge' => 'bg-green-100 text-green-700',  'icon' => 'text-green-500'],
                'yellow'  => ['bg' => 'bg-yellow-50',  'border' => 'border-yellow-200', 'badge' => 'bg-yellow-100 text-yellow-700','icon' => 'text-yellow-500'],
                'indigo'  => ['bg' => 'bg-indigo-50',  'border' => 'border-indigo-200', 'badge' => 'bg-indigo-100 text-indigo-700','icon' => 'text-indigo-500'],
                'purple'  => ['bg' => 'bg-purple-50',  'border' => 'border-purple-200', 'badge' => 'bg-purple-100 text-purple-700','icon' => 'text-purple-500'],
                'emerald' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200','badge' => 'bg-emerald-100 text-emerald-700','icon' => 'text-emerald-500'],
                'red'     => ['bg' => 'bg-red-50',     'border' => 'border-red-200',    'badge' => 'bg-red-100 text-red-700',     'icon' => 'text-red-500'],
                'orange'  => ['bg' => 'bg-orange-50',  'border' => 'border-orange-200', 'badge' => 'bg-orange-100 text-orange-700','icon' => 'text-orange-500'],
            ];
        @endphp

        <div class="space-y-4">
            @foreach($emailTypes as $typeKey => $typeCfg)
            @php
                $color = $typeCfg['color'] ?? 'blue';
                $cm = $colorMap[$color] ?? $colorMap['blue'];
                $tpl = $emailTemplates[$typeKey] ?? ['id' => null, 'subject' => '', 'body' => '', 'is_active' => true];
                $isCustomized = !empty($tpl['subject']) || !empty($tpl['body']);
            @endphp
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden" wire:key="tpl-{{ $typeKey }}">
                {{-- Card Header --}}
                <div class="flex items-center gap-3 px-5 py-3.5 {{ $cm['bg'] }} border-b {{ $cm['border'] }}">
                    <div class="w-8 h-8 rounded-lg border {{ $cm['border'] }} {{ $cm['bg'] }} flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 {{ $cm['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeCfg['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-semibold text-gray-800 text-sm">{{ $typeCfg['label'] }}</span>
                            @if($isCustomized)
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $cm['badge'] }}">✏ Dikustomisasi</span>
                            @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Default</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $typeCfg['desc'] }}</p>
                    </div>
                    @if($isCustomized)
                    <button type="button"
                        wire:click="resetTemplate('{{ $typeKey }}')"
                        wire:confirm="Reset template ini ke default? Kustomisasi akan dihapus."
                        class="shrink-0 text-xs px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Reset Default
                    </button>
                    @endif
                </div>

                {{-- Card Body --}}
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Subjek Email
                            <span class="text-gray-400 font-normal ml-1">— kosongkan untuk gunakan default</span>
                        </label>
                        <input type="text"
                            wire:model="emailTemplates.{{ $typeKey }}.subject"
                            placeholder="{{ $typeCfg['default_subject'] }}"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>

    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Isi Email
                            <span class="text-gray-400 font-normal ml-1">— HTML diperbolehkan, kosongkan untuk gunakan default</span>
                        </label>
                        <textarea wire:model="emailTemplates.{{ $typeKey }}.body"
                            id="body-{{ $typeKey }}"
                            rows="5"
                            placeholder="Tulis isi email di sini... Contoh HTML: <p>Halo <b>{{ '{{ $name }}' }}</b>, ...</p>"
                            class="w-full px-3 py-2 border rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500"></textarea>

                        {{-- Button & Asset Insert Helper --}}
                        <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                            <div x-data="{ open: false, btnLabel: '', btnUrl: '' }" class="space-y-2">
                                {{-- Insert Button row --}}
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-medium text-gray-500">Sisipkan Tombol:</span>
                                    <template x-if="!open">
                                        <button type="button" @click="open=true"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Tambah Tombol
                                        </button>
                                    </template>
                                    <template x-if="open">
                                        <div class="flex items-center gap-2 flex-wrap w-full">
                                            <input x-model="btnLabel" type="text" placeholder="Label tombol" class="px-2 py-1 text-xs border rounded focus:ring-1 focus:ring-blue-400 w-36">
                                            <input x-model="btnUrl" type="text" placeholder="https://..." class="px-2 py-1 text-xs border rounded focus:ring-1 focus:ring-blue-400 flex-1 min-w-32">
                                            <button type="button" @click="
                                                if(!btnLabel||!btnUrl){alert('Isi label dan URL terlebih dahulu.');return;}
                                                const html = '<a href=\'' + btnUrl + '\' style=\'display:inline-block;padding:10px 24px;background:#2563eb;color:#ffffff;text-decoration:none;border-radius:6px;font-size:14px;font-weight:600;\'>' + btnLabel + '</a>';
                                                const ta = document.getElementById('body-{{ $typeKey }}');
                                                const s = ta.selectionStart, e = ta.selectionEnd;
                                                ta.value = ta.value.substring(0,s) + html + ta.value.substring(e);
                                                ta.dispatchEvent(new Event('input'));
                                                open=false; btnLabel=''; btnUrl='';
                                            " class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">Sisipkan</button>
                                            <button type="button" @click="open=false;btnLabel='';btnUrl=''" class="px-2 py-1 text-xs border rounded text-gray-500 hover:bg-gray-100">Batal</button>
                                        </div>
                                    </template>
                                </div>

                                {{-- Asset quick-insert --}}
                                @if(!empty($assets))
                                <div class="flex items-center gap-2 flex-wrap pt-1 border-t border-gray-200">
                                    <span class="text-xs font-medium text-gray-500">File & Link:</span>
                                    @foreach($assets as $asset)
                                    <button type="button"
                                        title="{{ $asset['url'] }}"
                                        onclick="(function(){
                                            const url = '{{ addslashes($asset['url']) }}';
                                            const label = '{{ addslashes($asset['name']) }}';
                                            const html = '<a href=\'' + url + '\'>' + label + '</a>';
                                            const ta = document.getElementById('body-{{ $typeKey }}');
                                            const s = ta.selectionStart, e = ta.selectionEnd;
                                            ta.value = ta.value.substring(0,s) + html + ta.value.substring(e);
                                            ta.dispatchEvent(new Event('input'));
                                        })()"
                                        class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition">
                                        @if($asset['type'] === 'file')
                                        <svg class="w-3 h-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        @else
                                        <svg class="w-3 h-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        @endif
                                        {{ $asset['name'] }}
                                    </button>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Variables --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs text-gray-500 font-medium">Variabel:</span>
                        @foreach($typeCfg['vars'] as $var)
                        <code class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-xs border border-gray-200 cursor-pointer hover:bg-gray-200 transition"
                            title="Klik untuk salin"
                            onclick="navigator.clipboard.writeText('{{ $var }}');this.textContent='✓ Disalin!';setTimeout(()=>this.textContent='{{ $var }}',1500)">{{ $var }}</code>
                        @endforeach
                    </div>

                    {{-- Active toggle --}}
                    <div class="flex items-center gap-2 pt-1 border-t">
                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                            <input type="checkbox"
                                wire:model="emailTemplates.{{ $typeKey }}.is_active"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            Aktifkan template kustom ini
                        </label>
                        <span class="text-xs text-gray-400">(nonaktif = gunakan template default)</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Save Button --}}
        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm inline-flex items-center gap-2">
                <span wire:loading.remove wire:target="save">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Semua Template
                </span>
                <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>

    {{-- ══════════════════════════════════════════════ --}}
    {{-- FILE & LINK ASSET CRUD                         --}}
    {{-- ══════════════════════════════════════════════ --}}
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">File &amp; Link Aset</h3>
                <p class="text-sm text-gray-500 mt-0.5">Kelola file dan link yang bisa disisipkan ke dalam isi email template.</p>
            </div>
        </div>

        @if(session('assetSuccess'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('assetSuccess') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- Form Panel --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border p-5">
                <h4 class="text-sm font-semibold text-gray-700 mb-4">
                    {{ $editingAssetId ? '✏ Edit Aset' : '➕ Tambah Aset Baru' }}
                </h4>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama / Label</label>
                        <input wire:model="assetName" type="text" placeholder="cth: Formulir Pendaftaran"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 @error('assetName') border-red-400 @enderror">
                        @error('assetName')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tipe</label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-2 cursor-pointer text-sm">
                                <input type="radio" wire:model.live="assetType" value="link" class="text-blue-600"> Link / URL
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer text-sm">
                                <input type="radio" wire:model.live="assetType" value="file" class="text-blue-600"> Upload File
                            </label>
                        </div>
                    </div>

                    @if($assetType === 'link')
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">URL</label>
                        <input wire:model="assetUrl" type="url" placeholder="https://..."
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 @error('assetUrl') border-red-400 @enderror">
                        @error('assetUrl')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    @else
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">File
                            @if($editingAssetId) <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengganti)</span> @endif
                        </label>
                        <input wire:model="assetFile" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                            class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('assetFile') border-red-400 @enderror">
                        @error('assetFile')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    @endif

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Keterangan <span class="font-normal text-gray-400">(opsional)</span></label>
                        <input wire:model="assetDesc" type="text" placeholder="cth: Link Google Form pendaftaran"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                            <input type="checkbox" wire:model="assetGlobal" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            Aset Global (tersedia di semua kegiatan)
                        </label>
                    </div>

                    <div class="flex gap-2 pt-1">
                        <button type="button" wire:click="saveAsset"
                            wire:loading.attr="disabled" wire:target="saveAsset,assetFile"
                            class="flex-1 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 disabled:opacity-60 inline-flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="saveAsset,assetFile">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                {{ $editingAssetId ? 'Perbarui' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="saveAsset,assetFile" class="inline-flex items-center gap-1">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Menyimpan...
                            </span>
                        </button>
                        @if($editingAssetId)
                        <button type="button" wire:click="resetAssetForm"
                            class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                            Batal
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Asset List --}}
            <div class="lg:col-span-3">
                @if(empty($assets))
                <div class="bg-white rounded-xl border-2 border-dashed border-gray-200 p-10 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    <p class="text-gray-500 font-medium text-sm">Belum ada aset</p>
                    <p class="text-gray-400 text-xs mt-1">Tambahkan file atau link yang akan disisipkan ke email.</p>
                </div>
                @else
                <div class="space-y-2">
                    @foreach($assets as $asset)
                    <div class="bg-white rounded-xl border px-4 py-3 flex items-start gap-3 hover:border-blue-200 transition" wire:key="asset-{{ $asset['id'] }}">
                        <div class="w-9 h-9 rounded-lg {{ $asset['type'] === 'file' ? 'bg-indigo-50 text-indigo-600' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center shrink-0 mt-0.5">
                            @if($asset['type'] === 'file')
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            @else
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-medium text-sm text-gray-800">{{ $asset['name'] }}</span>
                                <span class="px-1.5 py-0.5 rounded text-xs {{ $asset['type'] === 'file' ? 'bg-indigo-100 text-indigo-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $asset['type'] === 'file' ? 'File' : 'Link' }}
                                </span>
                                @if($asset['is_global'])
                                <span class="px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-500">Global</span>
                                @endif
                            </div>
                            @if($asset['description'])
                            <p class="text-xs text-gray-500 mt-0.5">{{ $asset['description'] }}</p>
                            @endif
                            <a href="{{ $asset['url'] }}" target="_blank" class="text-xs text-blue-500 hover:underline break-all mt-0.5 block truncate max-w-xs" title="{{ $asset['url'] }}">{{ $asset['url'] }}</a>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button" wire:click="editAsset({{ $asset['id'] }})"
                                class="p-1.5 rounded hover:bg-gray-100 text-gray-500 hover:text-blue-600 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" wire:click="deleteAsset({{ $asset['id'] }})"
                                wire:confirm="Hapus aset '{{ $asset['name'] }}'?"
                                class="p-1.5 rounded hover:bg-red-50 text-gray-400 hover:text-red-600 transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    @else
    <div class="bg-white rounded-xl border-2 border-dashed border-gray-200 p-12 text-center">
        <svg class="w-14 h-14 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <p class="text-gray-500 font-medium">Pilih kegiatan di atas</p>
        <p class="text-gray-400 text-sm mt-1">Template email akan ditampilkan setelah kegiatan dipilih.</p>
    </div>
    @endif
</div>
