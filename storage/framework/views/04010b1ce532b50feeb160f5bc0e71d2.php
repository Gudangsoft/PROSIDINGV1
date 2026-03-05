<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Paper Saya</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar paper yang telah Anda submit</p>
        </div>
        <a href="<?php echo e(route('author.submit')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium text-sm">
            + Submit Paper Baru
        </a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="flex gap-4 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul paper..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm">
        <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg text-sm">
            <option value="">Semua Status</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\Paper::STATUS_LABELS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <option value="<?php echo e($key); ?>"><?php echo e($label); ?></option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </select>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">#</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Judul</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Topik</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Tanggal Submit</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $papers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $paper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500"><?php echo e($papers->firstItem() + $i); ?></td>
                    <td class="px-4 py-3 font-medium text-gray-800 max-w-xs truncate"><?php echo e($paper->title); ?></td>
                    <td class="px-4 py-3 text-gray-600"><?php echo e($paper->topic); ?></td>
                    <td class="px-4 py-3">
                        <?php $color = $paper->status_color; ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?php if($color==='green'): ?> bg-green-100 text-green-800
                            <?php elseif($color==='red'): ?> bg-red-100 text-red-800
                            <?php elseif($color==='yellow' || $color==='amber'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($color==='blue' || $color==='cyan'): ?> bg-blue-100 text-blue-800
                            <?php elseif($color==='orange'): ?> bg-orange-100 text-orange-800
                            <?php elseif($color==='indigo' || $color==='purple'): ?> bg-indigo-100 text-indigo-800
                            <?php else: ?> bg-gray-100 text-gray-800
                            <?php endif; ?>">
                            <?php echo e($paper->status_label); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500"><?php echo e($paper->submitted_at?->format('d M Y') ?? '-'); ?></td>
                    <td class="px-4 py-3">
                        <a href="<?php echo e(route('author.paper.detail', $paper)); ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Detail</a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($paper->status, ['payment_pending', 'payment_uploaded'])): ?>
                            <a href="<?php echo e(route('author.paper.payment', $paper)); ?>" class="text-green-600 hover:text-green-800 font-medium text-sm ml-2">Bayar</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($paper->status, ['payment_verified', 'deliverables_pending', 'completed'])): ?>
                            <a href="<?php echo e(route('author.paper.deliverables', $paper)); ?>" class="text-purple-600 hover:text-purple-800 font-medium text-sm ml-2">Luaran</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                        <p class="text-lg mb-2">Belum ada paper</p>
                        <a href="<?php echo e(route('author.submit')); ?>" class="text-blue-600 hover:text-blue-800 text-sm">Submit paper pertama Anda</a>
                    </td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4"><?php echo e($papers->links()); ?></div>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\livewire\author\paper-list.blade.php ENDPATH**/ ?>