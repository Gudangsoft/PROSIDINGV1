    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConference && $activeConference->isSectionVisible('committees') && $activeConference->committees->count()): ?>
    <section class="py-16 bg-gray-50/60">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider"><?php echo e(__('welcome.committees.badge')); ?></span>
                <h2 class="text-3xl font-extrabold text-gray-900"><?php echo e(__('welcome.committees.title')); ?></h2>
            </div>
            <?php $committeeGroups = $activeConference->committees->sortBy('sort_order')->groupBy('type'); ?>
            <div class="grid grid-cols-1 md:grid-cols-<?php echo e(min($committeeGroups->count(), 3)); ?> gap-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $committeeGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $members): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="bg-white rounded-2xl border p-6">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                        <?php echo e(\App\Models\Committee::TYPE_LABELS[$type] ?? ucfirst($type)); ?>

                    </h3>
                    <ul class="space-y-2.5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <li class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-teal-300 to-emerald-400 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate"><?php echo e($member->name); ?><?php echo e($member->title ? ', ' . $member->title : ''); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->institution || $member->role): ?>
                                <p class="text-xs text-gray-400 truncate"><?php echo e($member->role ? $member->role . ' — ' : ''); ?><?php echo e($member->institution); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\templates\emerald\sections\committees.blade.php ENDPATH**/ ?>