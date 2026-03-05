<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Template Email</h2>
        <p class="text-sm text-gray-500 mt-1">Kustomisasi subjek dan isi email otomatis yang dikirim sistem per kegiatan. Jika dikosongkan, sistem menggunakan template default.</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 text-sm flex items-center gap-2">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 text-sm"><?php echo e(session('error')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kegiatan / Konferensi</label>
        <select wire:model.live="selectedConferenceId" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 max-w-lg">
            <option value="">— Pilih kegiatan —</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $conferences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <option value="<?php echo e($conf->id); ?>"><?php echo e($conf->name); ?><?php echo e($conf->acronym ? ' (' . $conf->acronym . ')' : ''); ?></option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </select>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conferences->isEmpty()): ?>
        <p class="text-xs text-amber-600 mt-2">Belum ada kegiatan. <a href="<?php echo e(route('admin.conferences.create')); ?>" class="underline">Buat kegiatan terlebih dahulu</a>.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedConferenceId): ?>
    <form wire:submit="save">
        <?php
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
        ?>

        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $emailTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeKey => $typeCfg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $color = $typeCfg['color'] ?? 'blue';
                $cm = $colorMap[$color] ?? $colorMap['blue'];
                $tpl = $emailTemplates[$typeKey] ?? ['id' => null, 'subject' => '', 'body' => '', 'is_active' => true];
                $isCustomized = !empty($tpl['subject']) || !empty($tpl['body']);
            ?>
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('tpl-{{ $typeKey }}', get_defined_vars()); ?>wire:key="tpl-<?php echo e($typeKey); ?>">
                
                <div class="flex items-center gap-3 px-5 py-3.5 <?php echo e($cm['bg']); ?> border-b <?php echo e($cm['border']); ?>">
                    <div class="w-8 h-8 rounded-lg border <?php echo e($cm['border']); ?> <?php echo e($cm['bg']); ?> flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 <?php echo e($cm['icon']); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($typeCfg['icon']); ?>"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-semibold text-gray-800 text-sm"><?php echo e($typeCfg['label']); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCustomized): ?>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($cm['badge']); ?>">✏ Dikustomisasi</span>
                            <?php else: ?>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Default</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5"><?php echo e($typeCfg['desc']); ?></p>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCustomized): ?>
                    <button type="button"
                        wire:click="resetTemplate('<?php echo e($typeKey); ?>')"
                        wire:confirm="Reset template ini ke default? Kustomisasi akan dihapus."
                        class="shrink-0 text-xs px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Reset Default
                    </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Subjek Email
                            <span class="text-gray-400 font-normal ml-1">— kosongkan untuk gunakan default</span>
                        </label>
                        <input type="text"
                            wire:model="emailTemplates.<?php echo e($typeKey); ?>.subject"
                            placeholder="<?php echo e($typeCfg['default_subject']); ?>"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>

    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Isi Email
                            <span class="text-gray-400 font-normal ml-1">— HTML diperbolehkan, kosongkan untuk gunakan default</span>
                        </label>
                        <textarea wire:model="emailTemplates.<?php echo e($typeKey); ?>.body"
                            id="body-<?php echo e($typeKey); ?>"
                            rows="5"
                            placeholder="Tulis isi email di sini... Contoh HTML: <p>Halo <b><?php echo e('{{ $name); ?>' }}</b>, ...</p>"
                            class="w-full px-3 py-2 border rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500"></textarea>

                        
                        <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                            <div x-data="{ open: false, btnLabel: '', btnUrl: '' }" class="space-y-2">
                                
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
                                                const ta = document.getElementById('body-<?php echo e($typeKey); ?>');
                                                const s = ta.selectionStart, e = ta.selectionEnd;
                                                ta.value = ta.value.substring(0,s) + html + ta.value.substring(e);
                                                ta.dispatchEvent(new Event('input'));
                                                open=false; btnLabel=''; btnUrl='';
                                            " class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">Sisipkan</button>
                                            <button type="button" @click="open=false;btnLabel='';btnUrl=''" class="px-2 py-1 text-xs border rounded text-gray-500 hover:bg-gray-100">Batal</button>
                                        </div>
                                    </template>
                                </div>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($assets)): ?>
                                <div class="flex items-center gap-2 flex-wrap pt-1 border-t border-gray-200">
                                    <span class="text-xs font-medium text-gray-500">File & Link:</span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <button type="button"
                                        title="<?php echo e($asset['url']); ?>"
                                        onclick="(function(){
                                            const url = '<?php echo e(addslashes($asset['url'])); ?>';
                                            const label = '<?php echo e(addslashes($asset['name'])); ?>';
                                            const html = '<a href=\'' + url + '\'>' + label + '</a>';
                                            const ta = document.getElementById('body-<?php echo e($typeKey); ?>');
                                            const s = ta.selectionStart, e = ta.selectionEnd;
                                            ta.value = ta.value.substring(0,s) + html + ta.value.substring(e);
                                            ta.dispatchEvent(new Event('input'));
                                        })()"
                                        class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($asset['type'] === 'file'): ?>
                                        <svg class="w-3 h-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        <?php else: ?>
                                        <svg class="w-3 h-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php echo e($asset['name']); ?>

                                    </button>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs text-gray-500 font-medium">Variabel:</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $typeCfg['vars']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <code class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-xs border border-gray-200 cursor-pointer hover:bg-gray-200 transition"
                            title="Klik untuk salin"
                            onclick="navigator.clipboard.writeText('<?php echo e($var); ?>');this.textContent='✓ Disalin!';setTimeout(()=>this.textContent='<?php echo e($var); ?>',1500)"><?php echo e($var); ?></code>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    
                    <div class="flex items-center gap-2 pt-1 border-t">
                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                            <input type="checkbox"
                                wire:model="emailTemplates.<?php echo e($typeKey); ?>.is_active"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            Aktifkan template kustom ini
                        </label>
                        <span class="text-xs text-gray-400">(nonaktif = gunakan template default)</span>
                    </div>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
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

    
    
    
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">File &amp; Link Aset</h3>
                <p class="text-sm text-gray-500 mt-0.5">Kelola file dan link yang bisa disisipkan ke dalam isi email template.</p>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('assetSuccess')): ?>
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?php echo e(session('assetSuccess')); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border p-5">
                <h4 class="text-sm font-semibold text-gray-700 mb-4">
                    <?php echo e($editingAssetId ? '✏ Edit Aset' : '➕ Tambah Aset Baru'); ?>

                </h4>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama / Label</label>
                        <input wire:model="assetName" type="text" placeholder="cth: Formulir Pendaftaran"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['assetName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['assetName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assetType === 'link'): ?>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">URL</label>
                        <input wire:model="assetUrl" type="url" placeholder="https://..."
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['assetUrl'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['assetUrl'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">File
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingAssetId): ?> <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengganti)</span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </label>
                        <input wire:model="assetFile" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                            class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 <?php $__errorArgs = ['assetFile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['assetFile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
                                <?php echo e($editingAssetId ? 'Perbarui' : 'Simpan'); ?>

                            </span>
                            <span wire:loading wire:target="saveAsset,assetFile" class="inline-flex items-center gap-1">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Menyimpan...
                            </span>
                        </button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingAssetId): ?>
                        <button type="button" wire:click="resetAssetForm"
                            class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                            Batal
                        </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($assets)): ?>
                <div class="bg-white rounded-xl border-2 border-dashed border-gray-200 p-10 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    <p class="text-gray-500 font-medium text-sm">Belum ada aset</p>
                    <p class="text-gray-400 text-xs mt-1">Tambahkan file atau link yang akan disisipkan ke email.</p>
                </div>
                <?php else: ?>
                <div class="space-y-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="bg-white rounded-xl border px-4 py-3 flex items-start gap-3 hover:border-blue-200 transition" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('asset-{{ $asset[\'id\'] }}', get_defined_vars()); ?>wire:key="asset-<?php echo e($asset['id']); ?>">
                        <div class="w-9 h-9 rounded-lg <?php echo e($asset['type'] === 'file' ? 'bg-indigo-50 text-indigo-600' : 'bg-blue-50 text-blue-600'); ?> flex items-center justify-center shrink-0 mt-0.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($asset['type'] === 'file'): ?>
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            <?php else: ?>
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-medium text-sm text-gray-800"><?php echo e($asset['name']); ?></span>
                                <span class="px-1.5 py-0.5 rounded text-xs <?php echo e($asset['type'] === 'file' ? 'bg-indigo-100 text-indigo-700' : 'bg-blue-100 text-blue-700'); ?>">
                                    <?php echo e($asset['type'] === 'file' ? 'File' : 'Link'); ?>

                                </span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($asset['is_global']): ?>
                                <span class="px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-500">Global</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($asset['description']): ?>
                            <p class="text-xs text-gray-500 mt-0.5"><?php echo e($asset['description']); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <a href="<?php echo e($asset['url']); ?>" target="_blank" class="text-xs text-blue-500 hover:underline break-all mt-0.5 block truncate max-w-xs" title="<?php echo e($asset['url']); ?>"><?php echo e($asset['url']); ?></a>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button" wire:click="editAsset(<?php echo e($asset['id']); ?>)"
                                class="p-1.5 rounded hover:bg-gray-100 text-gray-500 hover:text-blue-600 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" wire:click="deleteAsset(<?php echo e($asset['id']); ?>)"
                                wire:confirm="Hapus aset '<?php echo e($asset['name']); ?>'?"
                                class="p-1.5 rounded hover:bg-red-50 text-gray-400 hover:text-red-600 transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <?php else: ?>
    <div class="bg-white rounded-xl border-2 border-dashed border-gray-200 p-12 text-center">
        <svg class="w-14 h-14 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <p class="text-gray-500 font-medium">Pilih kegiatan di atas</p>
        <p class="text-gray-400 text-sm mt-1">Template email akan ditampilkan setelah kegiatan dipilih.</p>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\livewire\admin\email-template-manager.blade.php ENDPATH**/ ?>