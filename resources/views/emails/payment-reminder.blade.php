<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengingat Pembayaran</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;color:#1e293b;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 16px;">
  <tr><td align="center">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

      {{-- Header --}}
      <tr>
        <td style="background:linear-gradient(135deg,#f59e0b 0%,#d97706 100%);padding:40px 32px;text-align:center;">
          <div style="font-size:44px;margin-bottom:12px;">⏰</div>
          <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:700;">Pembayaran Menunggu</h1>
          <p style="margin:8px 0 0;color:rgba(255,255,255,0.87);font-size:14px;">Segera selesaikan pembayaran Anda</p>
        </td>
      </tr>

      {{-- Body --}}
      <tr>
        <td style="padding:36px 32px;">

          <p style="font-size:20px;font-weight:700;margin:0 0 4px;">Halo, {{ $userName }}! 👋</p>
          <p style="margin:0 0 24px;color:#475569;font-size:15px;">
            Kami mengingatkan bahwa pembayaran Anda <strong>belum selesai</strong>. Selesaikan pembayaran untuk mengaktifkan akun Anda sepenuhnya.
          </p>

          {{-- Status Box --}}
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
            <tr>
              <td style="background:#fffbeb;border-left:4px solid #f59e0b;border-radius:0 8px 8px 0;padding:14px 18px;">
                <p style="margin:0;font-size:14px;color:#92400e;">
                  <strong>Status Pembayaran:</strong>&nbsp;⏳ Menunggu Bukti Transfer
                </p>
              </td>
            </tr>
          </table>

          {{-- Invoice Detail --}}
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#fffbeb;border-radius:10px;border:1px solid #fde68a;margin-bottom:24px;">
            <tr>
              <td style="padding:18px 20px;">
                <p style="margin:0 0 14px;font-size:15px;font-weight:700;color:#92400e;">Detail Tagihan</p>
                <table width="100%" cellpadding="6" cellspacing="0">
                  <tr>
                    <td style="font-size:14px;color:#78350f;width:45%;">No. Invoice</td>
                    <td style="font-size:14px;font-weight:700;font-family:monospace;color:#1e293b;">{{ $invoiceNumber }}</td>
                  </tr>
                  <tr>
                    <td style="font-size:14px;color:#78350f;">Jenis</td>
                    <td style="font-size:14px;font-weight:600;color:#1e293b;">Registrasi Peserta</td>
                  </tr>
                  <tr>
                    <td style="font-size:14px;color:#78350f;padding-top:10px;">Jumlah Tagihan</td>
                    <td style="font-size:20px;font-weight:800;color:#d97706;padding-top:10px;">{{ $amount }}</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          {{-- Steps --}}
          <p style="margin:0 0 10px;font-size:15px;font-weight:600;color:#1e293b;">Langkah yang harus dilakukan:</p>
          <table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom:28px;">
            @php $steps = [
              ['num'=>'1','title'=>'Lakukan Transfer','desc'=>'Transfer sesuai nominal tagihan ke rekening yang tertera.'],
              ['num'=>'2','title'=>'Login ke Sistem','desc'=>'Masuk menggunakan email dan password Anda.'],
              ['num'=>'3','title'=>'Upload Bukti Transfer','desc'=>'Upload foto/scan bukti transfer di menu Pembayaran pada dashboard.'],
              ['num'=>'4','title'=>'Tunggu Verifikasi','desc'=>'Admin memverifikasi dalam 1×24 jam. Anda akan mendapat email konfirmasi.'],
            ] @endphp
            @foreach($steps as $s)
            <tr>
              <td width="36" style="vertical-align:top;padding-top:4px;">
                <span style="display:inline-block;background:#d97706;color:#fff;border-radius:50%;width:22px;height:22px;text-align:center;font-size:12px;font-weight:700;line-height:22px;">{{ $s['num'] }}</span>
              </td>
              <td style="padding-bottom:10px;">
                <p style="margin:0;font-size:14px;font-weight:700;color:#1e293b;">{{ $s['title'] }}</p>
                <p style="margin:2px 0 0;font-size:13px;color:#64748b;">{{ $s['desc'] }}</p>
              </td>
            </tr>
            @endforeach
          </table>

          {{-- CTA Button --}}
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
            <tr>
              <td align="center">
                <a href="{{ $paymentUrl }}"
                   style="display:inline-block;background:linear-gradient(135deg,#f59e0b 0%,#d97706 100%);color:#ffffff;text-decoration:none;padding:14px 40px;border-radius:30px;font-size:15px;font-weight:700;">
                  💳 Login &amp; Upload Bukti Bayar
                </a>
              </td>
            </tr>
          </table>

          <hr style="border:none;border-top:1px solid #e2e8f0;margin:0 0 20px;">
          <p style="margin:0;font-size:13px;color:#94a3b8;">Butuh bantuan? Hubungi kami melalui halaman kontak website.</p>
          <p style="margin:16px 0 0;font-size:14px;color:#334155;">Terima kasih,<br><strong>Tim {{ config('app.name') }}</strong></p>

        </td>
      </tr>

      {{-- Footer --}}
      <tr>
        <td style="background:#f8fafc;padding:20px 32px;text-align:center;border-top:1px solid #e2e8f0;">
          <p style="margin:0;font-size:12px;color:#94a3b8;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
          <p style="margin:4px 0 0;font-size:11px;color:#cbd5e1;">Email ini dikirim otomatis, mohon tidak dibalas.</p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
