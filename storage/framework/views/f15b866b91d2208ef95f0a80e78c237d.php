<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo e($subject ?? config('app.name')); ?></title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;color:#1e293b;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 16px;">
  <tr><td align="center">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

      
      <tr>
        <td style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);padding:36px 32px;text-align:center;">
          <div style="font-size:40px;margin-bottom:10px;"><?php echo e($icon ?? '??'); ?></div>
          <h1 style="margin:0;color:#ffffff;font-size:24px;font-weight:700;line-height:1.3;"><?php echo e($subject ?? config('app.name')); ?></h1>
          <p style="margin:8px 0 0;color:rgba(255,255,255,0.85);font-size:13px;"><?php echo e(config('app.name')); ?></p>
        </td>
      </tr>

      
      <tr>
        <td style="padding:36px 32px;font-size:15px;line-height:1.7;color:#334155;">
          <?php echo $body; ?>

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
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\emails\custom-template.blade.php ENDPATH**/ ?>