<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Selamat Datang</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;color:#1e293b;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 16px;">
  <tr><td align="center">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

      {{-- Header --}}
      <tr>
        <td style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);padding:40px 32px;text-align:center;">
          <div style="font-size:44px;margin-bottom:12px;">🎉</div>
          <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:700;">Selamat Datang!</h1>
          <p style="margin:8px 0 0;color:rgba(255,255,255,0.85);font-size:14px;">{{ config('app.name') }}</p>
        </td>
      </tr>

      {{-- Body --}}
      <tr>
        <td style="padding:36px 32px;">

          <p style="font-size:20px;font-weight:700;margin:0 0 4px;">Halo, {{ $userName }}! 👋</p>
          <p style="margin:0 0 24px;color:#475569;font-size:15px;">
            Selamat! Akun Anda telah berhasil didaftarkan di <strong>{{ config('app.name') }}</strong>.
          </p>

          {{-- Status Box --}}
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
            <tr>
              <td style="background:#f5f3ff;border-left:4px solid #7c3aed;border-radius:0 8px 8px 0;padding:14px 18px;">
                <p style="margin:0;font-size:14px;color:#5b21b6;">
                  <strong>Status Pendaftaran:</strong>&nbsp;
                  {{ $userRole === 'author' ? 'Author / Penulis' : 'Partisipan' }}
                </p>
              </td>
            </tr>
          </table>

          {{-- Role capabilities --}}
          @if($userRole === 'author')
          <p style="margin:0 0 10px;font-size:15px;color:#1e293b;">Sebagai <strong>Author</strong>, Anda dapat:</p>
          <table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom:28px;">
            @foreach([
              'Submit paper untuk konferensi',
              'Upload revisi paper',
              'Menerima LOA (Letter of Acceptance)',
              'Melakukan pembayaran publikasi',
              'Mengunduh prosiding & sertifikat'
            ] as $item)
            <tr>
              <td width="28" style="font-size:16px;color:#7c3aed;vertical-align:top;padding-top:2px;">✓</td>
              <td style="font-size:14px;color:#334155;padding-bottom:4px;">{{ $item }}</td>
            </tr>
            @endforeach
          </table>
          @else
          <p style="margin:0 0 10px;font-size:15px;color:#1e293b;">Sebagai <strong>Partisipan</strong>, Anda dapat:</p>
          <table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom:28px;">
            @foreach([
              'Mengikuti seluruh kegiatan konferensi',
              'Mengakses materi dan panduan kegiatan',
              'Mendapatkan sertifikat partisipasi',
              'Mengunduh prosiding kegiatan'
            ] as $item)
            <tr>
              <td width="28" style="font-size:16px;color:#7c3aed;vertical-align:top;padding-top:2px;">✓</td>
              <td style="font-size:14px;color:#334155;padding-bottom:4px;">{{ $item }}</td>
            </tr>
            @endforeach
          </table>
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
            <tr>
              <td style="background:#fffbeb;border-left:4px solid #f59e0b;border-radius:0 8px 8px 0;padding:12px 16px;font-size:14px;color:#92400e;">
                ⏳ Bukti pembayaran Anda sudah diterima dan akan diverifikasi oleh admin dalam 1×24 jam.
              </td>
            </tr>
          </table>
          @endif

          {{-- CTA Button --}}
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
            <tr>
              <td align="center">
                <a href="{{ $dashboardUrl }}"
                   style="display:inline-block;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#ffffff;text-decoration:none;padding:14px 40px;border-radius:30px;font-size:15px;font-weight:700;">
                  🚀 Login ke Dashboard
                </a>
              </td>
            </tr>
          </table>

          <hr style="border:none;border-top:1px solid #e2e8f0;margin:0 0 20px;">
          <p style="margin:0 0 0;font-size:13px;color:#94a3b8;">Pertanyaan? Hubungi kami melalui halaman kontak website.</p>
          <p style="margin:16px 0 0;font-size:14px;color:#334155;">Salam hangat,<br><strong>Tim {{ config('app.name') }}</strong></p>

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
