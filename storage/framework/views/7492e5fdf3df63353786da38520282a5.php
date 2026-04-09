<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
    <div class="mb-6">
        <a href="<?php echo e(route('admin.conferences')); ?>" class="text-sm text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Kegiatan
        </a>
        <h2 class="text-2xl font-bold text-gray-800 mt-2"><?php echo e($isEdit ? 'Edit Kegiatan' : 'Tambah Kegiatan Baru'); ?></h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isEdit): ?>
        <p class="text-sm text-gray-500 mt-1">Mengedit: <?php echo e($name); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 mb-4 text-sm">
            <p class="font-medium">Mohon perbaiki kesalahan berikut:</p>
            <ul class="list-disc list-inside mt-1">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="flex gap-1 mb-6 overflow-x-auto border-b">
        <?php
            $tabConfig = [
                'general' => ['label' => 'Umum', 'count' => null, 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                'dates' => ['label' => 'Tanggal Penting', 'count' => count($importantDates), 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                'committees' => ['label' => 'Panitia', 'count' => count($committees), 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                'topics' => ['label' => 'Topik', 'count' => count($topics), 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                'speakers' => ['label' => 'Speaker', 'count' => count($speakers), 'icon' => 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z'],
                'pricing' => ['label' => 'Biaya', 'count' => count($packages), 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                'reviewers' => ['label' => 'Reviewer', 'count' => count($reviewers), 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                'guidelines' => ['label' => 'Panduan', 'count' => null, 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                'templates' => ['label' => 'Template Luaran', 'count' => count($deliverableTemplates), 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'],
                'journals' => ['label' => 'Jurnal Publikasi', 'count' => count($journals), 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                'email_templates' => ['label' => 'Template Email', 'count' => count($emailTemplates), 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                'whatsapp' => ['label' => 'Grup WhatsApp', 'count' => null, 'icon' => 'M12 18h.01M8 21l4-4 4 4M3 9.5A8.5 8.5 0 1112 3a8.5 8.5 0 01-9 6.5'],
            ];
        ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tabConfig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab => $cfg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <button type="button" wire:click="$set('activeTab', '<?php echo e($tab); ?>')"
            class="group flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium whitespace-nowrap border-b-2 transition
            <?php echo e($activeTab === $tab ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700'); ?>">
            <svg class="w-4 h-4 <?php echo e($activeTab === $tab ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($cfg['icon']); ?>"/></svg>
            <?php echo e($cfg['label']); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cfg['count'] !== null && $cfg['count'] > 0): ?>
            <span class="ml-1 px-1.5 py-0.5 rounded-full text-xs <?php echo e($activeTab === $tab ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600'); ?>"><?php echo e($cfg['count']); ?></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </button>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <form wire:submit="save">

    
    <div class="bg-white rounded-xl shadow-sm border p-6 space-y-4" <?php if($activeTab !== 'general'): ?> style="display:none" <?php endif; ?>>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan *</label>
                <input wire:model="name" type="text" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Akronim</label>
                <input wire:model="acronym" type="text" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="cth: LPKD 2026">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                <input wire:model="organizer" type="text" class="w-full px-3 py-2 border rounded-lg text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tema</label>
                <input wire:model="theme" type="text" class="w-full px-3 py-2 border rounded-lg text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea wire:model="description" rows="4" class="w-full px-3 py-2 border rounded-lg text-sm"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Link "Baca Selengkapnya" <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input wire:model="read_more_url" type="url" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="https://example.com/tentang-konferensi">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['read_more_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <p class="text-xs text-gray-400 mt-1">Jika diisi, tombol "Baca Selengkapnya" di halaman publik akan mengarah ke URL ini.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input wire:model="start_date" type="date" class="w-full px-3 py-2 border rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                <input wire:model="start_time" type="time" class="w-full px-3 py-2 border rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input wire:model="end_date" type="date" class="w-full px-3 py-2 border rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                <input wire:model="end_time" type="time" class="w-full px-3 py-2 border rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Tempat</label>
                <select wire:model.live="venue_type" class="w-full px-3 py-2 border rounded-lg text-sm">
                    <option value="offline">Offline (Luring)</option>
                    <option value="online">Online (Daring)</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kegiatan</label>
                <div class="flex gap-3">
                    <label class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-lg border text-sm font-medium transition <?php echo e($conferenceType === 'nasional' ? 'bg-sky-50 border-sky-400 text-sky-700' : 'bg-white border-gray-300 text-gray-600 hover:bg-gray-50'); ?>">
                        <input type="radio" wire:model.live="conferenceType" value="nasional" class="accent-sky-600"> Nasional
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-lg border text-sm font-medium transition <?php echo e($conferenceType === 'internasional' ? 'bg-violet-50 border-violet-400 text-violet-700' : 'bg-white border-gray-300 text-gray-600 hover:bg-gray-50'); ?>">
                        <input type="radio" wire:model.live="conferenceType" value="internasional" class="accent-violet-600"> Internasional
                    </label>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($venue_type === 'offline' || $venue_type === 'hybrid'): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat / Venue</label>
                <input wire:model="venue" type="text" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="Nama gedung / lokasi">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                <input wire:model="city" type="text" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="Nama kota">
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($venue_type === 'online' || $venue_type === 'hybrid'): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link / URL Online</label>
                <input wire:model="online_url" type="url" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="https://zoom.us/meeting/...">
                <p class="mt-1.5 text-xs text-gray-500">Isi dengan link meeting online yang akan digunakan, misalnya:</p>
                <div class="mt-1.5 flex flex-wrap gap-1.5">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-50 border border-blue-100 text-[11px] text-blue-600 font-medium">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M15 10l4.553-2.277A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14v-4zM3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        Zoom Meeting
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-green-50 border border-green-100 text-[11px] text-green-700 font-medium">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M15 10l4.553-2.277A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14v-4zM3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        Google Meet
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-50 border border-purple-100 text-[11px] text-purple-700 font-medium">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M15 10l4.553-2.277A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14v-4zM3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        MS Teams
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-red-50 border border-red-100 text-[11px] text-red-600 font-medium">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M15 10l4.553-2.277A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14v-4zM3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        YouTube Live / Webex
                    </span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['online_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                <div class="space-y-2">
                    
                    <div wire:loading wire:target="cover_image" class="flex items-center gap-2 text-sm text-blue-600">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Mengupload...
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cover_image): ?>
                    <div class="relative w-full h-32 bg-gray-100 rounded-lg overflow-hidden border" wire:loading.remove wire:target="cover_image">
                        <?php
                            try {
                                $previewUrl = $cover_image->temporaryUrl();
                            } catch (\Exception $e) {
                                $previewUrl = null;
                            }
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($previewUrl): ?>
                        <img src="<?php echo e($previewUrl); ?>" class="w-full h-full object-cover" alt="Preview">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">Preview tidak tersedia</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <button type="button" wire:click="$set('cover_image', null)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <?php elseif($existing_cover_image): ?>
                    <div class="relative w-full h-32 bg-gray-100 rounded-lg overflow-hidden border">
                        <img src="<?php echo e(asset('storage/' . $existing_cover_image)); ?>" class="w-full h-full object-cover" alt="Cover">
                        <button type="button" wire:click="removeCoverImage" wire:confirm="Hapus cover image?" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <input wire:model="cover_image" type="file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700">
                    <p class="text-xs text-gray-400">Maks 2MB. Format: JPG, PNG</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                <div class="space-y-2">
                    
                    <div wire:loading wire:target="logo" class="flex items-center gap-2 text-sm text-blue-600">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Mengupload...
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logo): ?>
                    <div class="relative w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border" wire:loading.remove wire:target="logo">
                        <?php
                            try {
                                $logoPreviewUrl = $logo->temporaryUrl();
                            } catch (\Exception $e) {
                                $logoPreviewUrl = null;
                            }
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logoPreviewUrl): ?>
                        <img src="<?php echo e($logoPreviewUrl); ?>" class="w-full h-full object-contain" alt="Preview">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs text-center">Preview N/A</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <button type="button" wire:click="$set('logo', null)" class="absolute top-0.5 right-0.5 bg-red-500 text-white rounded-full p-0.5 hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <?php elseif($existing_logo): ?>
                    <div class="relative w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border">
                        <img src="<?php echo e(asset('storage/' . $existing_logo)); ?>" class="w-full h-full object-contain" alt="Logo">
                        <button type="button" wire:click="removeLogo" wire:confirm="Hapus logo?" class="absolute top-0.5 right-0.5 bg-red-500 text-white rounded-full p-0.5 hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <input wire:model="logo" type="file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700">
                    <p class="text-xs text-gray-400">Maks 1MB. Format: JPG, PNG</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Brosur / Pamflet</label>
                <div class="space-y-2">
                    
                    <div wire:loading wire:target="brochure" class="flex items-center gap-2 text-sm text-blue-600">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Mengupload...
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brochure): ?>
                    <div class="relative w-full h-48 bg-gray-100 rounded-lg overflow-hidden border" wire:loading.remove wire:target="brochure">
                        <?php
                            try {
                                $brochurePreviewUrl = $brochure->temporaryUrl();
                            } catch (\Exception $e) {
                                $brochurePreviewUrl = null;
                            }
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brochurePreviewUrl): ?>
                        <img src="<?php echo e($brochurePreviewUrl); ?>" class="w-full h-full object-contain" alt="Preview">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">Preview tidak tersedia</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <button type="button" wire:click="$set('brochure', null)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <?php elseif($existing_brochure): ?>
                    <div class="relative w-full h-48 bg-gray-100 rounded-lg overflow-hidden border">
                        <img src="<?php echo e(asset('storage/' . $existing_brochure)); ?>" class="w-full h-full object-contain" alt="Brosur">
                        <button type="button" wire:click="removeBrochure" wire:confirm="Hapus brosur/pamflet?" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <input wire:model="brochure" type="file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700">
                    <p class="text-xs text-gray-400">Maks 5MB. Format: JPG, PNG. Gambar brosur/pamflet yang tampil di halaman utama.</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['brochure'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model="status" class="w-full px-3 py-2 border rounded-lg text-sm">
                    <option value="draft">Draft</option>
                    <option value="published">Dipublikasikan</option>
                    <option value="archived">Diarsipkan</option>
                </select>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'dates'): ?>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-800">Tanggal Penting</h3>
            <button type="button" wire:click="addDate" class="text-sm px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100">+ Tambah</button>
        </div>
        <div class="space-y-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $importantDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="flex gap-3 items-start p-3 bg-gray-50 rounded-lg">
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <input wire:model="importantDates.<?php echo e($i); ?>.title" type="text" placeholder="Judul" class="px-3 py-2 border rounded-lg text-sm">
                    <input wire:model="importantDates.<?php echo e($i); ?>.date" type="date" class="px-3 py-2 border rounded-lg text-sm">
                    <select wire:model="importantDates.<?php echo e($i); ?>.type" class="px-3 py-2 border rounded-lg text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\ImportantDate::TYPE_LABELS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?><option value="<?php echo e($val); ?>"><?php echo e($lbl); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <input wire:model="importantDates.<?php echo e($i); ?>.description" type="text" placeholder="Keterangan" class="px-3 py-2 border rounded-lg text-sm">
                </div>
                <button type="button" wire:click="removeDate(<?php echo e($i); ?>)" class="text-red-500 hover:text-red-700 mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p class="text-gray-400 text-sm text-center py-4">Belum ada tanggal penting. Klik "+ Tambah" untuk menambahkan.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'committees'): ?>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-800">Panitia / Committee</h3>
            <button type="button" wire:click="addCommittee" class="text-sm px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100">+ Tambah</button>
        </div>
        <div class="space-y-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $committees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $comm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="flex gap-3 items-start p-3 bg-gray-50 rounded-lg">
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-5 gap-3">
                    <input wire:model="committees.<?php echo e($i); ?>.name" type="text" placeholder="Nama" class="px-3 py-2 border rounded-lg text-sm">
                    <input wire:model="committees.<?php echo e($i); ?>.title" type="text" placeholder="Gelar (Dr., Prof.)" class="px-3 py-2 border rounded-lg text-sm">
                    <input wire:model="committees.<?php echo e($i); ?>.institution" type="text" placeholder="Institusi" class="px-3 py-2 border rounded-lg text-sm">
                    <select wire:model="committees.<?php echo e($i); ?>.type" class="px-3 py-2 border rounded-lg text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\Committee::TYPE_LABELS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?><option value="<?php echo e($val); ?>"><?php echo e($lbl); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <input wire:model="committees.<?php echo e($i); ?>.role" type="text" placeholder="Jabatan (Ketua, Anggota)" class="px-3 py-2 border rounded-lg text-sm">
                </div>
                <button type="button" wire:click="removeCommittee(<?php echo e($i); ?>)" class="text-red-500 hover:text-red-700 mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p class="text-gray-400 text-sm text-center py-4">Belum ada panitia. Klik "+ Tambah" untuk menambahkan.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'topics'): ?>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-800">Topik / Bidang Kajian</h3>
            <button type="button" wire:click="addTopic" class="text-sm px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100">+ Tambah</button>
        </div>
        <div class="space-y-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="flex gap-3 items-start p-3 bg-gray-50 rounded-lg">
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <input wire:model="topics.<?php echo e($i); ?>.code" type="text" placeholder="Kode (cth: T01)" class="px-3 py-2 border rounded-lg text-sm">
                    <input wire:model="topics.<?php echo e($i); ?>.name" type="text" placeholder="Nama Topik" class="px-3 py-2 border rounded-lg text-sm sm:col-span-2">
                    <input wire:model="topics.<?php echo e($i); ?>.description" type="text" placeholder="Deskripsi (opsional)" class="px-3 py-2 border rounded-lg text-sm sm:col-span-3">
                </div>
                <button type="button" wire:click="removeTopic(<?php echo e($i); ?>)" class="text-red-500 hover:text-red-700 mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p class="text-gray-400 text-sm text-center py-4">Belum ada topik. Klik "+ Tambah" untuk menambahkan.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white rounded-xl shadow-sm border p-6" <?php if($activeTab !== 'speakers'): ?> style="display:none" <?php endif; ?>>
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-800">Pembicara & Moderator</h3>
            <div class="flex gap-2 flex-wrap">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\KeynoteSpeaker::TYPE_LABELS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeKey => $typeLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <button type="button" wire:click="addSpeaker('<?php echo e($typeKey); ?>')"
                    class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 whitespace-nowrap">
                    + <?php echo e($typeLabel); ?>

                </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <?php
            $speakerTypes = \App\Models\KeynoteSpeaker::TYPE_LABELS;
            $typeColors = \App\Models\KeynoteSpeaker::TYPE_COLORS;
            $typeIcons = \App\Models\KeynoteSpeaker::TYPE_ICONS;
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $speakerTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeKey => $typeLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $filtered = collect($speakers)->filter(fn($s) => ($s['type'] ?? 'keynote_speaker') === $typeKey);
                $color = $typeColors[$typeKey] ?? 'gray';
                $icon = $typeIcons[$typeKey] ?? '';
            ?>

            <div class="mb-6">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b">
                    <svg class="w-5 h-5 text-<?php echo e($color); ?>-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($icon); ?>"/></svg>
                    <h4 class="font-semibold text-gray-700 text-sm"><?php echo e($typeLabel); ?></h4>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filtered->count() > 0): ?>
                    <span class="px-1.5 py-0.5 rounded-full text-xs bg-<?php echo e($color); ?>-100 text-<?php echo e($color); ?>-700"><?php echo e($filtered->count()); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="ml-auto">
                        <?php $typeHidden = in_array($typeKey, $hiddenSpeakerTypes); ?>
                        <button type="button" wire:click="toggleSpeakerType('<?php echo e($typeKey); ?>')"
                            title="<?php echo e($typeHidden ? 'Tampilkan di website' : 'Sembunyikan dari website'); ?>"
                            class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium transition <?php echo e($typeHidden ? 'bg-gray-100 text-gray-500 hover:bg-gray-200' : 'bg-green-50 text-green-700 hover:bg-green-100'); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($typeHidden): ?>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                Disembunyikan
                            <?php else: ?>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Tampil di Web
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>
                    </div>
                </div>

                <div class="space-y-3">
                    <?php $hasItems = false; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $speakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($speaker['type'] ?? 'keynote_speaker') !== $typeKey): ?> <?php continue; ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php $hasItems = true; ?>
                        <div class="flex gap-3 items-start p-3 bg-gray-50 rounded-lg border-l-4 border-<?php echo e($color); ?>-400">
                            
                            <div class="shrink-0 w-24">
                                <div class="w-20 h-20 rounded-lg border-2 border-dashed border-gray-300 overflow-hidden bg-white flex items-center justify-center relative group">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($speakerPhotos[$i]) && $speakerPhotos[$i]): ?>
                                        <img src="<?php echo e($speakerPhotos[$i]->temporaryUrl()); ?>" alt="Preview" class="w-full h-full object-cover">
                                        <button type="button" wire:click="removeSpeakerPhoto(<?php echo e($i); ?>)"
                                            class="absolute top-0 right-0 bg-red-500 text-white rounded-bl-lg p-0.5 opacity-0 group-hover:opacity-100 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    <?php elseif(!empty($speaker['existing_photo'])): ?>
                                        <img src="<?php echo e(asset('storage/' . $speaker['existing_photo'])); ?>" alt="Photo" class="w-full h-full object-cover">
                                        <button type="button" wire:click="removeSpeakerPhoto(<?php echo e($i); ?>)"
                                            class="absolute top-0 right-0 bg-red-500 text-white rounded-bl-lg p-0.5 opacity-0 group-hover:opacity-100 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    <?php else: ?>
                                        <label class="cursor-pointer flex flex-col items-center justify-center w-full h-full hover:bg-gray-50 transition">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span class="text-[10px] text-gray-400 mt-0.5">Foto</span>
                                            <input type="file" wire:model="speakerPhotos.<?php echo e($i); ?>" accept="image/*" class="hidden">
                                        </label>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div wire:loading wire:target="speakerPhotos.<?php echo e($i); ?>" class="text-[10px] text-blue-600 text-center mt-1">Uploading...</div>
                            </div>

                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-0.5">Nama *</label>
                                    <input wire:model="speakers.<?php echo e($i); ?>.name" type="text" placeholder="Nama lengkap" class="w-full px-3 py-2 border rounded-lg text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-0.5">Gelar</label>
                                    <input wire:model="speakers.<?php echo e($i); ?>.title" type="text" placeholder="Prof. Dr. / M.Pd." class="w-full px-3 py-2 border rounded-lg text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-0.5">Institusi</label>
                                    <input wire:model="speakers.<?php echo e($i); ?>.institution" type="text" placeholder="Universitas / Lembaga" class="w-full px-3 py-2 border rounded-lg text-sm">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-xs font-medium text-gray-500 mb-0.5">Topik / Materi</label>
                                    <input wire:model="speakers.<?php echo e($i); ?>.topic" type="text" placeholder="Judul atau topik yang disampaikan" class="w-full px-3 py-2 border rounded-lg text-sm">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-xs font-medium text-gray-500 mb-0.5">Bio Singkat</label>
                                    <textarea wire:model="speakers.<?php echo e($i); ?>.bio" placeholder="Bio singkat pembicara..." rows="2" class="w-full px-3 py-2 border rounded-lg text-sm"></textarea>
                                </div>
                            </div>
                            <button type="button" wire:click="removeSpeaker(<?php echo e($i); ?>)" class="text-red-500 hover:text-red-700 mt-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$hasItems): ?>
                    <p class="text-gray-400 text-sm text-center py-3">
                        Belum ada <?php echo e(strtolower($typeLabel)); ?>.
                        <button type="button" wire:click="addSpeaker('<?php echo e($typeKey); ?>')" class="text-blue-600 hover:underline">+ Tambah</button>
                    </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'pricing'): ?>
    <div class="space-y-6">
        
        <div class="bg-white rounded-xl shadow-sm border p-6 space-y-4">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <h3 class="font-semibold text-gray-800">Informasi Pembayaran (Legacy)</h3>
            </div>
            <p class="text-xs text-gray-400 -mt-2">Data rekening bank dan kontak pembayaran (gunakan Metode Pembayaran di bawah untuk opsi yang lebih lengkap)</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Nama Bank
                        </span>
                    </label>
                    <input wire:model="payment_bank_name" type="text" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Bank Mandiri">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            No. Rekening
                        </span>
                    </label>
                    <input wire:model="payment_bank_account" type="text" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="1234567890">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Atas Nama</label>
                    <input wire:model="payment_account_holder" type="text" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Nama pemegang rekening">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            No. HP Kontak Pembayaran
                        </span>
                    </label>
                    <input wire:model="payment_contact_phone" type="text" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="+62 812 xxxx xxxx">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Instruksi Pembayaran</label>
                    <textarea wire:model="payment_instructions" rows="3" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Lakukan transfer ke rekening di atas dan konfirmasi melalui WhatsApp..."></textarea>
                    <p class="text-xs text-gray-400 mt-1">Instruksi tambahan untuk peserta. Bisa beberapa baris.</p>
                </div>
            </div>
        </div>

        
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-sm border-2 border-blue-200 p-6 space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Metode Pembayaran
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">Tambahkan berbagai metode pembayaran dengan nominal masing-masing</p>
                </div>
                <button type="button" wire:click="addPaymentMethod" class="text-sm px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Metode
                </button>
            </div>

            <div class="space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="bg-white rounded-lg border-2 border-gray-200 p-4 space-y-3 shadow-sm">
                    <div class="flex justify-between items-start">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wide">Metode #<?php echo e($index + 1); ?></span>
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" wire:model="paymentMethods.<?php echo e($index); ?>.is_active" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="text-xs text-gray-600 font-medium">Aktif</span>
                            </label>
                            <button type="button" wire:click="removePaymentMethod(<?php echo e($index); ?>)" wire:confirm="Hapus metode pembayaran ini?" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Metode *</label>
                            <select wire:model="paymentMethods.<?php echo e($index); ?>.type" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="E-Wallet">E-Wallet (OVO, GoPay, Dana)</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Virtual Account">Virtual Account</option>
                                <option value="Tunai">Tunai / Cash</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Bank/E-Wallet *</label>
                            <input wire:model="paymentMethods.<?php echo e($index); ?>.name" type="text" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="cth: Bank Mandiri, OVO, Dana">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nominal (Rp) *</label>
                            <input wire:model="paymentMethods.<?php echo e($index); ?>.amount" type="number" min="0" step="1000" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="500000">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">No. Rekening / No. HP</label>
                            <input wire:model="paymentMethods.<?php echo e($index); ?>.account_number" type="text" class="w-full px-3 py-2 border rounded-lg text-sm font-mono" placeholder="1234567890">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Atas Nama</label>
                            <input wire:model="paymentMethods.<?php echo e($index); ?>.account_holder" type="text" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="Nama pemegang akun">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Instruksi Khusus <span class="text-gray-400">(opsional)</span></label>
                        <textarea wire:model="paymentMethods.<?php echo e($index); ?>.instructions" rows="2" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="Instruksi tambahan untuk metode pembayaran ini..."></textarea>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="text-center py-8 bg-white/50 rounded-lg border-2 border-dashed border-gray-300">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="text-gray-500 text-sm">Belum ada metode pembayaran</p>
                    <p class="text-gray-400 text-xs mt-1">Klik "Tambah Metode" untuk menambahkan opsi pembayaran</p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm border p-6 space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Paket Biaya Pendaftaran</h3>
                <button type="button" wire:click="addPackage" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Paket
                </button>
            </div>
            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="border rounded-xl p-4 space-y-3 <?php echo e(($pkg['is_featured'] ?? false) ? 'border-blue-400 bg-blue-50/50 ring-1 ring-blue-200' : 'border-gray-200'); ?>">
                    <div class="flex justify-between items-start">
                        <span class="text-xs font-semibold text-gray-400 uppercase">Paket #<?php echo e($index + 1); ?></span>
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" wire:model.live="packages.<?php echo e($index); ?>.is_free" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <span class="text-xs font-medium text-emerald-700">Gratis</span>
                            </label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!($pkg['is_free'] ?? false)): ?>
                            <label class="flex items-center gap-1.5 cursor-pointer" title="Tampilkan field upload bukti bayar di form pendaftaran">
                                <input type="checkbox" wire:model="packages.<?php echo e($index); ?>.require_payment_proof" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                <span class="text-xs font-medium text-orange-600">Upload Bukti Bayar</span>
                            </label>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" wire:model="packages.<?php echo e($index); ?>.is_featured" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-xs text-gray-500">Featured</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" wire:model="packages.<?php echo e($index); ?>.is_active" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="text-xs text-gray-500">Aktif</span>
                            </label>
                            <button type="button" wire:click="removePackage(<?php echo e($index); ?>)" wire:confirm="Hapus paket ini?" class="text-red-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Paket *</label>
                            <input wire:model="packages.<?php echo e($index); ?>.name" type="text" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="cth: Peserta Seminar 2025">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Mata Uang</label>
                            <select wire:model="packages.<?php echo e($index); ?>.currency" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="IDR">IDR (Rp)</option>
                                <option value="USD">USD ($)</option>
                            </select>
                        </div>
                        <div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!($pkg['is_free'] ?? false)): ?>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Harga</label>
                            <input id="pkg-price-<?php echo e($index); ?>"
                                wire:model="packages.<?php echo e($index); ?>.price" 
                                type="number" 
                                min="0" 
                                step="any"
                                class="w-full px-3 py-2 border rounded-lg text-sm" 
                                placeholder="<?php echo e(($pkg['currency'] ?? 'IDR') === 'USD' ? '99.99' : '50000'); ?>">
                            <?php else: ?>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Harga</label>
                            <div class="flex items-center gap-2 w-full px-3 py-2 border border-emerald-300 bg-emerald-50 rounded-lg text-sm font-bold text-emerald-700">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                GRATIS
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Singkat</label>
                            <input wire:model="packages.<?php echo e($index); ?>.description" type="text" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="cth: Pemakalah Mahasiswa Luar (S1/S2/S3)">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Fasilitas <span class="text-gray-400">(satu per baris)</span></label>
                        <textarea wire:model="packages.<?php echo e($index); ?>.features" rows="4" class="w-full px-3 py-2 border rounded-lg text-sm font-mono" placeholder="Akses Full Day Seminar&#10;Softcopy Presentasi Pembicara&#10;E-Sertificate&#10;E-Prosiding"></textarea>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="text-sm">Belum ada paket biaya.</p>
                    <button type="button" wire:click="addPackage" class="mt-2 text-sm text-blue-600 hover:underline">+ Tambah Paket Pertama</button>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'reviewers'): ?>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="font-semibold text-gray-800">Daftar Reviewer</h3>
                <p class="text-xs text-gray-400 mt-0.5">Kelola akun reviewer yang dapat ditugaskan untuk me-review paper. Password default: <code class="bg-gray-100 px-1 rounded">password</code></p>
            </div>
            <button type="button" wire:click="addReviewer" class="text-sm px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100">+ Tambah Reviewer</button>
        </div>
        <div class="space-y-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reviewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $rev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="flex gap-3 items-start p-3 bg-gray-50 rounded-lg">
                <div class="shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                    <?php echo e($i + 1); ?>

                </div>
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-0.5">Nama *</label>
                        <input wire:model="reviewers.<?php echo e($i); ?>.name" type="text" placeholder="Nama lengkap" class="w-full px-3 py-2 border rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-0.5">Email *</label>
                        <input wire:model="reviewers.<?php echo e($i); ?>.email" type="email" placeholder="email@example.com" class="w-full px-3 py-2 border rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-0.5">Institusi</label>
                        <input wire:model="reviewers.<?php echo e($i); ?>.institution" type="text" placeholder="Universitas / Lembaga" class="w-full px-3 py-2 border rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-0.5">Telepon</label>
                        <input wire:model="reviewers.<?php echo e($i); ?>.phone" type="text" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2 border rounded-lg text-sm">
                    </div>
                </div>
                <button type="button" wire:click="removeReviewer(<?php echo e($i); ?>)" wire:confirm="Hapus reviewer ini? Akun user akan dihapus permanen." class="text-red-500 hover:text-red-700 mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="text-center py-10 text-gray-400">
                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <p class="text-sm">Belum ada reviewer.</p>
                <button type="button" wire:click="addReviewer" class="mt-2 text-sm text-blue-600 hover:underline">+ Tambah Reviewer Pertama</button>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white rounded-xl shadow-sm border p-6 space-y-4" <?php if($activeTab !== 'guidelines'): ?> style="display:none" <?php endif; ?>>
        <h3 class="font-semibold text-gray-800">Panduan Submission</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Panduan / Instruksi untuk Author</label>
                <textarea wire:model="guideline_content" rows="8" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="Tuliskan panduan submission untuk penulis..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Min. Halaman</label>
                <input wire:model="min_pages" type="number" min="1" class="w-full px-3 py-2 border rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Max. Halaman</label>
                <input wire:model="max_pages" type="number" min="1" class="w-full px-3 py-2 border rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Format Paper</label>
                <input wire:model="paper_format" type="text" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="cth: IEEE, APA, dll">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gaya Sitasi</label>
                <input wire:model="citation_style" type="text" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="cth: APA 7th Edition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Template File</label>
                <div class="space-y-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existing_template_file): ?>
                    <div class="flex items-center gap-3 p-2 bg-blue-50 rounded-lg border border-blue-200">
                        <svg class="w-8 h-8 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700 font-medium truncate"><?php echo e(basename($existing_template_file)); ?></p>
                            <a href="<?php echo e(asset('storage/' . $existing_template_file)); ?>" target="_blank" class="text-xs text-blue-600 hover:underline">Download</a>
                        </div>
                        <button type="button" wire:click="removeTemplateFile" wire:confirm="Hapus template file?" class="text-red-500 hover:text-red-700 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <input wire:model="template_file" type="file" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700">
                    <p class="text-xs text-gray-400">Maks 5MB. Format: DOC, DOCX, PDF, ZIP</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['template_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                <textarea wire:model="additional_notes" rows="3" class="w-full px-3 py-2 border rounded-lg text-sm"></textarea>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border p-6 space-y-4" <?php if($activeTab !== 'templates'): ?> style="display:none" <?php endif; ?>>
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Template Luaran</h3>
                <p class="text-xs text-gray-500 mt-1">Upload template file yang akan digunakan penulis untuk menyiapkan luaran (poster, PPT, paper final, dll).</p>
            </div>
            <button type="button" wire:click="addTemplate" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 inline-flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Template
            </button>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($deliverableTemplates) === 0): ?>
        <div class="text-center py-10 border-2 border-dashed border-gray-200 rounded-xl">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <p class="text-sm text-gray-500">Belum ada template luaran.</p>
            <p class="text-xs text-gray-400 mt-1">Klik "Tambah Template" untuk mulai menambahkan.</p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $deliverableTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tpl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="border border-gray-200 rounded-xl p-4 relative group" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('template-{{ $i }}', get_defined_vars()); ?>wire:key="template-<?php echo e($i); ?>">
                
                <button type="button" wire:click="removeTemplate(<?php echo e($i); ?>)" wire:confirm="Hapus template ini?"
                    class="absolute top-3 right-3 text-gray-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Luaran</label>
                        <select wire:model="deliverableTemplates.<?php echo e($i); ?>.type" class="w-full px-3 py-2 border rounded-lg text-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\DeliverableTemplate::TYPE_OPTIONS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <option value="<?php echo e($val); ?>"><?php echo e($lbl); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Template <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="deliverableTemplates.<?php echo e($i); ?>.label" class="w-full px-3 py-2 border rounded-lg text-sm"
                            placeholder="cth: Template Poster A1">
                    </div>

                    
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Keterangan</label>
                        <input type="text" wire:model="deliverableTemplates.<?php echo e($i); ?>.description" class="w-full px-3 py-2 border rounded-lg text-sm"
                            placeholder="cth: Ukuran A1, landscape">
                    </div>

                    
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-gray-600 mb-1">File Template</label>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($tpl['existing_file'])): ?>
                        <div class="flex items-center gap-3 p-2 bg-green-50 rounded-lg border border-green-200 mb-2">
                            <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 font-medium truncate"><?php echo e($tpl['original_name'] ?? basename($tpl['existing_file'])); ?></p>
                                <a href="<?php echo e(asset('storage/' . $tpl['existing_file'])); ?>" target="_blank" class="text-xs text-blue-600 hover:underline">Download</a>
                            </div>
                            <span class="text-xs text-green-600 font-medium">Tersimpan</span>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <input type="file" wire:model="templateFiles.<?php echo e($i); ?>" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700">
                        <p class="text-xs text-gray-400 mt-1">Maks 10MB. Format: PDF, DOC, DOCX, PPT, PPTX, ZIP, dll.</p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["templateFiles.{$i}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        
        
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h4 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengaturan Generate Dokumen
            </h4>
            <p class="text-xs text-gray-500 mb-5">Pilih mode generate untuk LOA dan Sertifikat</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="border border-gray-200 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        📜 LOA (Letter of Acceptance) Mode
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" :class="{'bg-blue-50 border-blue-500': <?php echo \Illuminate\Support\Js::from($loaGenerationMode)->toHtml() ?> === 'auto'}">
                            <input type="radio" wire:model.live="loaGenerationMode" value="auto" class="mt-1">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">Auto-Generate</p>
                                <p class="text-xs text-gray-500 mt-0.5">Sistem membuat PDF LOA otomatis dengan nomor unik & QR code</p>
                                <span class="inline-block mt-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">✨ Recommended</span>
                            </div>
                        </label>
                        <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" :class="{'bg-blue-50 border-blue-500': <?php echo \Illuminate\Support\Js::from($loaGenerationMode)->toHtml() ?> === 'manual'}">
                            <input type="radio" wire:model.live="loaGenerationMode" value="manual" class="mt-1">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">Manual</p>
                                <p class="text-xs text-gray-500 mt-0.5">Admin input link LOA dari Google Drive atau tempat lain</p>
                            </div>
                        </label>
                    </div>
                </div>
                
                
                <div class="border border-gray-200 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        🎓 Sertifikat Mode
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" :class="{'bg-blue-50 border-blue-500': <?php echo \Illuminate\Support\Js::from($certificateGenerationMode)->toHtml() ?> === 'auto'}">
                            <input type="radio" wire:model.live="certificateGenerationMode" value="auto" class="mt-1">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">Auto-Generate</p>
                                <p class="text-xs text-gray-500 mt-0.5">Batch generate semua sertifikat sekaligus dengan template</p>
                                <span class="inline-block mt-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">⚡ Scalable</span>
                            </div>
                        </label>
                        <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" :class="{'bg-blue-50 border-blue-500': <?php echo \Illuminate\Support\Js::from($certificateGenerationMode)->toHtml() ?> === 'manual'}">
                            <input type="radio" wire:model.live="certificateGenerationMode" value="manual" class="mt-1">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">Manual</p>
                                <p class="text-xs text-gray-500 mt-0.5">Upload sertifikat satu per satu secara manual</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                <p class="text-sm text-blue-800 font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Catatan
                </p>
                <ul class="text-xs text-blue-700 mt-2 ml-4 space-y-1 list-disc">
                    <li>Mode Auto: Lebih cepat, konsisten, dan scalable untuk conference besar</li>
                    <li>Mode Manual: Lebih fleksibel untuk customization per paper</li>
                    <li>Anda bisa override setting ini saat accept paper (khusus LOA)</li>
                </ul>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border p-6 space-y-4" <?php if($activeTab !== 'journals'): ?> style="display:none" <?php endif; ?>>
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Jurnal Publikasi</h3>
                <p class="text-xs text-gray-500 mt-1">Daftar jurnal tempat artikel/makalah terpilih akan dipublikasikan.</p>
            </div>
            <button type="button" wire:click="addJournal" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 inline-flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Jurnal
            </button>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($journals) === 0): ?>
        <div class="text-center py-10 border-2 border-dashed border-gray-200 rounded-xl">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <p class="text-sm text-gray-500">Belum ada jurnal publikasi.</p>
            <p class="text-xs text-gray-400 mt-1">Klik "Tambah Jurnal" untuk mulai menambahkan.</p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="border border-gray-200 rounded-xl p-4 relative group" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('journal-{{ $i }}', get_defined_vars()); ?>wire:key="journal-<?php echo e($i); ?>">
                
                <button type="button" wire:click="removeJournal(<?php echo e($i); ?>)" wire:confirm="Hapus jurnal ini?"
                    class="absolute top-3 right-3 text-gray-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>

                <div class="flex items-start gap-2 mb-3">
                    <span class="text-xs font-semibold text-gray-400 uppercase">Jurnal #<?php echo e($i + 1); ?></span>
                    <label class="flex items-center gap-1.5 cursor-pointer ml-auto mr-8">
                        <input type="checkbox" wire:model="journals.<?php echo e($i); ?>.is_active" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <span class="text-xs text-gray-500">Aktif</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Jurnal <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="journals.<?php echo e($i); ?>.name" class="w-full px-3 py-2 border rounded-lg text-sm"
                            placeholder="cth: Jurnal Pendidikan Kejuruan Indonesia">
                    </div>

                    
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Peringkat SINTA</label>
                        <select wire:model="journals.<?php echo e($i); ?>.sinta_rank" class="w-full px-3 py-2 border rounded-lg text-sm">
                            <option value="">— Pilih —</option>
                            <option value="SINTA 1">SINTA 1</option>
                            <option value="SINTA 2">SINTA 2</option>
                            <option value="SINTA 3">SINTA 3</option>
                            <option value="SINTA 4">SINTA 4</option>
                            <option value="SINTA 5">SINTA 5</option>
                            <option value="SINTA 6">SINTA 6</option>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">URL Jurnal</label>
                        <input type="url" wire:model="journals.<?php echo e($i); ?>.url" class="w-full px-3 py-2 border rounded-lg text-sm"
                            placeholder="https://journal.example.com">
                    </div>

                    
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Keterangan Singkat</label>
                        <input type="text" wire:model="journals.<?php echo e($i); ?>.description" class="w-full px-3 py-2 border rounded-lg text-sm"
                            placeholder="cth: Terindeks Scopus, Google Scholar">
                    </div>

                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Logo Jurnal</label>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($journal['existing_logo'])): ?>
                        <div class="flex items-center gap-3 p-2 bg-green-50 rounded-lg border border-green-200 mb-2">
                            <img src="<?php echo e(asset('storage/' . $journal['existing_logo'])); ?>" alt="Logo" class="w-12 h-12 object-contain rounded border bg-white">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 font-medium">Logo tersimpan</p>
                            </div>
                            <button type="button" wire:click="removeJournalLogo(<?php echo e($i); ?>)" class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus</button>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <input type="file" wire:model="journalLogos.<?php echo e($i); ?>" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700">
                        <p class="text-xs text-gray-400 mt-1">Maks 2MB. Format: JPG, PNG, SVG, WebP.</p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["journalLogos.{$i}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'email_templates'): ?>
    <div class="space-y-4">
        
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-sm text-blue-700">
                <p class="font-semibold">Template Email Kustom</p>
                <p class="mt-0.5">Kustomisasi subjek dan isi email yang dikirim sistem kepada peserta. Jika tidak diisi, sistem akan menggunakan template default. Gunakan variabel yang tersedia untuk konten dinamis.</p>
            </div>
        </div>

        <?php
            $emailTypeList = \App\Models\EmailTemplate::TYPES;
            $colorMap = [
                'blue'    => ['bg' => 'bg-blue-50',    'border' => 'border-blue-300',  'badge' => 'bg-blue-100 text-blue-700',   'icon' => 'text-blue-500',   'title' => 'text-blue-800'],
                'green'   => ['bg' => 'bg-green-50',   'border' => 'border-green-300', 'badge' => 'bg-green-100 text-green-700', 'icon' => 'text-green-500',  'title' => 'text-green-800'],
                'yellow'  => ['bg' => 'bg-yellow-50',  'border' => 'border-yellow-300','badge' => 'bg-yellow-100 text-yellow-700','icon' => 'text-yellow-500', 'title' => 'text-yellow-800'],
                'indigo'  => ['bg' => 'bg-indigo-50',  'border' => 'border-indigo-300','badge' => 'bg-indigo-100 text-indigo-700','icon' => 'text-indigo-500', 'title' => 'text-indigo-800'],
                'purple'  => ['bg' => 'bg-purple-50',  'border' => 'border-purple-300','badge' => 'bg-purple-100 text-purple-700','icon' => 'text-purple-500', 'title' => 'text-purple-800'],
                'emerald' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-300','badge' => 'bg-emerald-100 text-emerald-700','icon' => 'text-emerald-500','title' => 'text-emerald-800'],
                'red'     => ['bg' => 'bg-red-50',     'border' => 'border-red-300',   'badge' => 'bg-red-100 text-red-700',    'icon' => 'text-red-500',    'title' => 'text-red-800'],
                'orange'  => ['bg' => 'bg-orange-50',  'border' => 'border-orange-300','badge' => 'bg-orange-100 text-orange-700','icon' => 'text-orange-500', 'title' => 'text-orange-800'],
            ];
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $emailTypeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeKey => $typeCfg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <?php
            $color = $typeCfg['color'] ?? 'blue';
            $cm = $colorMap[$color] ?? $colorMap['blue'];
            $isCustomized = isset($emailTemplates[$typeKey]) && (
                !empty($emailTemplates[$typeKey]['subject']) || !empty($emailTemplates[$typeKey]['body'])
            );
        ?>
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('email-type-{{ $typeKey }}', get_defined_vars()); ?>wire:key="email-type-<?php echo e($typeKey); ?>">
            
            <div class="flex items-center gap-3 px-5 py-4 <?php echo e($cm['bg']); ?> border-b <?php echo e($cm['border']); ?>">
                <div class="w-9 h-9 rounded-lg <?php echo e($cm['bg']); ?> border <?php echo e($cm['border']); ?> flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 <?php echo e($cm['icon']); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($typeCfg['icon']); ?>"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <h4 class="font-semibold text-gray-800 text-sm"><?php echo e($typeCfg['label']); ?></h4>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCustomized): ?>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($cm['badge']); ?>">Dikustomisasi</span>
                        <?php else: ?>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Default</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5"><?php echo e($typeCfg['desc']); ?></p>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCustomized): ?>
                <button type="button"
                    wire:click="resetEmailTemplate('<?php echo e($typeKey); ?>')"
                    wire:confirm="Reset template ini ke default? Kustomisasi Anda akan dihapus."
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
                        <span class="text-gray-400 font-normal ml-1">— kosongkan untuk menggunakan default</span>
                    </label>
                    <input type="text"
                        wire:model="emailTemplates.<?php echo e($typeKey); ?>.subject"
                        placeholder="<?php echo e($typeCfg['default_subject']); ?>"
                        class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php echo e($isCustomized && !empty($emailTemplates[$typeKey]['subject']) ? 'bg-white' : 'bg-gray-50'); ?>">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">
                        Isi Email (HTML diperbolehkan)
                        <span class="text-gray-400 font-normal ml-1">— kosongkan untuk menggunakan default</span>
                    </label>
                    <textarea
                        wire:model="emailTemplates.<?php echo e($typeKey); ?>.body"
                        rows="6"
                        placeholder="Tulis isi email di sini... HTML diperbolehkan untuk format teks (bold, link, dll)."
                        class="w-full px-3 py-2 border rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php echo e($isCustomized && !empty($emailTemplates[$typeKey]['body']) ? 'bg-white' : 'bg-gray-50'); ?>"></textarea>
                </div>

                
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-2">Variabel yang tersedia:</p>
                    <div class="flex flex-wrap gap-1.5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $typeCfg['vars']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <code class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-xs font-mono border border-gray-200 cursor-pointer hover:bg-gray-200 transition"
                            title="Klik untuk menyalin"
                            onclick="navigator.clipboard.writeText('<?php echo e($var); ?>')"><?php echo e($var); ?></code>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">Klik variabel untuk menyalin. Variabel akan diganti otomatis saat email dikirim.</p>
                </div>

                
                <div class="flex items-center gap-2 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox"
                            wire:model="emailTemplates.<?php echo e($typeKey); ?>.is_active"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-600">Aktifkan template ini</span>
                    </label>
                    <span class="text-xs text-gray-400">(jika tidak aktif, sistem akan menggunakan template default)</span>
                </div>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(false): ?>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Tampilkan di Web</h3>
            <p class="text-sm text-gray-500 mt-1">Pilih bagian yang ingin ditampilkan di halaman publik website. Centang bagian yang ingin diaktifkan, hapus centang untuk menyembunyikannya.</p>
        </div>

        <?php
            $sectionList = \App\Models\Conference::SECTIONS;
            $sectionIcons = [
                'hero'          => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                'info_cards'    => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                'about'         => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'speakers'      => 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z',
                'committees'    => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                'news'          => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6m-6 4h6',
                'registration'  => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
                'journals'      => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'cta'           => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.952 9.168-4.875',
            ];
            $sectionDescriptions = [
                'hero'          => 'Banner utama / slider gambar di bagian atas halaman.',
                'info_cards'    => 'Kartu informasi tanggal penting, publikasi, dan informasi singkat konferensi.',
                'about'         => 'Deskripsi lengkap, tema, topik, dan informasi konferensi.',
                'speakers'      => 'Daftar keynote speaker, narasumber, moderator/host.',
                'committees'    => 'Daftar panitia organizing dan scientific committee.',
                'news'          => 'Berita terbaru dan pengumuman untuk pengunjung.',
                'registration'  => 'Paket harga dan biaya pendaftaran.',
                'journals'      => 'Informasi jurnal publikasi terindeks.',
                'cta'           => 'Tombol ajakan untuk submit makalah / mendaftar.',
            ];
        ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sectionList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionId => $sectionLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php $isVisible = in_array($sectionId, $visibleSections); ?>
            <label class="flex items-start gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
                <?php echo e($isVisible ? 'border-blue-400 bg-blue-50' : 'border-gray-200 bg-gray-50 opacity-70'); ?>">
                <input type="checkbox"
                    wire:model.live="visibleSections"
                    value="<?php echo e($sectionId); ?>"
                    class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-4 h-4 <?php echo e($isVisible ? 'text-blue-600' : 'text-gray-400'); ?> shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($sectionIcons[$sectionId] ?? ''); ?>"/>
                        </svg>
                        <span class="text-sm font-semibold <?php echo e($isVisible ? 'text-blue-800' : 'text-gray-600'); ?>"><?php echo e($sectionLabel); ?></span>
                    </div>
                    <p class="text-xs <?php echo e($isVisible ? 'text-blue-600' : 'text-gray-400'); ?> leading-relaxed">
                        <?php echo e($sectionDescriptions[$sectionId] ?? ''); ?>

                    </p>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isVisible): ?>
                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <?php else: ?>
                <svg class="w-5 h-5 text-gray-300 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </label>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-amber-700">
                <p class="font-semibold">Keterangan</p>
                <p class="mt-0.5">Pengaturan ini mengontrol bagian yang tampil di halaman utama website publik. Bagian yang tidak dicentang akan disembunyikan dari pengunjung. Urutan tampilan diatur melalui <strong>Pengaturan Tema</strong>.</p>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'whatsapp'): ?>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Link Grup WhatsApp</h3>
            <p class="text-sm text-gray-500 mt-1">Masukkan link undangan grup WhatsApp untuk setiap kategori peserta. Link akan dikirim otomatis melalui email saat pembayaran diverifikasi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="p-5 rounded-xl border-2 border-green-200 bg-green-50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-green-800 text-sm">Peserta Pemakalah</p>
                        <p class="text-xs text-green-600">Peserta yang submit paper</p>
                    </div>
                </div>
                <input type="url"
                    wire:model.defer="wa_group_pemakalah"
                    placeholder="https://chat.whatsapp.com/..."
                    class="w-full border border-green-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:border-transparent bg-white">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['wa_group_pemakalah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="p-5 rounded-xl border-2 border-blue-200 bg-blue-50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-800 text-sm">Peserta Non-Pemakalah</p>
                        <p class="text-xs text-blue-600">Peserta registrasi tanpa paper</p>
                    </div>
                </div>
                <input type="url"
                    wire:model.defer="wa_group_non_pemakalah"
                    placeholder="https://chat.whatsapp.com/..."
                    class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent bg-white">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['wa_group_non_pemakalah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="p-5 rounded-xl border-2 border-purple-200 bg-purple-50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-purple-800 text-sm">Reviewer</p>
                        <p class="text-xs text-purple-600">Tim reviewer paper</p>
                    </div>
                </div>
                <input type="url"
                    wire:model.defer="wa_group_reviewer"
                    placeholder="https://chat.whatsapp.com/..."
                    class="w-full border border-purple-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-400 focus:border-transparent bg-white">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['wa_group_reviewer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="p-5 rounded-xl border-2 border-orange-200 bg-orange-50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-orange-800 text-sm">Editor / Admin</p>
                        <p class="text-xs text-orange-600">Tim editor & panitia</p>
                    </div>
                </div>
                <input type="url"
                    wire:model.defer="wa_group_editor"
                    placeholder="https://chat.whatsapp.com/..."
                    class="w-full border border-orange-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-400 focus:border-transparent bg-white">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['wa_group_editor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3">
            <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-green-700">
                <p class="font-semibold">Cara Mendapatkan Link Grup WhatsApp</p>
                <p class="mt-0.5">Buka grup WhatsApp → Klik nama grup → <em>Invite to Group via Link</em> → Copy link. Link biasanya berformat <code class="bg-white px-1 rounded text-xs">https://chat.whatsapp.com/xxxxx</code></p>
                <p class="mt-1">Link ini akan dikirim otomatis ke email peserta ketika pembayaran mereka diverifikasi (Lunas).</p>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="mt-6 flex justify-between items-center">
        <a href="<?php echo e(route('admin.conferences')); ?>" class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-50 inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Batal
        </a>
        <div class="flex items-center gap-3">
            
            <div class="hidden sm:flex items-center gap-1 text-xs text-gray-400">
                <?php
                    $tabs = ['general', 'dates', 'committees', 'topics', 'speakers', 'pricing', 'reviewers', 'guidelines', 'templates', 'journals', 'email_templates', 'whatsapp'];
                    $currentIdx = array_search($activeTab, $tabs);
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentIdx > 0): ?>
                <button type="button" wire:click="$set('activeTab', '<?php echo e($tabs[$currentIdx - 1]); ?>')" class="px-3 py-1.5 border rounded-lg text-gray-600 hover:bg-gray-50 text-sm">
                    &larr; Sebelumnya
                </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentIdx < count($tabs) - 1): ?>
                <button type="button" wire:click="$set('activeTab', '<?php echo e($tabs[$currentIdx + 1]); ?>')" class="px-3 py-1.5 border rounded-lg text-gray-600 hover:bg-gray-50 text-sm">
                    Selanjutnya &rarr;
                </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm inline-flex items-center gap-2">
                <span wire:loading.remove wire:target="save">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <?php echo e($isEdit ? 'Simpan Perubahan' : 'Buat Kegiatan'); ?>

                </span>
                <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </div>
    </form>
</div><?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views/livewire/admin/conference-form.blade.php ENDPATH**/ ?>