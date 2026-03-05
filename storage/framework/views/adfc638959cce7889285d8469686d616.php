<!DOCTYPE html>
<?php
    $siteLanguage = \App\Models\Setting::getValue('site_language', 'id');
    app()->setLocale($siteLanguage);
?>
<html lang="<?php echo e($siteLanguage); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('welcome.nav.arsip')); ?> — <?php echo e($siteName); ?></title>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogo): ?><link rel="icon" type="image/png" href="<?php echo e(asset('storage/' . $siteLogo)); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','system-ui','sans-serif']}}}}</script>
    <?php echo $__env->make('templates.emerald.partials.theme-config', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
        [x-cloak]{display:none!important}.glass{background:rgba(255,255,255,0.8);backdrop-filter:blur(20px)}
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased text-gray-700">

    
    <nav class="glass shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between h-16 items-center">
                <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-2.5 group">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogo): ?>
                        <img src="<?php echo e(asset('storage/' . $siteLogo)); ?>" alt="Logo" class="h-9 w-9 object-contain rounded-lg">
                    <?php else: ?>
                        <div class="w-9 h-9 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/></svg>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php echo $__env->make('partials.navbar-brand', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </a>
                <div class="hidden md:flex items-center gap-1">
                    <a href="<?php echo e(url('/')); ?>" class="text-sm text-gray-500 hover:text-teal-700 px-3 py-2 rounded-lg hover:bg-teal-50/60 transition font-medium"><?php echo e(__('welcome.nav.beranda')); ?></a>
                    <a href="<?php echo e(route('proceedings')); ?>" class="text-sm text-gray-500 hover:text-teal-700 px-3 py-2 rounded-lg hover:bg-teal-50/60 transition font-medium"><?php echo e(__('welcome.nav.publikasi')); ?></a>
                    <a href="<?php echo e(route('archive')); ?>" class="text-sm text-teal-700 bg-teal-50 px-3 py-2 rounded-lg font-semibold"><?php echo e(__('welcome.nav.arsip')); ?></a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($headerMenus->count()): ?>
                    <?php echo $__env->make(\App\Helpers\Template::view('partials.menu-dropdown'), ['items' => $headerMenus, 'depth' => 0], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="w-px h-5 bg-gray-200 mx-2"></div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="text-sm bg-teal-600 text-white px-5 py-2 rounded-full hover:bg-teal-700 font-medium transition shadow-sm">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-sm text-gray-500 hover:text-teal-700 px-3 py-2 font-medium transition">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="text-sm bg-teal-600 text-white px-5 py-2 rounded-full hover:bg-teal-700 font-medium transition shadow-sm">Register</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    
    <div class="bg-gradient-to-r from-teal-600 to-emerald-600 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAwIDEwIEwgNDAgMTAgTSAxMCAwIEwgMTAgNDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-100"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-12 text-center">
            <h1 class="text-3xl font-extrabold text-white mb-2"><?php echo e(__('welcome.nav.arsip')); ?></h1>
            <p class="text-teal-200 text-sm mb-3">Arsip konferensi dan kegiatan terdahulu</p>
            <div class="flex items-center justify-center gap-2 text-teal-200 text-sm">
                <a href="<?php echo e(url('/')); ?>" class="hover:text-white transition"><?php echo e(__('welcome.nav.beranda')); ?></a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white"><?php echo e(__('welcome.nav.arsip')); ?></span>
            </div>
        </div>
    </div>

    
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conferences->count()): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $conferences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <a href="<?php echo e(route('archive.detail', $conf->slug ?? $conf->id)); ?>" class="group bg-white rounded-2xl border hover:shadow-xl hover:border-teal-200 transition-all flex flex-col overflow-hidden">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conf->cover_image): ?>
                <div class="h-40 overflow-hidden">
                    <img src="<?php echo e(asset('storage/' . $conf->cover_image)); ?>" alt="<?php echo e($conf->name); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <?php else: ?>
                <div class="h-32 bg-gradient-to-br from-teal-400 to-emerald-500 relative flex items-center justify-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conf->logo): ?>
                    <img src="<?php echo e(asset('storage/' . $conf->logo)); ?>" alt="<?php echo e($conf->name); ?>" class="h-16 object-contain drop-shadow-md">
                    <?php else: ?>
                    <div class="text-white/30">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/></svg>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="font-bold text-gray-800 group-hover:text-teal-700 transition mb-2 text-sm"><?php echo e($conf->name); ?></h3>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conf->theme): ?>
                    <p class="text-xs text-gray-400 italic mb-3 line-clamp-2">"<?php echo e($conf->theme); ?>"</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="mt-auto flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-1.5 text-xs text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <?php echo e($conf->start_date?->translatedFormat('d M Y')); ?>

                        </div>
                        <span class="text-xs font-medium text-teal-600 group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                            Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </div>
            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20">
            <svg class="w-20 h-20 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <p class="text-gray-400 text-lg font-medium">Belum ada arsip konferensi.</p>
            <a href="<?php echo e(url('/')); ?>" class="inline-block mt-4 text-sm text-teal-600 hover:text-teal-800 font-medium">← Kembali ke Beranda</a>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </section>

    
    <footer class="bg-gray-900 text-gray-400 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500">
            <p><?php echo e($footerText ?: '© ' . date('Y') . ' ' . $siteName); ?></p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($poweredBy): ?><p class="mt-1 sm:mt-0"><?php echo e($poweredBy); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </footer>
<script src="https://unpkg.com/alpinejs@3.14.8/dist/cdn.min.js"></script>
</body>
</html>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\templates\emerald\archive.blade.php ENDPATH**/ ?>