<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
    
    <a href="<?php echo e(route('admin.helpdesk')); ?>" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Helpdesk
    </a>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
        <p class="text-sm text-green-700"><?php echo e(session('success')); ?></p>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">#<?php echo e($ticket->id); ?> — <?php echo e($ticket->subject); ?></h1>
                <div class="flex items-center gap-3 mt-2 text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?php echo e($ticket->status_color); ?>-100 text-<?php echo e($ticket->status_color); ?>-700">
                        <?php echo e($ticket->status_label); ?>

                    </span>
                    <span class="inline-flex items-center gap-1 text-gray-500">
                        <span class="w-2 h-2 rounded-full bg-<?php echo e($ticket->priority_color); ?>-500"></span>
                        <?php echo e($ticket->priority_label); ?>

                    </span>
                    <span class="text-gray-400"><?php echo e($ticket->category_label); ?></span>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <select wire:model="newStatus" class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\HelpdeskTicket::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <option value="<?php echo e($val); ?>"><?php echo e($label); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <button wire:click="updateStatus" class="px-3 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Update</button>
            </div>
        </div>

        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm bg-gray-50 rounded-lg p-4 mb-4">
            <div>
                <p class="text-gray-500 text-xs">Pengirim</p>
                <p class="font-medium text-gray-800"><?php echo e($ticket->user->name); ?></p>
                <p class="text-xs text-gray-400"><?php echo e($ticket->user->email); ?></p>
            </div>
            <div>
                <p class="text-gray-500 text-xs">Role</p>
                <p class="font-medium text-gray-800"><?php echo e(ucfirst($ticket->user->role)); ?></p>
            </div>
            <div>
                <p class="text-gray-500 text-xs">Dibuat</p>
                <p class="font-medium text-gray-800"><?php echo e($ticket->created_at->format('d M Y h:i A')); ?></p>
            </div>
            <div>
                <p class="text-gray-500 text-xs">Ditangani oleh</p>
                <p class="font-medium text-gray-800"><?php echo e($ticket->assignee?->name ?? '-'); ?></p>
            </div>
        </div>

        
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                    <?php echo e(strtoupper(substr($ticket->user->name, 0, 1))); ?>

                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800"><?php echo e($ticket->user->name); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($ticket->created_at->diffForHumans()); ?></p>
                </div>
            </div>
            <div class="text-sm text-gray-700 whitespace-pre-wrap"><?php echo e($ticket->message); ?></div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($replies->count()): ?>
    <div class="space-y-4 mb-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div class="bg-white rounded-xl shadow-sm border p-5 <?php echo e($reply->is_admin_reply ? 'border-l-4 border-l-blue-500' : ''); ?>">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-full <?php echo e($reply->is_admin_reply ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600'); ?> flex items-center justify-center font-bold text-xs">
                    <?php echo e(strtoupper(substr($reply->user->name, 0, 1))); ?>

                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">
                        <?php echo e($reply->user->name); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reply->is_admin_reply): ?>
                        <span class="text-xs bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded ml-1"><?php echo e(ucfirst($reply->user->role)); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </p>
                    <p class="text-xs text-gray-400"><?php echo e($reply->created_at->diffForHumans()); ?></p>
                </div>
            </div>
            <div class="text-sm text-gray-700 whitespace-pre-wrap ml-10"><?php echo e($reply->message); ?></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ticket->status !== 'closed'): ?>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-sm font-semibold text-gray-800 mb-3">Balas sebagai Admin</h3>
        <form wire:submit.prevent="sendReply">
            <textarea wire:model="replyMessage" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis balasan untuk pengguna..."></textarea>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['replyMessage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="flex justify-end mt-3">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Kirim Balasan
                </button>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div class="bg-gray-50 rounded-xl border p-6 text-center">
        <p class="text-sm text-gray-500">Tiket ini sudah ditutup.</p>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\livewire\admin\helpdesk-detail.blade.php ENDPATH**/ ?>