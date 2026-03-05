<div class="max-w-4xl mx-auto py-8 px-4">
    <a href="<?php echo e(route('author.paper.detail', $paper)); ?>" class="text-blue-600 hover:text-blue-800 text-sm">&larr; Kembali ke Detail Paper</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2 mb-1">Luaran Prosiding</h1>
    <p class="text-gray-500 text-sm mb-6"><?php echo e($paper->title); ?></p>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="space-y-4">
            <h3 class="font-semibold text-gray-800">Upload Luaran Anda</h3>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['poster' => 'Poster', 'ppt' => 'PPT Presentasi', 'final_paper' => 'Full Paper Final']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="bg-white rounded-xl shadow-sm border p-5">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-medium text-gray-800"><?php echo e($label); ?></h4>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($authorDeliverables[$type])): ?>
                        <span class="text-green-600 text-xs font-medium">✓ Diunggah</span>
                    <?php else: ?>
                        <span class="text-gray-400 text-xs">Belum diunggah</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($authorDeliverables[$type])): ?>
                    <div class="bg-gray-50 rounded-lg p-3 mb-3 text-sm">
                        <p class="text-gray-700"><?php echo e($authorDeliverables[$type]->original_name); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($authorDeliverables[$type]->created_at->format('d M Y h:i A')); ?></p>
                        <a href="<?php echo e(asset('storage/' . $authorDeliverables[$type]->file_path)); ?>" target="_blank" class="text-blue-600 text-xs">Download</a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php $fileProperty = match($type) { 'poster' => 'posterFile', 'ppt' => 'pptFile', 'final_paper' => 'finalPaperFile' }; ?>
                <div class="flex gap-2">
                    <input type="file" wire:model="<?php echo e($fileProperty); ?>" class="flex-1 text-sm" accept=".pdf,.ppt,.pptx,.jpg,.jpeg,.png">
                    <button wire:click="uploadDeliverable('<?php echo e($type); ?>')" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700" wire:loading.attr="disabled">
                        Upload
                    </button>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = [$fileProperty];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div wire:loading wire:target="<?php echo e($fileProperty); ?>" class="text-blue-500 text-xs mt-1">Mengunggah...</div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="space-y-4">
            <h3 class="font-semibold text-gray-800">Luaran dari Panitia</h3>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adminDeliverables->count()): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $adminDeliverables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deliverable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="bg-white rounded-xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-medium text-gray-800"><?php echo e(\App\Models\Deliverable::TYPE_LABELS[$deliverable->type] ?? $deliverable->type); ?></h4>
                        <span class="text-green-600 text-xs font-medium"><?php echo e($deliverable->sent_at?->format('d M Y')); ?></span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2"><?php echo e($deliverable->original_name); ?></p>
                    <a href="<?php echo e(asset('storage/' . $deliverable->file_path)); ?>" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download
                    </a>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php else: ?>
                <div class="bg-gray-50 rounded-xl border border-dashed border-gray-300 p-8 text-center">
                    <p class="text-gray-400 text-sm">Belum ada luaran dari panitia.</p>
                    <p class="text-gray-300 text-xs mt-1">Buku prosiding dan sertifikat akan dikirim setelah semua luaran Anda lengkap.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\livewire\author\deliverable-upload.blade.php ENDPATH**/ ?>