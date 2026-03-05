<!DOCTYPE html>
<?php
    $siteLanguage = \App\Models\Setting::getValue('site_language', 'id');
    app()->setLocale($siteLanguage);
?>
<html lang="<?php echo e($siteLanguage); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($conference->name); ?> — <?php echo e($siteName); ?></title>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogo): ?><link rel="icon" type="image/png" href="<?php echo e(asset('storage/' . $siteLogo)); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','system-ui','sans-serif']}}}}</script>
    <?php echo $__env->make('templates.oke.partials.theme-config', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
        [x-cloak]{display:none!important}.glass{background:rgba(255,255,255,0.8);backdrop-filter:blur(20px)}.line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
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
                    <a href="<?php echo e(route('proceedings')); ?>" class="text-sm text-teal-700 bg-teal-50 px-3 py-2 rounded-lg font-semibold"><?php echo e(__('welcome.nav.publikasi')); ?></a>
                    <a href="<?php echo e(route('archive')); ?>" class="text-sm text-gray-500 hover:text-teal-700 px-3 py-2 rounded-lg hover:bg-teal-50/60 transition font-medium"><?php echo e(__('welcome.nav.arsip')); ?></a>
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
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-12">
            <div class="text-center">
                <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2"><?php echo e($conference->name); ?></h1>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conference->theme): ?>
                <p class="text-teal-200 text-sm italic mb-3">"<?php echo e($conference->theme); ?>"</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="flex items-center justify-center gap-2 text-teal-200 text-sm">
                    <a href="<?php echo e(url('/')); ?>" class="hover:text-white transition"><?php echo e(__('welcome.nav.beranda')); ?></a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <a href="<?php echo e(route('proceedings')); ?>" class="hover:text-white transition"><?php echo e(__('welcome.nav.publikasi')); ?></a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-white">Detail</span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="max-w-6xl mx-auto px-4 sm:px-6 -mt-6 relative z-10 mb-10">
        <div class="bg-white rounded-2xl shadow-sm border p-5 flex flex-wrap items-center justify-center gap-8">
            <div class="text-center">
                <p class="text-2xl font-extrabold text-teal-700"><?php echo e($totalPapers); ?></p>
                <p class="text-xs text-gray-400 font-medium">Makalah</p>
            </div>
            <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>
            <div class="text-center">
                <p class="text-2xl font-extrabold text-teal-700"><?php echo e($totalAuthors); ?></p>
                <p class="text-xs text-gray-400 font-medium">Penulis</p>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topics->count()): ?>
            <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>
            <div class="text-center">
                <p class="text-2xl font-extrabold text-teal-700"><?php echo e($topics->count()); ?></p>
                <p class="text-xs text-gray-400 font-medium">Topik</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <section x-data="{
        search: '',
        selectedTopic: '',
        sortBy: 'title_asc',
        get filteredPapers() { return true; }
    }" class="max-w-6xl mx-auto px-4 sm:px-6 mb-20">
        <div class="bg-white rounded-2xl border p-5 mb-8">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input x-model="search" type="text" placeholder="Cari judul, penulis, kata kunci..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition outline-none">
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topics->count()): ?>
                <select x-model="selectedTopic" class="bg-gray-50 border border-gray-200 rounded-xl text-sm px-4 py-2.5 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 outline-none">
                    <option value="">Semua Topik</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <option value="<?php echo e($topic->id); ?>"><?php echo e($topic->name); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <select x-model="sortBy" class="bg-gray-50 border border-gray-200 rounded-xl text-sm px-4 py-2.5 focus:border-teal-400 focus:ring-2 focus:ring-teal-100 outline-none">
                    <option value="title_asc">Judul A-Z</option>
                    <option value="title_desc">Judul Z-A</option>
                    <option value="date_desc">Terbaru</option>
                    <option value="date_asc">Terlama</option>
                </select>
            </div>
        </div>

        
        <div class="space-y-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $papers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="bg-white rounded-xl border hover:shadow-md hover:border-teal-200 transition p-5 group"
                 x-show="
                    (search === '' || '<?php echo e(strtolower(addslashes($paper->title))); ?>'.includes(search.toLowerCase()) || '<?php echo e(strtolower(addslashes(implode(' ', $paper->authors ?? [])))); ?>'.includes(search.toLowerCase()))
                    && (selectedTopic === '' || '<?php echo e($paper->topic_id ?? ''); ?>' === selectedTopic)
                 "
                 x-transition>
                <div class="flex gap-4">
                    <div class="hidden sm:flex w-10 h-10 bg-teal-50 rounded-xl items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-800 group-hover:text-teal-700 transition mb-1.5 text-sm leading-relaxed"><?php echo e($paper->title); ?></h3>
                        <p class="text-xs text-gray-400 mb-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $paper->authors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php echo e($author); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paper->abstract): ?>
                        <details class="group/details mb-3">
                            <summary class="text-xs text-teal-600 cursor-pointer hover:text-teal-800 font-medium select-none">
                                <span class="group-open/details:hidden">Tampilkan Abstrak</span>
                                <span class="hidden group-open/details:inline">Sembunyikan Abstrak</span>
                            </summary>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed bg-gray-50 rounded-lg p-3"><?php echo e($paper->abstract); ?></p>
                        </details>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex flex-wrap items-center gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paper->doi): ?>
                            <a href="https://doi.org/<?php echo e($paper->doi); ?>" target="_blank" class="inline-flex items-center gap-1 text-xs font-medium text-teal-600 hover:text-teal-800 bg-teal-50 px-2.5 py-1 rounded-full transition">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                DOI
                            </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paper->topic): ?>
                            <span class="text-xs bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full"><?php echo e($paper->topic->name ?? $paper->topic); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paper->pages): ?>
                            <span class="text-xs text-gray-400">pp. <?php echo e($paper->pages); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paper->keywords): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = array_slice($paper->keywords, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <span class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-full"><?php echo e($kw); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9.75m3 0h3.75M9 15h3M5.625 21h12.75c.621 0 1.125-.504 1.125-1.125V8.625a.375.375 0 00-.375-.375h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5a.375.375 0 00-.375-.375H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                <p class="text-gray-400 font-medium">Belum ada makalah yang dipublikasikan.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    
    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500">
            <p><?php echo e($footerText ?: '© ' . date('Y') . ' ' . $siteName); ?></p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($poweredBy): ?><p class="mt-1 sm:mt-0"><?php echo e($poweredBy); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </footer>
<script src="https://unpkg.com/alpinejs@3.14.8/dist/cdn.min.js"></script>
</body>
</html>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\templates\oke\proceedings-detail.blade.php ENDPATH**/ ?>