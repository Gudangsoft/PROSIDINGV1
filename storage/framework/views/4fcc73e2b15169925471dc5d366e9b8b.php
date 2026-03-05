<?php $__env->startSection('title', 'Dashboard - Prosiding LPKD-APJI'); ?>

<?php $__env->startSection('content'); ?>


<?php
    $popupUser = Auth::user();
    $popupAnn = null;
    try {
        if (\Illuminate\Support\Facades\Schema::hasColumn('announcements', 'show_popup')) {
            $popupAnn = \App\Models\Announcement::published()
                ->where('show_popup', true)
                ->where(function($q) use ($popupUser) {
                    $q->whereJsonContains('audience', $popupUser->role ?? 'participant')
                      ->orWhereJsonContains('audience', 'all');
                })
                ->whereNotIn('id', session('dismissed_popups', []))
                ->orderByDesc('priority')
                ->first();
        }
    } catch (\Throwable $e) {
        $popupAnn = null;
    }
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($popupAnn): ?>
<?php
    $popupColors = ['info'=>'blue','warning'=>'yellow','success'=>'green','danger'=>'red','deadline'=>'orange','result'=>'purple'];
    $pc = $popupColors[$popupAnn->type] ?? 'blue';
?>
<div
    x-data="{ open: true }"
    x-show="open"
    x-cloak
    style="display:none"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog" aria-modal="true">

    
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="open=false; dismissPopup(<?php echo e($popupAnn->id); ?>)"></div>

    
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden z-10 max-h-[90vh] flex flex-col"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">

        
        <div class="bg-<?php echo e($pc); ?>-600 px-6 py-4 flex items-start justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($popupAnn->type === 'info'): ?>
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?php elseif($popupAnn->type === 'warning' || $popupAnn->type === 'deadline'): ?>
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <?php elseif($popupAnn->type === 'success'): ?>
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?php else: ?>
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <h2 class="text-white font-bold text-lg leading-tight"><?php echo e($popupAnn->title); ?></h2>
            </div>
            <button @click="open=false; dismissPopup(<?php echo e($popupAnn->id); ?>)"
                    class="text-white/70 hover:text-white transition ml-3 mt-0.5 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($popupAnn->attachment): ?>
            <div class="mb-4">
                <img src="<?php echo e(Storage::url($popupAnn->attachment)); ?>" alt="Attachment"
                     class="w-full rounded-lg object-cover max-h-48" onerror="this.style.display='none'">
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="text-gray-700 text-sm leading-relaxed prose prose-sm max-w-none">
                <?php echo nl2br(e($popupAnn->content)); ?>

            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($popupAnn->expires_at): ?>
            <p class="mt-3 text-xs text-gray-400">
                Berlaku s.d. <?php echo e($popupAnn->expires_at->format('d F Y')); ?>

            </p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="px-6 pb-5 flex items-center justify-between">
            <label class="flex items-center gap-2 text-xs text-gray-500 cursor-pointer"
                   x-data="{ checked: false }" @click="checked=!checked; if(checked) dismissPopupPermanent(<?php echo e($popupAnn->id); ?>)">
                <input type="checkbox" :checked="checked" class="rounded border-gray-300 text-<?php echo e($pc); ?>-600 focus:ring-<?php echo e($pc); ?>-500">
                Jangan tampilkan lagi hari ini
            </label>
            <button @click="open=false; dismissPopup(<?php echo e($popupAnn->id); ?>)"
                    class="px-5 py-2 bg-<?php echo e($pc); ?>-600 text-white text-sm font-medium rounded-lg hover:bg-<?php echo e($pc); ?>-700 transition">
                Mengerti
            </button>
        </div>
    </div>
</div>

<script>
function dismissPopup(id) {
    fetch('/dismiss-popup/' + id, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '', 'Accept': 'application/json' }
    });
}
function dismissPopupPermanent(id) {
    fetch('/dismiss-popup/' + id + '?permanent=1', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '', 'Accept': 'application/json' }
    });
}
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 mt-1">Welcome, <?php echo e(Auth::user()->name); ?>! <span class="text-xs">(<?php echo e(ucfirst(Auth::user()->role)); ?>)</span></p>
    </div>

    <?php
        $user = Auth::user();
    ?>

    
    <?php
        $activeAnnouncements = \App\Models\Announcement::published()
            ->forAudience($user->role)
            ->orderByDesc('is_pinned')
            ->orderByDesc('priority')
            ->latest('published_at')
            ->take(5)->get();
    ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeAnnouncements->count()): ?>
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Pengumuman</h2>
        <div class="space-y-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeAnnouncements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ann): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $colors = ['info'=>'blue','warning'=>'yellow','success'=>'green','danger'=>'red','deadline'=>'orange','result'=>'purple'];
                $c = $colors[$ann->type] ?? 'gray';
            ?>
            <div class="bg-<?php echo e($c); ?>-50 border-l-4 border-<?php echo e($c); ?>-500 rounded-r-lg p-4">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ann->is_pinned): ?><svg class="w-4 h-4 text-<?php echo e($c); ?>-600" fill="currentColor" viewBox="0 0 20 20"><path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v2h2a1 1 0 010 2h-1l-1 9a2 2 0 01-2 2H7a2 2 0 01-2-2L4 9H3a1 1 0 110-2h2V5z"/></svg><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h3 class="font-semibold text-<?php echo e($c); ?>-800 text-sm"><?php echo e($ann->title); ?></h3>
                        </div>
                        <p class="text-<?php echo e($c); ?>-700 text-sm mt-1"><?php echo e(Str::limit(strip_tags($ann->content), 150)); ?></p>
                    </div>
                    <span class="text-xs text-<?php echo e($c); ?>-500 whitespace-nowrap ml-3"><?php echo e($ann->published_at?->diffForHumans()); ?></span>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php
        $activeConference = \App\Models\Conference::active()->first();
    ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConference): ?>
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-8">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800"><?php echo e($activeConference->name); ?></h2>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConference->theme): ?><p class="text-sm text-gray-500 mt-1"><?php echo e($activeConference->theme); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConference->acronym): ?><span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded"><?php echo e($activeConference->acronym); ?></span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConference->start_date): ?>
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <?php echo e($activeConference->date_range); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e(\App\Models\Conference::VENUE_TYPE_ICONS[$activeConference->venue_type ?? 'offline'] ?? ''); ?>"/></svg>
                <span class="inline-flex items-center gap-1.5">
                    <span class="px-1.5 py-0.5 rounded text-xs font-medium <?php echo e(\App\Models\Conference::VENUE_TYPE_COLORS[$activeConference->venue_type ?? 'offline'] ?? ''); ?>"><?php echo e($activeConference->venue_type_label); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConference->venue_type !== 'online'): ?>
                        <?php echo e($activeConference->venue_display); ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </span>
            </div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($activeConference->venue_type === 'online' || $activeConference->venue_type === 'hybrid') && $activeConference->online_url): ?>
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <a href="<?php echo e($activeConference->online_url); ?>" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                    Link Zoom Meeting
                </a>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConference->organizer): ?>
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <?php echo e($activeConference->organizer); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php $importantDates = $activeConference->importantDates()->orderBy('date')->get(); ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($importantDates->count()): ?>
        <div class="mt-5 pt-4 border-t">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Tanggal Penting</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $importantDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="flex items-center gap-2 text-sm <?php echo e($d->is_past ? 'text-gray-400 line-through' : 'text-gray-700'); ?>">
                    <span class="w-2 h-2 rounded-full <?php echo e($d->is_past ? 'bg-gray-300' : 'bg-blue-500'); ?> shrink-0"></span>
                    <span class="font-medium"><?php echo e($d->date->format('d M Y')); ?></span>
                    <span class="text-gray-500">— <?php echo e($d->title); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php
            $hasVerifiedPayment = $user->payments()->where('status', 'verified')->exists();
            $isAuthorWithAcceptedPaper = $user->isAuthor() && $user->papers()->whereIn('status', ['accepted','payment_pending','payment_uploaded','payment_verified','deliverables_pending','completed'])->exists();
            $isAuthorWithPayment = $user->isAuthor() && $user->papers()->whereHas('payment', fn($q) => $q->where('status', 'verified'))->exists();
            $isReviewer = $user->isReviewer();
            $waGroupLink = null;
            $waGroupLabel = null;
            
            // Prioritas 1: Reviewer -> wa_group_reviewer
            if ($isReviewer && $activeConference->wa_group_reviewer) {
                $waGroupLink = $activeConference->wa_group_reviewer;
                $waGroupLabel = 'Grup WA Reviewer';
            }
            // Prioritas 2: Author dengan paper accepted/verified -> wa_group_pemakalah
            elseif (($isAuthorWithAcceptedPaper || $isAuthorWithPayment) && $activeConference->wa_group_pemakalah) {
                $waGroupLink = $activeConference->wa_group_pemakalah;
                $waGroupLabel = 'Grup WA Pemakalah';
            } 
            // Prioritas 3: Peserta dengan pembayaran verified -> wa_group_non_pemakalah
            elseif ($hasVerifiedPayment && $activeConference->wa_group_non_pemakalah) {
                $waGroupLink = $activeConference->wa_group_non_pemakalah;
                $waGroupLabel = 'Grup WA Peserta';
            }
            // Fallback: jika hanya ada satu grup WA yang diset, tampilkan untuk user yang sudah bayar
            elseif ($hasVerifiedPayment && !$activeConference->wa_group_non_pemakalah && $activeConference->wa_group_pemakalah) {
                $waGroupLink = $activeConference->wa_group_pemakalah;
                $waGroupLabel = 'Grup WhatsApp';
            }
        ?>
        
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($waGroupLink): ?>
        <div class="mt-5 pt-4 border-t">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Grup WhatsApp</h3>
            <div class="flex items-center gap-3">
                <a href="<?php echo e($waGroupLink); ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <?php echo e($waGroupLabel); ?>

                </a>
            </div>
        </div>
        <?php elseif(($activeConference->wa_group_pemakalah || $activeConference->wa_group_non_pemakalah) && !$hasVerifiedPayment && !$isReviewer): ?>
        
        <div class="mt-5 pt-4 border-t">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Grup WhatsApp</h3>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <span>Link grup WhatsApp akan tersedia setelah pembayaran diverifikasi</span>
            </div>
        </div>
        <?php elseif($isReviewer && !$activeConference->wa_group_reviewer): ?>
        
        <div class="mt-5 pt-4 border-t">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Grup WhatsApp</h3>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <span>Link grup WhatsApp Reviewer akan segera tersedia</span>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->isAuthor()): ?>
    <?php
        $totalPapers = $user->papers()->count();
        $accepted = $user->papers()->whereIn('status', ['accepted','payment_pending','payment_uploaded','payment_verified','deliverables_pending','completed'])->count();
        $inReview = $user->papers()->whereIn('status', ['screening','in_review','revised'])->count();
        $needsAction = $user->papers()->whereIn('status', ['revision_required','payment_pending'])->count();
    ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Total Paper</p><p class="text-2xl font-bold text-gray-800"><?php echo e($totalPapers); ?></p></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-lg"><svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Accepted</p><p class="text-2xl font-bold text-gray-800"><?php echo e($accepted); ?></p></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-lg"><svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Dalam Review</p><p class="text-2xl font-bold text-gray-800"><?php echo e($inReview); ?></p></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <div class="flex items-center">
                <div class="bg-orange-100 p-3 rounded-lg"><svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Perlu Tindakan</p><p class="text-2xl font-bold text-gray-800"><?php echo e($needsAction); ?></p></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="<?php echo e(route('author.submit')); ?>" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <div><p class="font-medium text-gray-800">Submit Paper</p><p class="text-sm text-gray-500">Upload paper baru</p></div>
            </a>
            <a href="<?php echo e(route('author.papers')); ?>" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <div><p class="font-medium text-gray-800">Paper Saya</p><p class="text-sm text-gray-500">Lihat semua paper</p></div>
            </a>
            <a href="<?php echo e(route('author.papers')); ?>" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <div><p class="font-medium text-gray-800">Tracking</p><p class="text-sm text-gray-500">Cek progress paper</p></div>
            </a>
        </div>
    </div>

    
    <?php $recentPapers = $user->papers()->latest()->take(5)->get(); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentPapers->count()): ?>
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b"><h3 class="font-semibold text-gray-800">Paper Terbaru</h3></div>
        <table class="w-full text-sm">
            <tbody class="divide-y">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recentPapers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 font-medium text-gray-800"><?php echo e(Str::limit($paper->title, 60)); ?></td>
                    <td class="px-6 py-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            <?php if($paper->status_color==='green'): ?> bg-green-100 text-green-800
                            <?php elseif($paper->status_color==='red'): ?> bg-red-100 text-red-800
                            <?php elseif(in_array($paper->status_color,['yellow','amber'])): ?> bg-yellow-100 text-yellow-800
                            <?php elseif(in_array($paper->status_color,['blue','cyan'])): ?> bg-blue-100 text-blue-800
                            <?php elseif($paper->status_color==='orange'): ?> bg-orange-100 text-orange-800
                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>"><?php echo e($paper->status_label); ?></span>
                    </td>
                    <td class="px-6 py-3 text-gray-500 text-xs"><?php echo e($paper->submitted_at?->format('d M Y')); ?></td>
                    <td class="px-6 py-3"><a href="<?php echo e(route('author.paper.detail', $paper)); ?>" class="text-blue-600 text-sm">Detail</a></td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->isReviewer()): ?>
    <?php
        $pendingReviews = $user->reviews()->where('status', 'pending')->count();
        $inProgress = $user->reviews()->where('status', 'in_progress')->count();
        $completedReviews = $user->reviews()->where('status', 'completed')->count();
        $totalReviews = $user->reviews()->count();
    ?>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Total Tugas</p><p class="text-2xl font-bold text-gray-800"><?php echo e($totalReviews); ?></p></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-lg"><svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Pending</p><p class="text-2xl font-bold text-gray-800"><?php echo e($pendingReviews); ?></p></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <div class="flex items-center">
                <div class="bg-indigo-100 p-3 rounded-lg"><svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">In Progress</p><p class="text-2xl font-bold text-gray-800"><?php echo e($inProgress); ?></p></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-lg"><svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Selesai</p><p class="text-2xl font-bold text-gray-800"><?php echo e($completedReviews); ?></p></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
        <a href="<?php echo e(route('reviewer.reviews')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium">Lihat Semua Tugas Review</a>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->isEditor()): ?>
    <?php
        $totalPapers = \App\Models\Paper::count();
        $assignedToMe = \App\Models\Paper::where('assigned_editor_id', $user->id)->count();
        $newSubmissions = \App\Models\Paper::where('status', 'submitted')->count();
        $inReview = \App\Models\Paper::where('status', 'in_review')->count();
        $accepted = \App\Models\Paper::whereIn('status', ['accepted','payment_pending','payment_uploaded','payment_verified','deliverables_pending','completed'])->count();
        $pendingPayments = \App\Models\Payment::where('status', 'uploaded')->count();
    ?>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-blue-600"><?php echo e($totalPapers); ?></p>
            <p class="text-xs text-gray-500 mt-1">Total Paper</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-purple-600"><?php echo e($assignedToMe); ?></p>
            <p class="text-xs text-gray-500 mt-1">Ditugaskan ke Saya</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-yellow-600"><?php echo e($newSubmissions); ?></p>
            <p class="text-xs text-gray-500 mt-1">Baru Masuk</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-indigo-600"><?php echo e($inReview); ?></p>
            <p class="text-xs text-gray-500 mt-1">Dalam Review</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-green-600"><?php echo e($accepted); ?></p>
            <p class="text-xs text-gray-500 mt-1">Accepted</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-orange-600"><?php echo e($pendingPayments); ?></p>
            <p class="text-xs text-gray-500 mt-1">Bayar Pending</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
            <div class="space-y-3">
                <a href="<?php echo e(route('admin.papers')); ?>" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <div><p class="font-medium text-sm text-gray-800">Kelola Paper</p><p class="text-xs text-gray-500">Review, assign reviewer, update status</p></div>
                </a>
                <a href="<?php echo e(route('admin.payments')); ?>" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <div><p class="font-medium text-sm text-gray-800">Verifikasi Pembayaran</p><p class="text-xs text-gray-500"><?php echo e($pendingPayments); ?> pembayaran menunggu</p></div>
                </a>
                <a href="<?php echo e(route('admin.conferences')); ?>" class="flex items-center p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                    <svg class="w-6 h-6 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <div><p class="font-medium text-sm text-gray-800">Kegiatan Prosiding</p><p class="text-xs text-gray-500">Lihat kegiatan terdaftar</p></div>
                </a>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="px-6 py-4 border-b"><h3 class="font-semibold text-gray-800">Submission Terbaru</h3></div>
            <?php $latestPapers = \App\Models\Paper::with('user')->latest()->take(5)->get(); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($latestPapers->count()): ?>
            <div class="divide-y">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $latestPapers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="px-6 py-3 flex justify-between items-center hover:bg-gray-50">
                    <div>
                        <p class="text-sm font-medium text-gray-800"><?php echo e(Str::limit($paper->title, 40)); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($paper->user->name); ?> &bull; <?php echo e($paper->submitted_at?->diffForHumans()); ?></p>
                    </div>
                    <a href="<?php echo e(route('admin.paper.detail', $paper)); ?>" class="text-blue-600 text-xs font-medium">Kelola</a>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
            <?php else: ?>
            <p class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada submission.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->isKeuangan()): ?>
    <?php
        $pendingPayments = \App\Models\Payment::where('status', 'uploaded')->count();
        $verifiedPayments = \App\Models\Payment::where('status', 'verified')->count();
        $rejectedPayments = \App\Models\Payment::where('status', 'rejected')->count();
        $totalPayments = \App\Models\Payment::count();
        $todayPayments = \App\Models\Payment::whereDate('created_at', today())->count();
        $totalRevenue = \App\Models\Payment::where('status', 'verified')->sum('amount');
    ?>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-3xl font-bold text-orange-600"><?php echo e($pendingPayments); ?></p>
            <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-3xl font-bold text-green-600"><?php echo e($verifiedPayments); ?></p>
            <p class="text-sm text-gray-500">Terverifikasi</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-3xl font-bold text-red-600"><?php echo e($rejectedPayments); ?></p>
            <p class="text-sm text-gray-500">Ditolak</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-3xl font-bold text-blue-600"><?php echo e($totalPayments); ?></p>
            <p class="text-sm text-gray-500">Total Pembayaran</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-3xl font-bold text-purple-600"><?php echo e($todayPayments); ?></p>
            <p class="text-sm text-gray-500">Hari Ini</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-3xl font-bold text-emerald-600">Rp <?php echo e(number_format($totalRevenue / 1000000, 1)); ?>jt</p>
            <p class="text-sm text-gray-500">Total Pendapatan</p>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border mb-8">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Pembayaran Menunggu Verifikasi</h2>
            <a href="<?php echo e(route('keuangan.payments')); ?>" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <?php
            $recentPending = \App\Models\Payment::with(['user', 'paper'])
                ->where('status', 'uploaded')
                ->latest()
                ->take(5)
                ->get();
        ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentPending->count()): ?>
        <div class="divide-y">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recentPending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                <div>
                    <p class="font-medium text-gray-800"><?php echo e($payment->user->name ?? 'Unknown'); ?></p>
                    <p class="text-sm text-gray-500"><?php echo e($payment->paper->title ?? 'Participant Payment'); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($payment->created_at->diffForHumans()); ?></p>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-800"><?php echo e($payment->formatted_amount); ?></p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                        Menunggu
                    </span>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php else: ?>
        <p class="px-6 py-8 text-center text-gray-400 text-sm">Tidak ada pembayaran yang menunggu verifikasi.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
        <a href="<?php echo e(route('keuangan.payments')); ?>" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Verifikasi Pembayaran
        </a>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->isAdmin()): ?>
    <?php
        $totalPapers = \App\Models\Paper::count();
        $newSubmissions = \App\Models\Paper::where('status', 'submitted')->count();
        $inReview = \App\Models\Paper::where('status', 'in_review')->count();
        $accepted = \App\Models\Paper::whereIn('status', ['accepted','payment_pending','payment_uploaded','payment_verified','deliverables_pending','completed'])->count();
        $pendingPayments = \App\Models\Payment::where('status', 'uploaded')->count();
        $totalUsers = \App\Models\User::count();
        $totalConferences = \App\Models\Conference::count();
        $totalNews = \App\Models\News::count();
        $totalAnnouncements = \App\Models\Announcement::count();
    ?>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-blue-600"><?php echo e($totalPapers); ?></p>
            <p class="text-xs text-gray-500 mt-1">Total Paper</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-yellow-600"><?php echo e($newSubmissions); ?></p>
            <p class="text-xs text-gray-500 mt-1">Baru Masuk</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-indigo-600"><?php echo e($inReview); ?></p>
            <p class="text-xs text-gray-500 mt-1">Dalam Review</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-green-600"><?php echo e($accepted); ?></p>
            <p class="text-xs text-gray-500 mt-1">Accepted</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-purple-600"><?php echo e($pendingPayments); ?></p>
            <p class="text-xs text-gray-500 mt-1">Bayar Pending</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border text-center">
            <p class="text-2xl font-bold text-gray-600"><?php echo e($totalUsers); ?></p>
            <p class="text-xs text-gray-500 mt-1">Pengguna</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
            <div class="space-y-3">
                <a href="<?php echo e(route('admin.conferences')); ?>" class="flex items-center p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                    <svg class="w-6 h-6 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <div><p class="font-medium text-sm text-gray-800">Kegiatan Prosiding</p><p class="text-xs text-gray-500"><?php echo e($totalConferences); ?> kegiatan terdaftar</p></div>
                </a>
                <a href="<?php echo e(route('admin.papers')); ?>" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <div><p class="font-medium text-sm text-gray-800">Kelola Paper</p><p class="text-xs text-gray-500">Review, assign reviewer, update status</p></div>
                </a>
                <a href="<?php echo e(route('admin.payments')); ?>" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <div><p class="font-medium text-sm text-gray-800">Verifikasi Pembayaran</p><p class="text-xs text-gray-500"><?php echo e($pendingPayments); ?> pembayaran menunggu</p></div>
                </a>
                <a href="<?php echo e(route('admin.news')); ?>" class="flex items-center p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition">
                    <svg class="w-6 h-6 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <div><p class="font-medium text-sm text-gray-800">Kelola Berita</p><p class="text-xs text-gray-500"><?php echo e($totalNews); ?> berita</p></div>
                </a>
                <a href="<?php echo e(route('admin.announcements')); ?>" class="flex items-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition">
                    <svg class="w-6 h-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    <div><p class="font-medium text-sm text-gray-800">Kelola Pengumuman</p><p class="text-xs text-gray-500"><?php echo e($totalAnnouncements); ?> pengumuman</p></div>
                </a>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="px-6 py-4 border-b"><h3 class="font-semibold text-gray-800">Submission Terbaru</h3></div>
            <?php $latestPapers = \App\Models\Paper::with('user')->latest()->take(5)->get(); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($latestPapers->count()): ?>
            <div class="divide-y">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $latestPapers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="px-6 py-3 flex justify-between items-center hover:bg-gray-50">
                    <div>
                        <p class="text-sm font-medium text-gray-800"><?php echo e(Str::limit($paper->title, 40)); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($paper->user->name); ?> &bull; <?php echo e($paper->submitted_at?->diffForHumans()); ?></p>
                    </div>
                    <a href="<?php echo e(route('admin.paper.detail', $paper)); ?>" class="text-blue-600 text-xs font-medium">Kelola</a>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
            <?php else: ?>
            <p class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada submission.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Berita Terbaru</h3>
                <a href="<?php echo e(route('admin.news')); ?>" class="text-blue-600 text-xs font-medium">Lihat Semua</a>
            </div>
            <?php $latestNews = \App\Models\News::latest()->take(5)->get(); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($latestNews->count()): ?>
            <div class="divide-y">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $latestNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="px-6 py-3 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-800"><?php echo e(Str::limit($n->title, 40)); ?></p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs px-1.5 py-0.5 rounded bg-gray-100 text-gray-600"><?php echo e($n->category_label); ?></span>
                                <span class="text-xs text-gray-400"><?php echo e($n->created_at->diffForHumans()); ?></span>
                            </div>
                        </div>
                        <span class="text-xs px-1.5 py-0.5 rounded <?php echo e($n->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'); ?>"><?php echo e(ucfirst($n->status)); ?></span>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
            <?php else: ?>
            <p class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada berita.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Pengumuman Terbaru</h3>
                <a href="<?php echo e(route('admin.announcements')); ?>" class="text-blue-600 text-xs font-medium">Lihat Semua</a>
            </div>
            <?php $latestAnns = \App\Models\Announcement::latest()->take(5)->get(); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($latestAnns->count()): ?>
            <div class="divide-y">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $latestAnns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ann): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="px-6 py-3 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-800"><?php echo e(Str::limit($ann->title, 40)); ?></p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs px-1.5 py-0.5 rounded bg-<?php echo e(\App\Models\Announcement::TYPE_COLORS[$ann->type] ?? 'gray'); ?>-100 text-<?php echo e(\App\Models\Announcement::TYPE_COLORS[$ann->type] ?? 'gray'); ?>-700"><?php echo e($ann->type_label); ?></span>
                                <span class="text-xs text-gray-400">Untuk: <?php echo e(implode(', ', array_map('ucfirst', (array) $ann->audience))); ?></span>
                            </div>
                        </div>
                        <span class="text-xs px-1.5 py-0.5 rounded <?php echo e($ann->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'); ?>"><?php echo e(ucfirst($ann->status)); ?></span>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
            <?php else: ?>
            <p class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada pengumuman.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\dashboard.blade.php ENDPATH**/ ?>