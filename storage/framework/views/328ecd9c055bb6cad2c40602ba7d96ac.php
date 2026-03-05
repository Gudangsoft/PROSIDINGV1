<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Materi & Benefit</h1>
            <p class="text-gray-500 text-sm mt-1">Upload materi, PPT, dan sertifikat untuk peserta konferensi</p>
        </div>
        <button wire:click="openForm()" type="button"
            class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-medium hover:bg-teal-700 transition cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Materi
        </button>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Konferensi</label>
        <select wire:model.live="conferenceId" class="w-full max-w-md px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $conferences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <option value="<?php echo e($conf->id); ?>"><?php echo e($conf->name); ?> (<?php echo e($conf->is_active ? 'Aktif' : 'Nonaktif'); ?>)</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </select>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Judul</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Tipe</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">File</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Ukuran</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr class="hover:bg-gray-50 <?php echo e(!$mat->is_active ? 'opacity-50' : ''); ?>">
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-800"><?php echo e($mat->getTypeIcon()); ?> <?php echo e($mat->title); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mat->description): ?>
                            <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate"><?php echo e($mat->description); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            <?php if($mat->type==='sertifikat'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($mat->type==='ppt'): ?> bg-blue-100 text-blue-800
                            <?php elseif($mat->type==='materi'): ?> bg-teal-100 text-teal-800
                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                            <?php echo e($mat->getTypeLabel()); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="<?php echo e(asset('storage/'.$mat->file_path)); ?>" target="_blank"
                            class="inline-flex items-center gap-1 text-blue-600 text-xs hover:underline truncate max-w-[160px]">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <?php echo e($mat->file_name); ?>

                        </a>
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs"><?php echo e($mat->file_size ?? '-'); ?></td>
                    <td class="px-4 py-3">
                        <button wire:click="toggleActive(<?php echo e($mat->id); ?>)" type="button"
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium cursor-pointer
                            <?php echo e($mat->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>">
                            <?php echo e($mat->is_active ? 'Aktif' : 'Nonaktif'); ?>

                        </button>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-1">
                            <button wire:click="openForm(<?php echo e($mat->id); ?>)" type="button"
                                class="px-2 py-1 text-xs font-medium text-blue-600 border border-blue-200 rounded hover:bg-blue-50 cursor-pointer">Edit</button>
                            <button wire:click="delete(<?php echo e($mat->id); ?>)" wire:confirm="Hapus materi '<?php echo e($mat->title); ?>'?" type="button"
                                class="px-2 py-1 text-xs font-medium text-red-600 border border-red-200 rounded hover:bg-red-50 cursor-pointer">Hapus</button>
                        </div>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr><td colspan="6" class="px-4 py-12 text-center text-gray-400">Belum ada materi. Klik "Tambah Materi" untuk mulai upload.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showForm): ?>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-lg font-bold text-gray-800"><?php echo e($editingId ? 'Edit Materi' : 'Tambah Materi Baru'); ?></h3>
                <button wire:click="resetForm" type="button" class="text-gray-400 hover:text-gray-600 text-xl cursor-pointer">&times;</button>
            </div>
            <form wire:submit="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                    <input wire:model="title" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" placeholder="Contoh: Materi Sesi 1 — Prof. Dr. ..." />
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe <span class="text-red-500">*</span></label>
                    <select wire:model="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="materi">📄 Materi</option>
                        <option value="ppt">📊 Presentasi (PPT)</option>
                        <option value="sertifikat">🏆 Sertifikat</option>
                        <option value="lainnya">📎 Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea wire:model="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" placeholder="Keterangan singkat (opsional)"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        File <?php echo e($editingId ? '(kosongkan jika tidak diganti)' : ''); ?> <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="file" type="file" accept=".pdf,.ppt,.pptx,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png"
                        class="w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
                    <p class="text-xs text-gray-400 mt-1">Format: PDF, PPT, PPTX, DOC, DOCX, ZIP, JPG, PNG. Maks 20MB.</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input wire:model="sortOrder" type="number" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" />
                    </div>
                    <div class="flex items-center gap-2 pt-6">
                        <input wire:model="isActive" type="checkbox" id="isActive" class="rounded text-teal-600 focus:ring-teal-500" />
                        <label for="isActive" class="text-sm text-gray-700">Aktif (tampil ke peserta)</label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t">
                    <button type="submit" wire:loading.attr="disabled"
                        class="px-5 py-2 bg-teal-600 text-white rounded-lg text-sm font-medium hover:bg-teal-700 transition cursor-pointer disabled:opacity-60">
                        <span wire:loading.remove wire:target="save"><?php echo e($editingId ? 'Simpan Perubahan' : 'Upload & Simpan'); ?></span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                    <button type="button" wire:click="resetForm" class="px-4 py-2 text-gray-600 hover:text-gray-800 text-sm cursor-pointer">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\livewire\admin\material-manager.blade.php ENDPATH**/ ?>