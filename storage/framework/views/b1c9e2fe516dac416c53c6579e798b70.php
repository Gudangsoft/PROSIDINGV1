<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Paper untuk Review</h1>
        <p class="text-gray-500 text-sm mt-1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isAdminOrEditor ?? false): ?>
                Daftar semua review (Admin/Editor View)
            <?php else: ?>
                Daftar paper yang ditugaskan kepada Anda
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex gap-3 mb-4">
        <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg text-sm">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
    </div>

    <div class="space-y-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800 mb-1"><?php echo e($review->paper->title); ?></h3>
                    <p class="text-sm text-gray-500">Penulis: <?php echo e($review->paper->user->name); ?></p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isAdminOrEditor ?? false): ?>
                    <p class="text-sm text-indigo-600 font-medium">Reviewer: <?php echo e($review->reviewer->name ?? '-'); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <p class="text-xs text-gray-400 mt-1">Topik: <?php echo e($review->paper->topic); ?> &bull; Ditugaskan: <?php echo e($review->created_at->format('d M Y')); ?></p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        <?php if($review->status==='completed'): ?> bg-green-100 text-green-800
                        <?php elseif($review->status==='in_progress'): ?> bg-blue-100 text-blue-800
                        <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                        <?php echo e(ucfirst(str_replace('_', ' ', $review->status))); ?>

                    </span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->recommendation): ?>
                        <p class="text-xs text-gray-500 mt-1"><?php echo e(\App\Models\Review::RECOMMENDATION_LABELS[$review->recommendation] ?? ''); ?> (<?php echo e($review->score); ?>/100)</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="flex gap-3 mt-4">
                <?php $latestFile = $review->paper->files->whereIn('type', ['full_paper','revision'])->sortByDesc('created_at')->first(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($latestFile): ?>
                    <a href="<?php echo e(asset('storage/'.$latestFile->file_path)); ?>" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium">📄 Download Paper</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->status !== 'completed'): ?>
                    <a href="<?php echo e(route('reviewer.review.form', $review)); ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">✏️ Beri Review</a>
                <?php else: ?>
                    <a href="<?php echo e(route('reviewer.review.form', $review)); ?>" class="text-gray-500 hover:text-gray-700 text-sm">📋 Lihat Review</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <div class="bg-white rounded-xl border p-12 text-center">
            <p class="text-gray-400">Belum ada paper yang ditugaskan untuk Anda review.</p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="mt-4"><?php echo e($reviews->links()); ?></div>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views/livewire/reviewer/review-list.blade.php ENDPATH**/ ?>