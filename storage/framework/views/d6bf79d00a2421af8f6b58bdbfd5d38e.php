<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Video Pemaparan</h1>
        <p class="text-sm text-gray-500 mt-1">Submit link video pemaparan (YouTube, Google Drive, dll.) untuk paper Anda.</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($papers->isEmpty()): ?>
        <div class="bg-white rounded-xl shadow-sm border p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada paper yang memerlukan video pemaparan.</p>
            <p class="text-gray-400 text-sm mt-1">Video pemaparan tersedia setelah pembayaran terverifikasi.</p>
        </div>
    <?php else: ?>
        <div class="space-y-5">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $papers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $hasVideo = !empty($paper->video_presentation_url);
                $embedUrl = null;
                if ($hasVideo && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/', $paper->video_presentation_url, $m)) {
                    $embedUrl = 'https://www.youtube.com/embed/' . $m[1];
                }
            ?>
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                
                <div class="px-6 py-4 border-b bg-gray-50 flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <a href="<?php echo e(route('author.paper.detail', $paper)); ?>" class="font-semibold text-gray-800 hover:text-blue-600 text-sm leading-snug line-clamp-2">
                            <?php echo e($paper->title); ?>

                        </a>
                        <div class="flex items-center gap-2 mt-1.5">
                            <?php $color = $paper->status_color; ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                <?php if($color==='green' || $color==='emerald'): ?> bg-green-100 text-green-800
                                <?php elseif($color==='teal'): ?> bg-teal-100 text-teal-800
                                <?php else: ?> bg-blue-100 text-blue-800 <?php endif; ?>">
                                <?php echo e($paper->status_label); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasVideo): ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                Video Tersedia
                            </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success_' . $paper->id)): ?>
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <?php echo e(session('success_' . $paper->id)); ?>

                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasVideo): ?>
                    <div class="mb-5">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Video Tersimpan</p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($embedUrl): ?>
                        <div class="relative rounded-lg overflow-hidden bg-black mb-2" style="padding-top:56.25%">
                            <iframe class="absolute inset-0 w-full h-full"
                                src="<?php echo e($embedUrl); ?>"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg border text-sm">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <a href="<?php echo e($paper->video_presentation_url); ?>" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline truncate"><?php echo e($paper->video_presentation_url); ?></a>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <form wire:submit="submitVideo(<?php echo e($paper->id); ?>)">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            <?php echo e($hasVideo ? 'Ganti Link Video' : 'Link Video Pemaparan'); ?>

                            <span class="text-gray-400 font-normal text-xs">(YouTube, Google Drive, OneDrive, dll.)</span>
                        </label>
                        <div class="flex gap-2">
                            <input wire:model="videoUrls.<?php echo e($paper->id); ?>"
                                   type="url"
                                   placeholder="https://www.youtube.com/watch?v=..."
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition shrink-0"
                                wire:loading.attr="disabled" wire:loading.class="opacity-60"
                                wire:target="submitVideo(<?php echo e($paper->id); ?>)">
                                <span wire:loading.remove wire:target="submitVideo(<?php echo e($paper->id); ?>)">
                                    <svg class="w-4 h-4 inline-block" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    <?php echo e($hasVideo ? 'Perbarui' : 'Submit'); ?>

                                </span>
                                <span wire:loading wire:target="submitVideo(<?php echo e($paper->id); ?>)">...</span>
                            </button>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["videoUrls.{$paper->id}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </form>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\livewire\author\video-submission.blade.php ENDPATH**/ ?>