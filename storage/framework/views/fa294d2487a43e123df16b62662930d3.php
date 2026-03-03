<div class="max-w-7xl mx-auto py-8 px-4">
    
    <div class="mb-6 flex items-start justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Submissions</h1>
        
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConference && $activeConference->certificate_generation_mode === 'auto'): ?>
        <button wire:click="bulkGenerateCertificates" 
                wire:confirm="Generate sertifikat untuk semua paper yang sudah accepted/completed? Proses ini tidak bisa dibatalkan."
                wire:loading.attr="disabled"
                type="button"
                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 disabled:opacity-60 cursor-pointer">
            <span wire:loading.remove wire:target="bulkGenerateCertificates">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </span>
            <span wire:loading wire:target="bulkGenerateCertificates" class="animate-spin">⟳</span>
            Generate All Certificates
        </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 mb-4 text-sm"><?php echo e(session('error')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="border-b border-gray-200 mb-0">
        <nav class="flex space-x-0" aria-label="Tabs">
            <button wire:click="setTab('my_queue')" type="button"
                class="px-5 py-3 text-sm font-medium border-b-2 transition-colors cursor-pointer
                    <?php echo e($activeTab === 'my_queue' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                My Queue
                <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full <?php echo e($activeTab === 'my_queue' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700'); ?>"><?php echo e($this->tabCounts['my_queue']); ?></span>
            </button>
            <button wire:click="setTab('unassigned')" type="button"
                class="px-5 py-3 text-sm font-medium border-b-2 transition-colors cursor-pointer
                    <?php echo e($activeTab === 'unassigned' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                Unassigned
                <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full <?php echo e($activeTab === 'unassigned' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700'); ?>"><?php echo e($this->tabCounts['unassigned']); ?></span>
            </button>
            <button wire:click="setTab('all_active')" type="button"
                class="px-5 py-3 text-sm font-medium border-b-2 transition-colors cursor-pointer
                    <?php echo e($activeTab === 'all_active' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                All Active
                <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full <?php echo e($activeTab === 'all_active' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700'); ?>"><?php echo e($this->tabCounts['all_active']); ?></span>
            </button>
            <button wire:click="setTab('archives')" type="button"
                class="px-5 py-3 text-sm font-medium border-b-2 transition-colors cursor-pointer
                    <?php echo e($activeTab === 'archives' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                Archives
                <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full <?php echo e($activeTab === 'archives' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700'); ?>"><?php echo e($this->tabCounts['archives']); ?></span>
            </button>

            
            <div class="ml-auto flex items-center">
                <button type="button" class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded hover:bg-blue-50 flex items-center gap-1 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 16v-4m0-4h.01" stroke-width="2" stroke-linecap="round"/></svg>
                    Help
                </button>
            </div>
        </nav>
    </div>

    
    <div class="bg-white border border-t-0 border-gray-200 rounded-b-lg shadow-sm">
        
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">
                <?php echo e(match($activeTab) {
                    'my_queue' => 'My Queue',
                    'unassigned' => 'Unassigned',
                    'all_active' => 'All Active',
                    'archives' => 'Archives',
                }); ?>

            </h2>
            <div class="flex items-center gap-2">
                
                <div class="relative">
                    <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                        <span class="px-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round"/></svg>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search"
                            class="py-1.5 pr-3 text-sm border-0 outline-none focus:ring-0 w-48">
                    </div>
                </div>

                
                <div class="relative">
                    <button wire:click="toggleFilters" type="button"
                        class="px-3 py-1.5 text-sm font-medium border border-gray-300 rounded hover:bg-gray-50 flex items-center gap-1 cursor-pointer
                            <?php echo e($statusFilter ? 'bg-blue-50 border-blue-300 text-blue-700' : ''); ?>">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-width="2"/></svg>
                        Filters
                    </button>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showFilters): ?>
                    <div class="absolute right-0 mt-1 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50 p-3">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select wire:model.live="statusFilter" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm">
                            <option value="">All Statuses</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\Paper::STATUS_LABELS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($key); ?>"><?php echo e($label); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <a href="<?php echo e(route('author.submit')); ?>"
                    class="px-3 py-1.5 text-sm font-medium border border-gray-300 rounded hover:bg-gray-50">
                    New Submission
                </a>
            </div>
        </div>

        
        <div class="divide-y divide-gray-100">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $papers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors group">
                
                <div class="flex items-start gap-4 flex-1 min-w-0">
                    <span class="text-sm text-blue-600 font-medium mt-0.5 flex-shrink-0"><?php echo e($paper->id); ?></span>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-800"><?php echo e($paper->user->name); ?></p>
                        <p class="text-sm text-gray-600 truncate"><?php echo e($paper->title); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paper->assignedEditor): ?>
                        <p class="text-xs text-gray-500 mt-0.5">
                            <svg class="w-3 h-3 inline -mt-0.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Editor: <?php echo e($paper->assignedEditor->name); ?>

                        </p>
                        <?php else: ?>
                        <p class="text-xs mt-0.5">
                            <span class="text-red-600">
                                <svg class="w-3.5 h-3.5 inline -mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                                No editor has been assigned to this submission.
                            </span>
                            <button wire:click="openAssignEditor(<?php echo e($paper->id); ?>)" type="button" class="text-blue-600 hover:underline ml-1 cursor-pointer">Assign Editor</button>
                        </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="flex items-center gap-3 flex-shrink-0">
                    
                    <?php
                        $statusColors = [
                            'submitted' => 'border-blue-400 text-blue-700',
                            'screening' => 'border-yellow-400 text-yellow-700',
                            'in_review' => 'border-indigo-400 text-indigo-700',
                            'revision_required' => 'border-orange-400 text-orange-700',
                            'revised' => 'border-cyan-400 text-cyan-700',
                            'accepted' => 'border-green-400 text-green-700',
                            'rejected' => 'border-red-400 text-red-700',
                            'payment_pending' => 'border-amber-400 text-amber-700',
                            'payment_uploaded' => 'border-purple-400 text-purple-700',
                            'payment_verified' => 'border-emerald-400 text-emerald-700',
                            'deliverables_pending' => 'border-teal-400 text-teal-700',
                            'completed' => 'border-green-400 text-green-700',
                        ];
                        $statusDots = [
                            'submitted' => 'bg-blue-400',
                            'screening' => 'bg-yellow-400',
                            'in_review' => 'bg-indigo-400',
                            'revision_required' => 'bg-orange-400',
                            'revised' => 'bg-cyan-400',
                            'accepted' => 'bg-green-400',
                            'rejected' => 'bg-red-400',
                            'payment_pending' => 'bg-amber-400',
                            'payment_uploaded' => 'bg-purple-400',
                            'payment_verified' => 'bg-emerald-400',
                            'deliverables_pending' => 'bg-teal-400',
                            'completed' => 'bg-green-400',
                        ];
                    ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border
                        <?php echo e($statusColors[$paper->status] ?? 'border-gray-400 text-gray-700'); ?>">
                        <span class="w-2 h-2 rounded-full <?php echo e($statusDots[$paper->status] ?? 'bg-gray-400'); ?>"></span>
                        <?php echo e($paper->status_label); ?>

                    </span>

                    
                    <a href="<?php echo e(route('admin.paper.detail', $paper)); ?>"
                        class="px-3 py-1.5 text-sm font-medium border border-gray-300 rounded hover:bg-gray-100 transition-colors">
                        View
                    </a>

                    
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button" class="p-1.5 text-gray-400 hover:text-gray-600 border border-gray-300 rounded hover:bg-gray-100 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-1 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 py-1">
                            <a href="<?php echo e(route('admin.paper.detail', $paper)); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Submission</a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paper->status === 'submitted'): ?>
                            <button wire:click="$dispatch('quick-action', { paperId: <?php echo e($paper->id); ?>, action: 'decline' })"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Decline Submission</button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="border-t border-gray-100 my-1"></div>
                            <span class="block px-4 py-2 text-xs text-gray-400">ID: <?php echo e($paper->id); ?> &bull; <?php echo e($paper->submitted_at?->format('M d, Y')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="px-5 py-16 text-center">
                <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <p class="text-gray-400 text-sm">No submissions found.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="mt-4"><?php echo e($papers->links()); ?></div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAssignEditorModal): ?>
    <div class="fixed inset-0 bg-black/50 flex items-start justify-center pt-20 z-50" wire:click.self="closeAssignEditor">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md" @click.stop>
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">Assign Editor</h3>
                <button wire:click="closeAssignEditor" type="button" class="text-gray-400 hover:text-gray-600 text-xl cursor-pointer">&times;</button>
            </div>
            <div class="p-5">
                <p class="text-sm text-gray-600 mb-4">Pilih editor yang akan menangani submission ini.</p>
                <label class="block text-sm font-medium text-gray-700 mb-2">Editor</label>
                <select wire:model="selectedEditorId" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">-- Pilih Editor --</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $editors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <option value="<?php echo e($editor->id); ?>"><?php echo e($editor->name); ?> (<?php echo e($editor->email); ?>)</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedEditorId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="flex justify-end gap-2 px-5 py-4 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                <button wire:click="assignEditor" type="button" class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer">
                    <span wire:loading.remove wire:target="assignEditor">Assign</span>
                    <span wire:loading wire:target="assignEditor">Assigning...</span>
                </button>
                <button wire:click="closeAssignEditor" type="button" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 cursor-pointer">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views/livewire/admin/paper-management.blade.php ENDPATH**/ ?>