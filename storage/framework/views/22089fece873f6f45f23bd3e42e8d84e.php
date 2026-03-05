    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConference && $activeConference->isSectionVisible('journals') && $activeConference->journalPublications->where('is_active', true)->count()): ?>
    <section id="journals" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14">
                <span class="inline-block bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider"><?php echo e(__('welcome.journal.badge')); ?></span>
                <h2 class="text-3xl font-extrabold text-gray-900"><?php echo e(__('welcome.journal.title')); ?></h2>
                <p class="text-gray-400 mt-3 max-w-xl mx-auto"><?php echo e(__('welcome.journal.description')); ?></p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-<?php echo e(min($activeConference->journalPublications->where('is_active', true)->count(), 4)); ?> gap-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeConference->journalPublications->where('is_active', true)->sortBy('sort_order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="group bg-white rounded-2xl border hover:shadow-lg hover:border-teal-200 transition-all p-6 text-center relative flex flex-col">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($journal->sinta_rank): ?>
                    <span class="absolute top-3 right-3 text-[10px] font-bold px-2 py-0.5 rounded-full border <?php echo e($journal->sinta_badge_color); ?>"><?php echo e($journal->sinta_rank); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($journal->logo): ?>
                    <img src="<?php echo e(asset('storage/' . $journal->logo)); ?>" alt="<?php echo e($journal->name); ?>" class="h-16 max-w-full object-contain mx-auto mb-4 group-hover:scale-105 transition">
                    <?php else: ?>
                    <div class="w-16 h-16 bg-teal-50 rounded-xl mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <h3 class="text-sm font-bold text-gray-800 mb-1 group-hover:text-teal-700 transition line-clamp-2"><?php echo e($journal->name); ?></h3>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($journal->description): ?>
                    <p class="text-xs text-gray-400 line-clamp-2 flex-1"><?php echo e($journal->description); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($journal->url): ?>
                    <a href="<?php echo e($journal->url); ?>" target="_blank" class="mt-4 inline-block text-xs font-semibold text-teal-600 hover:text-teal-800 transition">
                        <?php echo e(__('welcome.journal.kunjungi')); ?> &rarr;
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\templates\emerald\sections\journals.blade.php ENDPATH**/ ?>