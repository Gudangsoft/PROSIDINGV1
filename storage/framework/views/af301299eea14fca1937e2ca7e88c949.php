<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tagihan Pembayaran</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;color:#1e293b;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 16px;">
  <tr><td align="center">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

      
      <tr>
        <td style="background:linear-gradient(135deg,#6366f1 0%,#4f46e5 100%);padding:40px 32px;text-align:center;">
          <div style="font-size:44px;margin-bottom:12px;">??</div>
          <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:700;">Tagihan Pembayaran</h1>
          <p style="margin:8px 0 0;color:rgba(255,255,255,0.85);font-size:14px;">Invoice baru telah dibuat untuk Anda</p>
        </td>
      </tr>

      
      <tr>
        <td style="padding:36px 32px;">

          <p style="font-size:20px;font-weight:700;margin:0 0 4px;">Halo, <?php echo e($userName); ?>! ??</p>
          <p style="margin:0 0 24px;color:#475569;font-size:15px;">
            Tagihan pembayaran telah dibuat. Silakan selesaikan pembayaran sesuai nominal di bawah ini.
          </p>

          
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
            <tr>
              <td style="background:#eef2ff;border-left:4px solid #6366f1;border-radius:0 8px 8px 0;padding:14px 18px;">
                <p style="margin:0;font-size:14px;color:#3730a3;">
                  <strong>Status Invoice:</strong>&nbsp;?? Menunggu Pembayaran
                </p>
              </td>
            </tr>
          </table>

          
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border-radius:10px;border:1px solid #c7d2fe;margin-bottom:24px;">
            <tr>
              <td style="padding:18px 20px;">
                <p style="margin:0 0 14px;font-size:15px;font-weight:700;color:#3730a3;">Detail Invoice</p>
                <table width="100%" cellpadding="6" cellspacing="0">
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paperTitle): ?>
                  <tr>
                    <td style="font-size:14px;color:#64748b;width:45%;">Paper</td>
                    <td style="font-size:14px;font-weight:600;color:#1e293b;"><?php echo e($paperTitle); ?></td>
                  </tr>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                  <tr>
                    <td style="font-size:14px;color:#64748b;">No. Invoice</td>
                    <td style="font-size:14px;font-weight:700;font-family:monospace;color:#1e293b;"><?php echo e($invoiceNumber); ?></td>
                  </tr>
                  <tr>\n                    <td style="font-size:14px;color:#64748b;padding-top:10px;">Jumlah Tagihan</td>\n                    <td style="font-size:20px;font-weight:800;color:#4f46e5;padding-top:10px;"><?php echo e($amount); ?></td>\n                  </tr>
                </table>
              </td>
            </tr>
          </table>

          
          <p style="margin:0 0 10px;font-size:15px;font-weight:600;color:#1e293b;">Cara melakukan pembayaran:</p>
          <table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom:28px;">
            <?php $steps = [
              ['num'=>'1','title'=>'Transfer Sesuai Nominal','desc'=>'Lihat rekening tujuan di halaman pembayaran.'],
              ['num'=>'2','title'=>'Simpan Bukti Transfer','desc'=>'Ambil foto atau screenshot bukti transfer Anda.'],
              ['num'=>'3','title'=>'Upload Bukti di Dashboard','desc'=>'Login dan upload bukti pembayaran melalui tombol di bawah.'],
              ['num'=>'4','title'=>'Tunggu Konfirmasi','desc'=>'Admin akan memverifikasi dan Anda mendapat email konfirmasi.'],
            ] ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr>
              <td width="36" style="vertical-align:top;padding-top:4px;">
                <span style="display:inline-block;background:#4f46e5;color:#fff;border-radius:50%;width:22px;height:22px;text-align:center;font-size:12px;font-weight:700;line-height:22px;"><?php echo e($s['num']); ?></span>
              </td>
              <td style="padding-bottom:10px;">
                <p style="margin:0;font-size:14px;font-weight:700;color:#1e293b;"><?php echo e($s['title']); ?></p>
                <p style="margin:2px 0 0;font-size:13px;color:#64748b;"><?php echo e($s['desc']); ?></p>
              </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
          </table>

          
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
            <tr>
              <td align="center">
                <a href="<?php echo e($paymentUrl); ?>"
                   style="display:inline-block;background:linear-gradient(135deg,#6366f1 0%,#4f46e5 100%);color:#ffffff;text-decoration:none;padding:14px 40px;border-radius:30px;font-size:15px;font-weight:700;">
                  ?? Lihat &amp; Bayar Invoice
                </a>
              </td>
            </tr>
          </table>

          <hr style="border:none;border-top:1px solid #e2e8f0;margin:0 0 20px;">
          <p style="margin:0;font-size:13px;color:#94a3b8;">Pastikan melakukan pembayaran sebelum batas waktu yang ditentukan.</p>
          <p style="margin:16px 0 0;font-size:14px;color:#334155;">Terima kasih,<br><strong>Tim <?php echo e(config('app.name')); ?></strong></p>

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
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\emails\invoice-created.blade.php ENDPATH**/ ?>