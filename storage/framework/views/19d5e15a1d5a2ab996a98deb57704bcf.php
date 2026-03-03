<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Verifikasi Pembayaran</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola pembayaran penulis — cek bukti bayar, lalu ubah status: Lunas, Pending, atau Ditolak</p>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Total Pemasukan</p>
                    <p class="text-2xl font-bold mt-1">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-emerald-100 text-xs mt-2">Pembayaran terverifikasi</p>
        </div>

        
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold mt-1">Rp <?php echo e(number_format($pendingRevenue, 0, ',', '.')); ?></p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-amber-100 text-xs mt-2">Pending & sudah upload</p>
        </div>

        
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Pemasukan Hari Ini</p>
                    <p class="text-2xl font-bold mt-1">Rp <?php echo e(number_format($todayRevenue, 0, ',', '.')); ?></p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-blue-100 text-xs mt-2"><?php echo e(now()->format('d M Y')); ?></p>
        </div>

        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Pemasukan Bulan Ini</p>
                    <p class="text-2xl font-bold mt-1">Rp <?php echo e(number_format($monthRevenue, 0, ',', '.')); ?></p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-purple-100 text-xs mt-2"><?php echo e(now()->format('F Y')); ?></p>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex flex-col sm:flex-row gap-3 mb-4 items-center justify-between flex-wrap">
        <div class="flex flex-col sm:flex-row gap-3">
            
            <div class="flex border border-gray-200 rounded-lg overflow-hidden text-sm">
                <button wire:click="$set('typeFilter', '')" class="px-4 py-2 font-medium transition <?php echo e($typeFilter === '' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'); ?> cursor-pointer">
                    Semua (<?php echo e($allCount); ?>)
                </button>
                <button wire:click="$set('typeFilter', 'paper')" class="px-4 py-2 font-medium transition border-l border-gray-200 <?php echo e($typeFilter === 'paper' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'); ?> cursor-pointer">
                    Paper (<?php echo e($paperCount); ?>)
                </button>
                <button wire:click="$set('typeFilter', 'participant')" class="px-4 py-2 font-medium transition border-l border-gray-200 <?php echo e($typeFilter === 'participant' ? 'bg-teal-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'); ?> cursor-pointer">
                    Partisipan (<?php echo e($participantCount); ?>)
                </button>
            </div>
            <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="uploaded">Sudah Upload</option>
                <option value="verified">Lunas</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>

        
        <a href="<?php echo e(route('admin.payments.export', array_filter(['type' => $typeFilter, 'status' => $statusFilter]))); ?>"
           class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium shadow-sm transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Export Excel
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Invoice</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Tipe</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Paper / Keterangan</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">User</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Jumlah</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Bukti</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-xs"><?php echo e($payment->invoice_number); ?></td>
                    <td class="px-4 py-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->type === 'participant'): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">Partisipan</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">Paper</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="px-4 py-3 max-w-[200px] truncate">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->type === 'participant'): ?>
                            <span class="text-gray-600">Registrasi Partisipan</span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->user && $payment->user->institution): ?>
                                <p class="text-xs text-gray-400 truncate"><?php echo e($payment->user->institution); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <?php echo e($payment->paper->title ?? '-'); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="px-4 py-3 text-gray-600"><?php echo e($payment->user->name ?? '-'); ?></td>
                    <td class="px-4 py-3 font-medium"><?php echo e($payment->formatted_amount); ?></td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            <?php if($payment->status==='verified'): ?> bg-green-100 text-green-800
                            <?php elseif($payment->status==='uploaded'): ?> bg-blue-100 text-blue-800
                            <?php elseif($payment->status==='rejected'): ?> bg-red-100 text-red-800
                            <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->status==='verified'): ?> Lunas
                            <?php elseif($payment->status==='uploaded'): ?> Sudah Upload
                            <?php elseif($payment->status==='rejected'): ?> Ditolak
                            <?php else: ?> Pending
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->admin_notes): ?>
                            <p class="text-xs text-red-500 mt-1 max-w-[150px] truncate" title="<?php echo e($payment->admin_notes); ?>"><?php echo e($payment->admin_notes); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="px-4 py-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->payment_proof): ?>
                            <a href="<?php echo e(asset('storage/'.$payment->payment_proof)); ?>" target="_blank" class="inline-flex items-center gap-1 text-blue-600 text-sm hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat
                            </a>
                        <?php else: ?>
                            <span class="text-gray-400 text-xs italic">Belum upload</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-1 flex-wrap">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->status === 'pending'): ?>
                                <button type="button" wire:click="sendReminder(<?php echo e($payment->id); ?>)" wire:confirm="Kirim email pengingat ke <?php echo e($payment->user->name ?? 'user'); ?>?"
                                    class="px-2 py-1 text-xs font-medium bg-orange-500 text-white rounded hover:bg-orange-600 cursor-pointer">
                                    📧 Reminder
                                </button>
                            <?php elseif($payment->status === 'uploaded'): ?>
                                <button type="button" wire:click="quickVerify(<?php echo e($payment->id); ?>)" wire:confirm="Tandai pembayaran ini sebagai LUNAS?"
                                    class="px-2 py-1 text-xs font-medium bg-green-600 text-white rounded hover:bg-green-700 cursor-pointer">
                                    ✓ Lunas
                                </button>
                                <button type="button" wire:click="openRejectModal(<?php echo e($payment->id); ?>)"
                                    class="px-2 py-1 text-xs font-medium bg-red-600 text-white rounded hover:bg-red-700 cursor-pointer">
                                    ✗ Tolak
                                </button>
                            <?php elseif($payment->status === 'verified'): ?>
                                <button type="button" wire:click="resetToPending(<?php echo e($payment->id); ?>)" wire:confirm="Reset pembayaran ini ke PENDING?"
                                    class="px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded hover:bg-yellow-600 cursor-pointer">
                                    ↺ Pending
                                </button>
                            <?php elseif($payment->status === 'rejected'): ?>
                                <button type="button" wire:click="resetToPending(<?php echo e($payment->id); ?>)" wire:confirm="Reset pembayaran ini ke PENDING?"
                                    class="px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded hover:bg-yellow-600 cursor-pointer">
                                    ↺ Pending
                                </button>
                                <button type="button" wire:click="sendReminder(<?php echo e($payment->id); ?>)" wire:confirm="Kirim email pengingat ke <?php echo e($payment->user->name ?? 'user'); ?>?"
                                    class="px-2 py-1 text-xs font-medium bg-orange-500 text-white rounded hover:bg-orange-600 cursor-pointer">
                                    📧 Reminder
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->type === 'paper' && $payment->paper): ?>
                                <a href="<?php echo e(route('admin.paper.detail', $payment->paper)); ?>" class="px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-800 border border-blue-200 rounded hover:bg-blue-50">Detail</a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr><td colspan="8" class="px-4 py-12 text-center text-gray-400">Belum ada data pembayaran.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4"><?php echo e($payments->links()); ?></div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showRejectModal): ?>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">Tolak Pembayaran</h3>
                <button wire:click="closeRejectModal" type="button" class="text-gray-400 hover:text-gray-600 text-xl cursor-pointer">&times;</button>
            </div>
            <div class="p-5 space-y-4">
                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                    <p class="text-sm text-red-700">Pembayaran akan ditolak dan pengguna akan diminta upload ulang bukti bayar.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                    <textarea wire:model="adminNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-red-500 focus:border-red-500" placeholder="Contoh: Bukti bayar tidak jelas, nominal tidak sesuai..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-2 px-5 py-4 border-t border-gray-200 bg-gray-50">
                <button wire:click="rejectPayment" type="button" class="px-4 py-2 text-sm font-medium bg-red-600 text-white rounded hover:bg-red-700 cursor-pointer">
                    <span wire:loading.remove wire:target="rejectPayment">Tolak Pembayaran</span>
                    <span wire:loading wire:target="rejectPayment">Processing...</span>
                </button>
                <button wire:click="closeRejectModal" type="button" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 cursor-pointer">Batal</button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views/livewire/admin/payment-list.blade.php ENDPATH**/ ?>