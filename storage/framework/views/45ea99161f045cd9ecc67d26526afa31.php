<div class="p-6 max-w-7xl mx-auto" x-data="{
    tab: <?php if ((object) ('activeTab') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('activeTab'->value()); ?>')<?php echo e('activeTab'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('activeTab'); ?>')<?php endif; ?>,
    showSaveAs: <?php if ((object) ('showSaveAsModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showSaveAsModal'->value()); ?>')<?php echo e('showSaveAsModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showSaveAsModal'); ?>')<?php endif; ?>,
    showCreateTemplate: <?php if ((object) ('showCreateTemplateModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showCreateTemplateModal'->value()); ?>')<?php echo e('showCreateTemplateModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showCreateTemplateModal'); ?>')<?php endif; ?>,
    showImportTemplate: <?php if ((object) ('showImportTemplateModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showImportTemplateModal'->value()); ?>')<?php echo e('showImportTemplateModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showImportTemplateModal'); ?>')<?php endif; ?>,
}">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Tema</h1>
            <p class="text-sm text-gray-500 mt-1">Kustomisasi warna, tipografi, dan layout website — simpan sebagai preset</p>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"><?php echo e(session('error')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">

        
        <div class="xl:col-span-1 space-y-4">
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="px-4 py-3 border-b bg-gray-50 rounded-t-xl flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        Daftar Preset
                    </h2>
                    <div class="flex items-center gap-1">
                        <button wire:click="openImportTemplate" type="button" title="Impor Template (.zip)"
                                class="p-1.5 rounded-lg bg-amber-500 text-white hover:bg-amber-600 transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </button>
                        <button wire:click="openCreateTemplate" type="button" title="Buat Template Baru"
                                class="p-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
                <div class="p-3 space-y-2 max-h-[500px] overflow-y-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="group relative p-3 rounded-lg border transition cursor-pointer
                        <?php echo e($editingPresetId === $preset->id ? 'border-blue-400 bg-blue-50 ring-2 ring-blue-200' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'); ?>"
                        wire:click="loadPreset(<?php echo e($preset->id); ?>)">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <h3 class="text-sm font-semibold text-gray-800 truncate"><?php echo e($preset->name); ?></h3>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($preset->is_active): ?>
                                    <span class="bg-green-100 text-green-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold uppercase">Aktif</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($preset->is_default): ?>
                                    <span class="bg-gray-100 text-gray-500 text-[10px] px-1.5 py-0.5 rounded-full font-bold uppercase">Bawaan</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($preset->description): ?>
                                <p class="text-[11px] text-gray-400 mt-0.5 truncate"><?php echo e($preset->description); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($preset->linked_template): ?>
                                <span class="inline-flex items-center gap-0.5 text-[10px] text-blue-600 mt-0.5">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/></svg>
                                    <?php echo e(ucfirst($preset->linked_template)); ?>

                                </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <div class="flex gap-0.5 shrink-0">
                                <span class="w-3 h-3 rounded-full border border-white shadow-sm" style="background: <?php echo e($preset->primary_color); ?>"></span>
                                <span class="w-3 h-3 rounded-full border border-white shadow-sm" style="background: <?php echo e($preset->secondary_color); ?>"></span>
                                <span class="w-3 h-3 rounded-full border border-white shadow-sm" style="background: <?php echo e($preset->accent_color); ?>"></span>
                            </div>
                        </div>
                        
                        <div class="absolute top-1 right-1 hidden group-hover:flex items-center gap-0.5 bg-white rounded-lg shadow-sm border p-0.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$preset->is_active): ?>
                            <button wire:click.stop="activatePreset(<?php echo e($preset->id); ?>)" title="Aktifkan" class="p-1 rounded hover:bg-green-50 text-green-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <button wire:click.stop="duplicatePreset(<?php echo e($preset->id); ?>)" title="Duplikasi" class="p-1 rounded hover:bg-blue-50 text-blue-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$preset->is_default): ?>
                            <button wire:click.stop="deletePreset(<?php echo e($preset->id); ?>)" wire:confirm="Hapus tema '<?php echo e($preset->name); ?>'?" title="Hapus" class="p-1 rounded hover:bg-red-50 text-red-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="text-center py-6 text-gray-400 text-sm">
                        <p>Belum ada preset.</p>
                        <p class="text-xs">Klik "Simpan" untuk membuat preset pertama.</p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="xl:col-span-2 space-y-5">

            
            <div class="bg-white rounded-xl shadow-sm border p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tema <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="presetName" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Biru Professional">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['presetName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <input type="text" wire:model="presetDescription" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi singkat tema">
                    </div>
                </div>
                
                <div class="mt-3 pt-3 border-t flex items-center justify-between">
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                        Template folder:
                        <code class="bg-gray-100 px-1.5 py-0.5 rounded text-gray-700 font-mono text-[11px]">templates/<?php echo e($linkedTemplate ?: Str::slug($presetName ?: 'nama-tema')); ?>/</code>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Aktif: <strong class="text-gray-700"><?php echo e(ucfirst($currentActiveTemplate)); ?></strong>
                    </div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">Folder template dibuat otomatis saat disimpan berdasarkan nama tema</p>
            </div>

            
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="border-b px-2 bg-gray-50 flex gap-0 overflow-x-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['colors' => 'Warna', 'typography' => 'Tipografi & UI', 'layout' => 'Layout', 'sections' => 'Seksi', 'advanced' => 'Lanjutan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabKey => $tabLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <button @click="tab = '<?php echo e($tabKey); ?>'" type="button"
                            :class="tab === '<?php echo e($tabKey); ?>' ? 'border-blue-600 text-blue-700 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="px-4 py-3 text-sm font-medium border-b-2 transition whitespace-nowrap -mb-px">
                        <?php echo e($tabLabel); ?>

                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                <div class="p-6">
                    
                    <div x-show="tab === 'colors'" x-transition>
                        <h3 class="text-base font-semibold text-gray-800 mb-1">Skema Warna</h3>
                        <p class="text-xs text-gray-400 mb-5">Atur warna untuk admin panel dan halaman publik</p>

                        
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span> Admin Panel
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                                'primary_color' => 'Warna Utama',
                                'secondary_color' => 'Warna Sekunder',
                                'accent_color' => 'Warna Aksen',
                                'sidebar_bg' => 'BG Sidebar',
                                'sidebar_text' => 'Teks Sidebar',
                                'header_bg' => 'BG Header',
                                'body_bg' => 'BG Body',
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1"><?php echo e($label); ?></label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" wire:model.live="form.<?php echo e($field); ?>" class="w-8 h-8 rounded border cursor-pointer shrink-0 p-0.5">
                                    <input type="text" wire:model.live="form.<?php echo e($field); ?>" class="flex-1 border-gray-300 rounded-lg text-xs font-mono focus:ring-blue-500 focus:border-blue-500" maxlength="9">
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <span class="w-2 h-2 bg-teal-500 rounded-full"></span> Halaman Publik
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                                'nav_bg' => 'BG Navbar',
                                'nav_text' => 'Teks Navbar',
                                'hero_bg' => 'BG Hero',
                                'hero_text' => 'Teks Hero',
                                'link_color' => 'Warna Link',
                                'link_hover_color' => 'Link Hover',
                                'button_bg' => 'BG Tombol',
                                'button_text' => 'Teks Tombol',
                                'card_bg' => 'BG Kartu',
                                'card_border' => 'Border Kartu',
                                'section_alt_bg' => 'BG Seksi Alt',
                                'footer_bg' => 'BG Footer',
                                'footer_text_color' => 'Teks Footer',
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1"><?php echo e($label); ?></label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" wire:model.live="form.<?php echo e($field); ?>" class="w-8 h-8 rounded border cursor-pointer shrink-0 p-0.5">
                                    <input type="text" wire:model.live="form.<?php echo e($field); ?>" class="flex-1 border-gray-300 rounded-lg text-xs font-mono focus:ring-blue-500 focus:border-blue-500" maxlength="9">
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>

                    
                    <div x-show="tab === 'typography'" x-cloak x-transition>
                        <h3 class="text-base font-semibold text-gray-800 mb-1">Tipografi & UI</h3>
                        <p class="text-xs text-gray-400 mb-5">Font, sudut elemen, dan gaya bayangan</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Font Utama</label>
                                <select wire:model.live="form.font_family" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $fontOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Font Heading</label>
                                <select wire:model.live="form.heading_font" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $fontOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran Font Base</label>
                                <div class="flex items-center gap-3">
                                    <input type="range" wire:model.live="form.font_size_base" min="12" max="20" step="1" class="flex-1">
                                    <span class="text-sm font-mono text-gray-600 w-12 text-right"><?php echo e($form['font_size_base'] ?? 16); ?>px</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Border Radius</label>
                                <select wire:model.live="form.border_radius" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $borderRadiusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gaya Shadow</label>
                                <select wire:model.live="form.shadow_style" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $shadowOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                        </div>

                        
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border">
                            <p class="text-xs text-gray-400 mb-2">Preview Font:</p>
                            <p class="text-lg" style="font-family: '<?php echo e($form['font_family'] ?? 'Inter'); ?>', sans-serif; font-size: <?php echo e($form['font_size_base'] ?? 16); ?>px;">
                                Contoh teks dengan font <strong style="font-family: '<?php echo e($form['heading_font'] ?? 'Inter'); ?>', sans-serif;"><?php echo e($form['font_family'] ?? 'Inter'); ?></strong>
                            </p>
                            <div class="flex gap-2 mt-3">
                                <div class="px-3 py-1 bg-white border text-xs" style="border-radius: <?php echo e($form['border_radius'] ?? 8); ?>px;">
                                    Border Radius: <?php echo e($form['border_radius'] ?? 8); ?>px
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div x-show="tab === 'layout'" x-cloak x-transition>
                        <h3 class="text-base font-semibold text-gray-800 mb-1">Pengaturan Layout</h3>
                        <p class="text-xs text-gray-400 mb-5">Gaya navbar, hero, footer, kartu, dan lebar kontainer</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gaya Navbar</label>
                                <select wire:model.live="form.navbar_style" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $navbarStyles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gaya Hero Section</label>
                                <select wire:model.live="form.hero_style" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $heroStyles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gaya Footer</label>
                                <select wire:model.live="form.footer_style" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $footerStyles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gaya Kartu</label>
                                <select wire:model.live="form.card_style" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cardStyles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lebar Kontainer</label>
                                <select wire:model.live="form.container_width" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $containerWidthOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                        </div>

                        
                        <div class="mt-6 border rounded-xl overflow-hidden bg-gray-100">
                            <p class="px-3 py-2 bg-gray-50 text-xs text-gray-400 border-b">Preview Layout</p>
                            <div class="p-4">
                                
                                <div class="h-6 rounded-t-lg mb-0.5 flex items-center px-2 gap-1"
                                    style="background-color: <?php echo e($form['nav_bg'] ?? '#ffffff'); ?>; border: 1px solid <?php echo e($form['card_border'] ?? '#e5e7eb'); ?>;">
                                    <div class="w-3 h-3 rounded" style="background: <?php echo e($form['primary_color'] ?? '#2563eb'); ?>;"></div>
                                    <div class="h-1.5 rounded bg-gray-300 w-8 ml-1"></div>
                                    <div class="h-1.5 rounded bg-gray-200 w-6 ml-auto"></div>
                                    <div class="h-1.5 rounded bg-gray-200 w-6 ml-1"></div>
                                </div>
                                
                                <div class="h-16 rounded flex items-center justify-center mb-1"
                                    style="background: <?php echo e(($form['hero_style'] ?? 'gradient') === 'gradient' ? 'linear-gradient(135deg, '.($form['hero_bg'] ?? '#1e40af').','.($form['secondary_color'] ?? '#4f46e5').')' : ($form['hero_bg'] ?? '#1e40af')); ?>;">
                                    <div class="text-center">
                                        <div class="h-2 rounded bg-white/80 w-20 mx-auto mb-1"></div>
                                        <div class="h-1.5 rounded bg-white/50 w-14 mx-auto"></div>
                                    </div>
                                </div>
                                
                                <div class="p-2 rounded" style="background: <?php echo e($form['section_alt_bg'] ?? '#f9fafb'); ?>;">
                                    <div class="flex gap-1.5">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < 3; $i++): ?>
                                        <div class="flex-1 p-1.5"
                                            style="background: <?php echo e($form['card_bg'] ?? '#ffffff'); ?>; border: 1px solid <?php echo e($form['card_border'] ?? '#e5e7eb'); ?>; border-radius: <?php echo e($form['border_radius'] ?? 8); ?>px;">
                                            <div class="h-3 rounded-sm mb-1" style="background: <?php echo e($form['primary_color'] ?? '#2563eb'); ?>; opacity: 0.12;"></div>
                                            <div class="h-1 rounded bg-gray-200 w-3/4"></div>
                                        </div>
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div class="mt-1 flex justify-center gap-1">
                                        <span class="px-2 py-0.5 text-[7px] font-bold" style="background: <?php echo e($form['button_bg'] ?? '#0d9488'); ?>; color: <?php echo e($form['button_text'] ?? '#ffffff'); ?>; border-radius: <?php echo e($form['border_radius'] ?? 8); ?>px;">Button</span>
                                        <span class="px-2 py-0.5 text-[7px] font-bold border" style="color: <?php echo e($form['link_color'] ?? '#0d9488'); ?>; border-color: <?php echo e($form['link_color'] ?? '#0d9488'); ?>; border-radius: <?php echo e($form['border_radius'] ?? 8); ?>px;">Link</span>
                                    </div>
                                </div>
                                
                                <div class="h-5 rounded-b-lg flex items-center justify-center mt-0.5"
                                    style="background: <?php echo e($form['footer_bg'] ?? '#1f2937'); ?>;">
                                    <div class="h-1.5 rounded w-12" style="background: <?php echo e($form['footer_text_color'] ?? '#9ca3af'); ?>; opacity: 0.5;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div x-show="tab === 'sections'" x-cloak x-transition>
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-base font-semibold text-gray-800">Tata Letak Seksi</h3>
                            <button wire:click="resetSections" wire:confirm="Reset urutan seksi ke default?" type="button"
                                    class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Reset
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mb-4">Atur urutan dan visibilitas seksi halaman utama. Gunakan tombol panah atau drag untuk mengubah urutan.</p>

                        <div class="space-y-1" x-data="{
                            dragging: null,
                            dragOver: null,
                            startDrag(e, idx) {
                                this.dragging = idx;
                                e.dataTransfer.effectAllowed = 'move';
                                e.dataTransfer.setData('text/plain', idx);
                            },
                            onDragOver(e, idx) {
                                e.preventDefault();
                                this.dragOver = idx;
                            },
                            onDrop(e, idx) {
                                e.preventDefault();
                                const from = this.dragging;
                                const to = idx;
                                if (from !== null && from !== to) {
                                    // Build new order array
                                    let items = <?php echo \Illuminate\Support\Js::from(collect($sectionsConfig)->pluck('id')->toArray())->toHtml() ?>;
                                    const moved = items.splice(from, 1)[0];
                                    items.splice(to, 0, moved);
                                    $wire.updateSectionOrder(items);
                                }
                                this.dragging = null;
                                this.dragOver = null;
                            },
                            onDragEnd() {
                                this.dragging = null;
                                this.dragOver = null;
                            }
                        }">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sectionsConfig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div draggable="true"
                                 x-on:dragstart="startDrag($event, <?php echo e($index); ?>)"
                                 x-on:dragover="onDragOver($event, <?php echo e($index); ?>)"
                                 x-on:drop="onDrop($event, <?php echo e($index); ?>)"
                                 x-on:dragend="onDragEnd()"
                                 :class="{
                                     'border-blue-400 bg-blue-50 shadow-sm': dragOver === <?php echo e($index); ?>,
                                     'opacity-50': dragging === <?php echo e($index); ?>,
                                     'border-gray-200': dragOver !== <?php echo e($index); ?>

                                 }"
                                 class="flex items-center gap-3 p-3 bg-white border rounded-lg transition-all cursor-grab active:cursor-grabbing group">
                                
                                <div class="text-gray-300 group-hover:text-gray-400 shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-8a2 2 0 10-.001-4.001A2 2 0 0013 6zm0 2a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                                    </svg>
                                </div>

                                
                                <span class="w-6 h-6 flex items-center justify-center rounded-full text-[10px] font-bold shrink-0
                                    <?php echo e($section['visible'] ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-400'); ?>">
                                    <?php echo e($index + 1); ?>

                                </span>

                                
                                <div class="flex-1 min-w-0">
                                    <span class="text-sm font-medium <?php echo e($section['visible'] ? 'text-gray-800' : 'text-gray-400 line-through'); ?>">
                                        <?php echo e($sectionLabels[$section['id']] ?? ucfirst(str_replace('_', ' ', $section['id']))); ?>

                                    </span>
                                    <span class="text-[10px] text-gray-400 ml-1.5 font-mono"><?php echo e($section['id']); ?></span>
                                </div>

                                
                                <div class="flex items-center gap-0.5 shrink-0 opacity-0 group-hover:opacity-100 transition">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index > 0): ?>
                                    <button wire:click="moveSectionUp('<?php echo e($section['id']); ?>')" type="button"
                                            class="p-1 rounded hover:bg-gray-100 text-gray-400 hover:text-gray-600" title="Naik">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    </button>
                                    <?php else: ?>
                                    <span class="p-1 w-5.5"></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index < count($sectionsConfig) - 1): ?>
                                    <button wire:click="moveSectionDown('<?php echo e($section['id']); ?>')" type="button"
                                            class="p-1 rounded hover:bg-gray-100 text-gray-400 hover:text-gray-600" title="Turun">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <?php else: ?>
                                    <span class="p-1 w-5.5"></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <button wire:click="toggleSectionVisibility('<?php echo e($section['id']); ?>')" type="button"
                                        class="relative inline-flex items-center h-5 w-9 rounded-full transition-colors shrink-0
                                            <?php echo e($section['visible'] ? 'bg-blue-600' : 'bg-gray-300'); ?>"
                                        title="<?php echo e($section['visible'] ? 'Sembunyikan' : 'Tampilkan'); ?>">
                                    <span class="inline-block w-3.5 h-3.5 transform bg-white rounded-full shadow transition-transform
                                        <?php echo e($section['visible'] ? 'translate-x-4' : 'translate-x-1'); ?>"></span>
                                </button>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg border flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                <span class="font-medium text-gray-700"><?php echo e(collect($sectionsConfig)->where('visible', true)->count()); ?></span>
                                dari <?php echo e(count($sectionsConfig)); ?> seksi aktif
                            </div>
                            <div class="flex items-center gap-3 text-[10px] text-gray-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-8a2 2 0 10-.001-4.001A2 2 0 0013 6zm0 2a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                                    </svg>
                                    Drag untuk urut
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    Panah untuk geser
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="w-3 h-2 rounded-full bg-blue-600 inline-block"></span>
                                    Toggle visibilitas
                                </span>
                            </div>
                        </div>
                    </div>

                    
                    <div x-show="tab === 'advanced'" x-cloak x-transition>
                        <h3 class="text-base font-semibold text-gray-800 mb-1">Pengaturan Lanjutan</h3>
                        <p class="text-xs text-gray-400 mb-5">Background login & CSS kustom</p>

                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Halaman Login</label>
                            <div class="flex items-start gap-5">
                                <div class="w-40 h-24 bg-gray-100 rounded-lg overflow-hidden border flex items-center justify-center shrink-0">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loginBgImage): ?>
                                        <img src="<?php echo e($loginBgImage->temporaryUrl()); ?>" class="w-full h-full object-cover">
                                    <?php elseif($form['login_bg_image'] ?? false): ?>
                                        <img src="<?php echo e(asset('storage/' . $form['login_bg_image'])); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <input type="file" wire:model="loginBgImage" accept="image/*" class="text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700">
                                    <p class="text-xs text-gray-400 mt-1">Ukuran rekomendasi: 1920x1080 px</p>
                                </div>
                            </div>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Custom CSS</label>
                            <textarea wire:model="form.custom_css" rows="12" class="w-full border-gray-300 rounded-lg text-sm font-mono focus:ring-blue-500 focus:border-blue-500" placeholder="/* Tulis CSS custom Anda di sini */
.my-class {
    color: var(--theme-primary-color);
}"></textarea>
                            <p class="text-xs text-gray-400 mt-1">CSS ini akan di-inject di semua halaman. Gunakan <code class="bg-gray-100 px-1 rounded">var(--theme-*)</code> untuk referensi variabel.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="xl:col-span-1 space-y-5">
            
            <div class="bg-white rounded-xl shadow-sm border p-5 sticky top-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Preview Admin
                </h3>
                
                <div class="border rounded-lg overflow-hidden" style="font-family: '<?php echo e($form['font_family'] ?? 'Inter'); ?>', sans-serif;">
                    <div class="h-7 flex items-center px-2" style="background-color: <?php echo e($form['header_bg'] ?? '#ffffff'); ?>; border-bottom: 1px solid <?php echo e($form['card_border'] ?? '#e5e7eb'); ?>;">
                        <div class="w-4 h-4 rounded" style="background-color: <?php echo e($form['primary_color'] ?? '#2563eb'); ?>;"></div>
                        <span class="ml-1.5 text-[9px] font-bold" style="color: <?php echo e($form['sidebar_text'] ?? '#374151'); ?>;">Admin</span>
                        <div class="ml-auto flex gap-1">
                            <div class="w-4 h-4 rounded-full bg-gray-200"></div>
                        </div>
                    </div>
                    <div class="flex" style="height: 140px;">
                        <div class="w-16 p-1.5 space-y-1 border-r" style="background-color: <?php echo e($form['sidebar_bg'] ?? '#ffffff'); ?>; border-color: <?php echo e($form['card_border'] ?? '#e5e7eb'); ?>;">
                            <div class="h-2 rounded" style="background-color: <?php echo e($form['primary_color'] ?? '#2563eb'); ?>; opacity: 0.2; width: 80%;"></div>
                            <div class="h-2 rounded" style="background-color: <?php echo e($form['primary_color'] ?? '#2563eb'); ?>; width: 100%;"></div>
                            <div class="h-2 rounded" style="background-color: <?php echo e($form['sidebar_text'] ?? '#374151'); ?>; opacity: 0.3; width: 70%;"></div>
                            <div class="h-2 rounded" style="background-color: <?php echo e($form['sidebar_text'] ?? '#374151'); ?>; opacity: 0.3; width: 55%;"></div>
                        </div>
                        <div class="flex-1 p-2" style="background-color: <?php echo e($form['body_bg'] ?? '#f3f4f6'); ?>;">
                            <div class="bg-white rounded p-1.5 mb-1.5" style="border-radius: <?php echo e($form['border_radius'] ?? '8'); ?>px; border: 1px solid <?php echo e($form['card_border'] ?? '#e5e7eb'); ?>;">
                                <div class="h-1.5 rounded bg-gray-200 w-2/3 mb-1"></div>
                                <div class="h-1.5 rounded bg-gray-100 w-1/2"></div>
                            </div>
                            <div class="flex gap-1">
                                <div class="flex-1 p-1.5 bg-white rounded" style="border-radius: <?php echo e($form['border_radius'] ?? '8'); ?>px; border: 1px solid <?php echo e($form['card_border'] ?? '#e5e7eb'); ?>;">
                                    <div class="h-3 rounded mb-0.5" style="background-color: <?php echo e($form['primary_color'] ?? '#2563eb'); ?>; opacity: 0.12;"></div>
                                    <div class="h-1 rounded bg-gray-100 w-2/3"></div>
                                </div>
                                <div class="flex-1 p-1.5 bg-white rounded" style="border-radius: <?php echo e($form['border_radius'] ?? '8'); ?>px; border: 1px solid <?php echo e($form['card_border'] ?? '#e5e7eb'); ?>;">
                                    <div class="h-3 rounded mb-0.5" style="background-color: <?php echo e($form['secondary_color'] ?? '#4f46e5'); ?>; opacity: 0.12;"></div>
                                    <div class="h-1 rounded bg-gray-100 w-2/3"></div>
                                </div>
                            </div>
                            <div class="mt-1.5 flex gap-1">
                                <span class="px-2 py-0.5 text-white text-[7px] font-bold" style="background-color: <?php echo e($form['primary_color'] ?? '#2563eb'); ?>; border-radius: <?php echo e($form['border_radius'] ?? '8'); ?>px;">Save</span>
                                <span class="px-2 py-0.5 text-white text-[7px] font-bold" style="background-color: <?php echo e($form['accent_color'] ?? '#0891b2'); ?>; border-radius: <?php echo e($form['border_radius'] ?? '8'); ?>px;">Accent</span>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-[10px] text-gray-400 mt-3 text-center">Warna aktual mungkin sedikit berbeda</p>

                
                <div class="mt-4 pt-4 border-t">
                    <p class="text-[10px] text-gray-400 mb-2 uppercase tracking-wider font-bold">Palet Warna</p>
                    <div class="flex flex-wrap gap-1">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['primary_color','secondary_color','accent_color','hero_bg','button_bg','link_color','footer_bg']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="w-6 h-6 rounded-md border border-white shadow-sm" style="background: <?php echo e($form[$c] ?? '#ccc'); ?>" title="<?php echo e($c); ?>"></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-xl shadow-sm border p-5 space-y-3">
                <button wire:click="save" type="button" class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span wire:loading.remove wire:target="save"><?php echo e($editingPresetId ? 'Simpan Perubahan' : 'Simpan Tema Baru'); ?></span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>

                <button wire:click="openSaveAs" type="button" class="w-full px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Simpan Sebagai Baru
                </button>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingPresetId): ?>
                <?php $editingPreset = $presets->firstWhere('id', $editingPresetId); ?>
                <button wire:click="activatePreset(<?php echo e($editingPresetId); ?>)" type="button"
                        class="w-full px-4 py-2.5 bg-green-50 text-green-700 border border-green-200 rounded-lg text-sm font-medium hover:bg-green-100 transition flex items-center justify-center gap-2
                        <?php echo e($editingPreset && $editingPreset->is_active ? 'opacity-50 cursor-not-allowed' : ''); ?>"
                        <?php echo e($editingPreset && $editingPreset->is_active ? 'disabled' : ''); ?>>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <?php echo e($editingPreset && $editingPreset->is_active ? 'Sudah Aktif' : 'Aktifkan Tema Ini'); ?>

                </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <button wire:click="resetToDefaults" wire:confirm="Reset semua warna dan pengaturan ke default?" type="button"
                        class="w-full px-4 py-2.5 text-gray-500 rounded-lg text-xs font-medium hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Reset ke Default
                </button>
            </div>

            
            <div class="bg-gray-50 rounded-xl border p-4">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-2">CSS Variables</p>
                <p class="text-[11px] text-gray-500 leading-relaxed">Template Anda bisa menggunakan variabel CSS seperti:</p>
                <code class="block text-[10px] text-blue-600 bg-white rounded p-2 mt-2 border font-mono">
                    var(--theme-primary-color)<br>
                    var(--theme-button-bg)<br>
                    var(--theme-font-family)<br>
                    var(--theme-border-radius)
                </code>
            </div>
        </div>
    </div>

    
    <div x-show="showSaveAs" x-cloak x-transition class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div @click.outside="showSaveAs = false" class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 mx-4">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Simpan Sebagai Tema Baru</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tema <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.live="saveAsName" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Nama tema baru">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['saveAsName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Template (Folder) <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="saveAsLinkedTemplate" class="w-full border-gray-300 rounded-lg text-sm font-mono focus:ring-blue-500 focus:border-blue-500" placeholder="nama-template-baru">
                    <p class="text-xs text-gray-400 mt-1">Huruf kecil, angka, dan tanda hubung saja. Harus berbeda dari template saat ini <span class="font-mono font-semibold text-gray-500">(<?php echo e($linkedTemplate); ?>)</span></p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['saveAsLinkedTemplate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" wire:model="saveAsDescription" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi singkat">
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button @click="showSaveAs = false" type="button" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">Batal</button>
                <button wire:click="saveAs" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    <span wire:loading.remove wire:target="saveAs">Simpan</span>
                    <span wire:loading wire:target="saveAs">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>

    
    <div x-show="showCreateTemplate" x-cloak x-transition class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div @click.outside="showCreateTemplate = false" class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 mx-4">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Buat Template Baru</h3>
                    <p class="text-xs text-gray-400">Buat template baru berdasarkan template yang sudah ada</p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Template <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.live="newTemplateName" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Modern Hijau">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newTemplateName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug / Nama Folder <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-1">
                        <span class="text-xs text-gray-400 font-mono whitespace-nowrap">templates/</span>
                        <input type="text" wire:model="newTemplateSlug" class="w-full border-gray-300 rounded-lg text-sm font-mono focus:ring-blue-500 focus:border-blue-500" placeholder="modern-hijau">
                        <span class="text-xs text-gray-400 font-mono">/</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Huruf kecil, angka, dan tanda hubung saja. Otomatis terisi dari nama.</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newTemplateSlug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Template Dasar <span class="text-red-500">*</span></label>
                    <select wire:model="newTemplateBase" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tpl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <option value="<?php echo e($tpl); ?>"><?php echo e(ucfirst($tpl)); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">File template dari template dasar akan disalin ke folder baru.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" wire:model="newTemplateDescription" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi singkat template">
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button @click="showCreateTemplate = false" type="button" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">Batal</button>
                <button wire:click="createTemplate" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span wire:loading.remove wire:target="createTemplate">Buat Template</span>
                    <span wire:loading wire:target="createTemplate">Membuat...</span>
                </button>
            </div>
        </div>
    </div>

    
    <div x-show="showImportTemplate" x-cloak x-transition class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div @click.outside="showImportTemplate = false" class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 mx-4">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Impor Template</h3>
                    <p class="text-xs text-gray-400">Unggah file .zip untuk menginstal template baru</p>
                </div>
            </div>

            <div class="space-y-4">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">File Template (.zip) <span class="text-red-500">*</span></label>
                    <div x-data="{ dragover: false }"
                         @dragover.prevent="dragover = true"
                         @dragleave.prevent="dragover = false"
                         @drop.prevent="dragover = false; $refs.zipInput.files = $event.dataTransfer.files; $refs.zipInput.dispatchEvent(new Event('change'))"
                         :class="dragover ? 'border-amber-400 bg-amber-50' : 'border-gray-300 bg-gray-50'"
                         class="border-2 border-dashed rounded-lg p-6 text-center transition cursor-pointer hover:border-amber-300"
                         @click="$refs.zipInput.click()">
                        <input type="file" wire:model="importTemplateZip" accept=".zip" class="hidden" x-ref="zipInput">
                        <div wire:loading.remove wire:target="importTemplateZip">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($importTemplateZip): ?>
                            <div class="flex items-center justify-center gap-2 text-amber-700">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div class="text-left">
                                    <p class="text-sm font-semibold"><?php echo e($importTemplateZip->getClientOriginalName()); ?></p>
                                    <p class="text-xs text-gray-400"><?php echo e(number_format($importTemplateZip->getSize() / 1024, 1)); ?> KB — Klik untuk ganti</p>
                                </div>
                            </div>
                            <?php else: ?>
                            <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <p class="text-sm text-gray-500 font-medium">Klik atau seret file .zip di sini</p>
                            <p class="text-xs text-gray-400 mt-1">Maksimal 50MB</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div wire:loading wire:target="importTemplateZip" class="flex items-center justify-center gap-2 text-amber-600">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            <span class="text-sm">Mengunggah...</span>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['importTemplateZip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Folder <span class="text-gray-400 text-xs font-normal">(opsional)</span></label>
                    <div class="flex items-center gap-1">
                        <span class="text-xs text-gray-400 font-mono whitespace-nowrap">templates/</span>
                        <input type="text" wire:model="importTemplateSlug" class="w-full border-gray-300 rounded-lg text-sm font-mono focus:ring-amber-500 focus:border-amber-500" placeholder="otomatis-dari-zip">
                        <span class="text-xs text-gray-400 font-mono">/</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Kosongkan untuk menggunakan nama folder dari dalam ZIP secara otomatis.</p>
                </div>

                
                <label class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg border cursor-pointer hover:bg-gray-100 transition">
                    <input type="checkbox" wire:model="importOverwrite" class="mt-0.5 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Timpa jika sudah ada</span>
                        <p class="text-xs text-gray-400 mt-0.5">Jika template dengan nama folder yang sama sudah ada, file lama akan diganti dengan yang baru.</p>
                    </div>
                </label>

                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-xs text-blue-700 font-semibold mb-1">Format ZIP yang didukung:</p>
                    <ul class="text-xs text-blue-600 space-y-0.5 ml-3 list-disc">
                        <li>File .blade.php langsung di root ZIP</li>
                        <li>Atau di dalam satu subfolder (seperti ekspor template)</li>
                        <li>Opsional: file <code class="bg-blue-100 px-1 rounded">theme.json</code> untuk konfigurasi warna & preset</li>
                    </ul>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button @click="showImportTemplate = false" type="button" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">Batal</button>
                <button wire:click="importTemplate" type="button" class="px-4 py-2 bg-amber-500 text-white rounded-lg text-sm font-medium hover:bg-amber-600 transition flex items-center gap-2"
                        <?php echo e($importTemplateZip ? '' : 'disabled'); ?>>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span wire:loading.remove wire:target="importTemplate">Instal Template</span>
                    <span wire:loading wire:target="importTemplate">Menginstal...</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\livewire\admin\theme-settings.blade.php ENDPATH**/ ?>