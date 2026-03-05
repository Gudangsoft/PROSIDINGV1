    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sliders->count() > 0 && (!$activeConference || $activeConference->isSectionVisible('hero'))): ?>
    <section x-data="{
        current: 0,
        total: <?php echo e($sliders->count()); ?>,
        paused: false,
        init() { setInterval(() => { if (!this.paused) this.current = (this.current + 1) % this.total; }, 6000); },
        next() { this.current = (this.current + 1) % this.total; },
        prev() { this.current = (this.current - 1 + this.total) % this.total; },
    }" @mouseenter="paused = true" @mouseleave="paused = false" class="relative w-full overflow-hidden" style="height: 520px;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div x-show="current === <?php echo e($index); ?>"
             x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="absolute inset-0 w-full h-full" <?php echo e($index > 0 ? 'x-cloak' : ''); ?>>
            <div class="absolute inset-0">
                <img src="<?php echo e($slider->image_url); ?>" alt="<?php echo e($slider->title); ?>" class="w-full h-full object-cover">
                <div class="absolute inset-0" style="background: <?php echo e($slider->overlay_color ?? 'linear-gradient(135deg, rgba(13,148,136,0.6), rgba(6,95,70,0.5))'); ?>;"></div>
            </div>
            <div class="relative h-full flex items-center">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 w-full">
                    <div class="max-w-xl <?php echo e($slider->text_position === 'center' ? 'mx-auto text-center' : ($slider->text_position === 'right' ? 'ml-auto text-right' : 'text-left')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slider->subtitle): ?>
                        <p class="text-sm font-semibold mb-3 tracking-[0.2em] uppercase <?php echo e($slider->text_color === 'dark' ? 'text-teal-800' : 'text-teal-200'); ?>"><?php echo e($slider->subtitle); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slider->title): ?>
                        <h2 class="text-3xl md:text-5xl font-extrabold mb-4 leading-tight <?php echo e($slider->text_color === 'dark' ? 'text-gray-900' : 'text-white'); ?>"><?php echo e($slider->title); ?></h2>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slider->description): ?>
                        <p class="text-base md:text-lg mb-8 leading-relaxed <?php echo e($slider->text_color === 'dark' ? 'text-gray-600' : 'text-gray-100'); ?>"><?php echo e($slider->description); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex gap-3 <?php echo e($slider->text_position === 'center' ? 'justify-center' : ($slider->text_position === 'right' ? 'justify-end' : 'justify-start')); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slider->button_text && $slider->button_url): ?>
                            <a href="<?php echo e($slider->button_url); ?>" class="inline-flex items-center gap-2 px-7 py-3 bg-teal-600 text-white rounded-full font-semibold hover:bg-teal-700 transition shadow-lg shadow-teal-600/30"><?php echo e($slider->button_text); ?> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slider->button_text_2 && $slider->button_url_2): ?>
                            <a href="<?php echo e($slider->button_url_2); ?>" class="inline-flex items-center gap-2 px-7 py-3 border-2 rounded-full font-semibold transition <?php echo e($slider->text_color === 'dark' ? 'border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white' : 'border-white/80 text-white hover:bg-white hover:text-teal-700'); ?>"><?php echo e($slider->button_text_2); ?></a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sliders->count() > 1): ?>
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur text-white p-2.5 rounded-full transition z-10"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur text-white p-2.5 rounded-full transition z-10"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <button @click="current=<?php echo e($index); ?>" :class="current===<?php echo e($index); ?> ? 'bg-white w-8' : 'bg-white/40 w-2.5'" class="h-2.5 rounded-full transition-all duration-300"></button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </section>
    <?php else: ?>
    
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-teal-50 via-emerald-50 to-cyan-50"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-emerald-200/30 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-28 text-center">
            <div class="inline-flex items-center gap-2 bg-teal-100 text-teal-700 text-xs font-bold px-4 py-1.5 rounded-full mb-6 uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/></svg>
                Prosiding
            </div>
            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 mb-5 leading-tight"><?php echo e($siteName); ?></h1>
            <p class="text-xl text-gray-500 mb-4 max-w-2xl mx-auto font-light"><?php echo e($siteTagline); ?></p>
            <p class="text-gray-400 mb-10 max-w-xl mx-auto"><?php echo e(__('welcome.hero.description')); ?></p>
            <div class="flex justify-center gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>" class="bg-teal-600 text-white px-8 py-3.5 rounded-full font-semibold hover:bg-teal-700 transition shadow-lg shadow-teal-600/20 text-lg"><?php echo e(__('welcome.hero.dashboard')); ?></a>
                <?php else: ?>
                    <a href="<?php echo e(route('register')); ?>" class="bg-teal-600 text-white px-8 py-3.5 rounded-full font-semibold hover:bg-teal-700 transition shadow-lg shadow-teal-600/20 text-lg"><?php echo e(__('welcome.hero.submit_paper')); ?></a>
                    <a href="<?php echo e(route('login')); ?>" class="border-2 border-gray-300 text-gray-600 px-8 py-3.5 rounded-full font-semibold hover:border-teal-600 hover:text-teal-700 transition text-lg">Login</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\templates\emerald\sections\hero.blade.php ENDPATH**/ ?>