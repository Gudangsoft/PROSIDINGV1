<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kegiatan Baru</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;color:#1e293b;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 16px;">
  <tr><td align="center">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

      
      <tr>
        <td style="background:linear-gradient(135deg,#0ea5e9 0%,#0284c7 100%);padding:40px 32px;text-align:center;">
          <div style="font-size:44px;margin-bottom:12px;">??</div>
          <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:700;">Kegiatan Baru!</h1>
          <p style="margin:8px 0 0;color:rgba(255,255,255,0.85);font-size:14px;"><?php echo e(config('app.name')); ?></p>
        </td>
      </tr>

      
      <tr>
        <td style="padding:36px 32px;">

          <p style="font-size:20px;font-weight:700;margin:0 0 4px;">Halo, <?php echo e($userName); ?>! ??</p>
          <p style="margin:0 0 24px;color:#475569;font-size:15px;">
            Kami dengan senang hati mengumumkan kegiatan baru yang telah dipublikasikan!
          </p>

          
          <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#e0f2fe 0%,#bae6fd 100%);border-radius:10px;border:1px solid #7dd3fc;margin-bottom:24px;">
            <tr>
              <td style="padding:20px 22px;">
                <p style="margin:0 0 10px;font-size:17px;font-weight:800;color:#0c4a6e;"><?php echo e($eventName); ?></p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($eventDate): ?>
                <p style="margin:0 0 6px;font-size:14px;color:#075985;">?? <strong>Tanggal:</strong> <?php echo e($eventDate); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($conferenceVenue)): ?>
                <p style="margin:0;font-size:14px;color:#075985;">?? <strong>Lokasi:</strong> <?php echo e($conferenceVenue); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </td>
            </tr>
          </table>

          
          <p style="margin:0 0 10px;font-size:15px;font-weight:600;color:#1e293b;">Manfaat mengikuti kegiatan:</p>
          <table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom:28px;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
              'Publikasi paper di prosiding berindeks',
              'Networking dengan para akademisi & praktisi',
              'Sertifikat keikutsertaan resmi',
              'Akses materi dan rekaman kegiatan',
              'Pengembangan profesional & karir akademik'
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr>
              <td width="28" style="font-size:16px;color:#0284c7;vertical-align:top;padding-top:2px;">?</td>
              <td style="font-size:14px;color:#334155;padding-bottom:4px;"><?php echo e($item); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
          </table>

          
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
            <tr>
              <td align="center">
                <a href="<?php echo e($eventUrl); ?>"
                   style="display:inline-block;background:linear-gradient(135deg,#0ea5e9 0%,#0284c7 100%);color:#ffffff;text-decoration:none;padding:14px 40px;border-radius:30px;font-size:15px;font-weight:700;">
                  ?? Lihat Detail &amp; Daftar
                </a>
              </td>
            </tr>
          </table>

          <hr style="border:none;border-top:1px solid #e2e8f0;margin:0 0 20px;">
          <p style="margin:0;font-size:13px;color:#94a3b8;">Segera daftarkan diri sebelum kuota penuh.</p>
          <p style="margin:16px 0 0;font-size:14px;color:#334155;">Salam,<br><strong>Tim <?php echo e(config('app.name')); ?></strong></p>

        </td>
      </tr>

      
      <tr>
        <td style="background:#f8fafc;padding:20px 32px;text-align:center;border-top:1px solid #e2e8f0;">
          <p style="margin:0;font-size:12px;color:#94a3b8;">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</p>
          <p style="margin:4px 0 0;font-size:11px;color:#cbd5e1;">Email ini dikirim otomatis, mohon tidak dibalas.</p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\emails\new-event.blade.php ENDPATH**/ ?>