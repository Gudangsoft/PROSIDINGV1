<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran Terverifikasi</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;color:#1e293b;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 16px;">
  <tr><td align="center">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

      
      <tr>
        <td style="background:linear-gradient(135deg,#22c55e 0%,#16a34a 100%);padding:40px 32px;text-align:center;">
          <div style="font-size:44px;margin-bottom:12px;">✅</div>
          <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:700;">Pembayaran Lunas!</h1>
          <p style="margin:8px 0 0;color:rgba(255,255,255,0.85);font-size:14px;">Pembayaran Anda telah berhasil diverifikasi</p>
        </td>
      </tr>

      
      <tr>
        <td style="padding:36px 32px;">

          <p style="font-size:20px;font-weight:700;margin:0 0 4px;">Halo, <?php echo e($userName); ?>! 👋</p>
          <p style="margin:0 0 24px;color:#475569;font-size:15px;">
            Pembayaran Anda telah <strong>diverifikasi</strong> oleh tim <?php echo e(config('app.name')); ?>. Akun Anda sekarang <strong>aktif</strong>.
          </p>

          
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
            <tr>
              <td style="background:#f0fdf4;border-left:4px solid #16a34a;border-radius:0 8px 8px 0;padding:14px 18px;">
                <p style="margin:0;font-size:14px;color:#15803d;">
                  <strong>Status Pembayaran:</strong>&nbsp;✅ Lunas / Terverifikasi
                </p>
              </td>
            </tr>
          </table>

          
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border-radius:10px;border:1px solid #d1fae5;margin-bottom:24px;">
            <tr>
              <td style="padding:18px 20px;">
                <p style="margin:0 0 14px;font-size:15px;font-weight:700;color:#15803d;">Detail Pembayaran</p>
                <table width="100%" cellpadding="6" cellspacing="0">
                  <tr style="border-bottom:1px solid #e2e8f0;">
                    <td style="font-size:14px;color:#64748b;width:45%;">No. Invoice</td>
                    <td style="font-size:14px;font-weight:700;font-family:monospace;color:#1e293b;"><?php echo e($invoiceNumber); ?></td>
                  </tr>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentType === 'paper' && $paperTitle): ?>
                  <tr style="border-bottom:1px solid #e2e8f0;">
                    <td style="font-size:14px;color:#64748b;">Paper</td>
                    <td style="font-size:14px;font-weight:600;color:#1e293b;"><?php echo e($paperTitle); ?></td>
                  </tr>
                  <?php elseif($paymentType === 'participant'): ?>
                  <tr style="border-bottom:1px solid #e2e8f0;">
                    <td style="font-size:14px;color:#64748b;">Jenis</td>
                    <td style="font-size:14px;font-weight:600;color:#1e293b;">Registrasi Peserta</td>
                  </tr>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                  <tr>
                    <td style="font-size:14px;color:#64748b;padding-top:10px;">Jumlah Dibayar</td>
                    <td style="font-size:20px;font-weight:800;color:#16a34a;padding-top:10px;"><?php echo e($amount); ?></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          
          <p style="margin:0 0 10px;font-size:15px;font-weight:600;color:#1e293b;">Langkah selanjutnya:</p>
          <table width="100%" cellpadding="6" cellspacing="0" style="margin-bottom:28px;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentType === 'paper'): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Login ke dashboard untuk melihat status paper Anda','Tunggu proses review dari tim editorial','Unduh LOA setelah paper diterima']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php else: ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Login ke dashboard untuk akses penuh konferensi','Pantau informasi & jadwal kegiatan di dashboard','Unduh sertifikat setelah kegiatan selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <tr>
              <td width="28" style="font-size:16px;color:#16a34a;vertical-align:top;padding-top:2px;">✓</td>
              <td style="font-size:14px;color:#334155;"><?php echo e($step); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
          </table>

          
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
            <tr>
              <td align="center">
                <a href="<?php echo e($dashboardUrl); ?>"
                   style="display:inline-block;background:linear-gradient(135deg,#22c55e 0%,#16a34a 100%);color:#ffffff;text-decoration:none;padding:14px 40px;border-radius:30px;font-size:15px;font-weight:700;">
                  📊 Buka Dashboard Saya
                </a>
              </td>
            </tr>
          </table>

          
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($waGroupLink)): ?>
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
            <tr>
              <td style="background:#f0fdf4;border:2px solid #86efac;border-radius:10px;padding:20px;">
                <p style="margin:0 0 8px;font-size:15px;font-weight:700;color:#15803d;">📱 Grup WhatsApp Peserta</p>
                <p style="margin:0 0 14px;font-size:14px;color:#166534;">Bergabunglah ke grup WhatsApp untuk info terkini seputar kegiatan:</p>
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center">
                      <a href="<?php echo e($waGroupLink); ?>"
                         style="display:inline-block;background:linear-gradient(135deg,#25d366 0%,#128c7e 100%);color:#ffffff;text-decoration:none;padding:12px 30px;border-radius:30px;font-size:14px;font-weight:700;">
                        💬 Gabung Grup WhatsApp
                      </a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

          <p style="margin:0 0 4px;font-size:13px;color:#94a3b8;">
            Belum punya akses? <a href="<?php echo e($loginUrl); ?>" style="color:#16a34a;">Klik di sini untuk login</a>.
          </p>
          <hr style="border:none;border-top:1px solid #e2e8f0;margin:20px 0;">
          <p style="margin:0;font-size:14px;color:#334155;">Terima kasih,<br><strong>Tim <?php echo e(config('app.name')); ?></strong></p>

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
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\emails\payment-verified.blade.php ENDPATH**/ ?>