<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Panduan — {{ \App\Models\Setting::getValue('site_name', 'Sistem Prosiding') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 11pt; }
            .page-break { page-break-before: always; }
            a { color: inherit !important; text-decoration: none !important; }
        }
        body { font-family: 'Segoe UI', sans-serif; }
        .toc-entry:hover { background: #eff6ff; }
        .step-num {
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; flex-shrink: 0;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

{{-- ─── TOP BAR (no-print) ──────────────────────────────────── --}}
<div class="no-print sticky top-0 bg-white border-b border-gray-200 shadow-sm z-50 px-6 py-3 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard
        </a>
        <span class="text-gray-300">|</span>
        <span class="text-sm font-semibold text-gray-700">📖 Buku Panduan Sistem</span>
    </div>
    <button onclick="window.print()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Cetak / Simpan PDF
    </button>
</div>

<div class="max-w-4xl mx-auto px-6 py-10">

{{-- ═══════════════════════════════════════════════════════════
     COVER PAGE
════════════════════════════════════════════════════════════ --}}
<div class="bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 rounded-2xl text-white px-10 py-16 mb-10 text-center shadow-xl">
    @php
        $siteName = \App\Models\Setting::getValue('site_name', 'Sistem Prosiding');
        $siteLogo = \App\Models\Setting::getValue('site_logo');
        $activeConf = null;
        try { $activeConf = \App\Models\Conference::where('is_active', true)->first(); } catch(\Throwable $e){}
    @endphp
    @if($siteLogo)
    <img src="{{ asset('storage/'.$siteLogo) }}" alt="Logo" class="h-20 w-20 object-contain rounded-2xl mx-auto mb-6 bg-white/20 p-2">
    @else
    <div class="w-20 h-20 bg-white/20 rounded-2xl mx-auto mb-6 flex items-center justify-center">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
    </div>
    @endif
    <p class="text-blue-200 text-sm font-semibold uppercase tracking-widest mb-2">Buku Panduan Pengguna</p>
    <h1 class="text-4xl font-black mb-3">{{ $siteName }}</h1>
    @if($activeConf)
    <p class="text-blue-100 text-lg font-medium mb-1">{{ $activeConf->title }}</p>
    @endif
    <p class="text-blue-200 text-sm mt-4">{{ url('/') }}</p>
    <div class="mt-8 flex flex-wrap justify-center gap-3 text-sm">
        <span class="bg-white/15 px-4 py-1.5 rounded-full">✍️ Pemakalah (Author)</span>
        <span class="bg-white/15 px-4 py-1.5 rounded-full">🎟️ Peserta</span>
        <span class="bg-white/15 px-4 py-1.5 rounded-full">🔍 Reviewer</span>
        <span class="bg-white/15 px-4 py-1.5 rounded-full">⚙️ Admin / Editor</span>
    </div>
    <p class="text-blue-300 text-xs mt-8">Dicetak: {{ now()->isoFormat('D MMMM Y') }}</p>
</div>

{{-- ═══════════════════════════════════════════════════════════
     DAFTAR ISI
════════════════════════════════════════════════════════════ --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-7 mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-5 flex items-center gap-2">
        <span class="w-8 h-8 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center text-sm font-black">≡</span>
        Daftar Isi
    </h2>
    <div class="space-y-1 text-sm">
        <a href="#sec-overview" class="toc-entry flex items-center justify-between px-3 py-2 rounded-lg transition text-gray-700">
            <span>1. Gambaran Umum Sistem</span><span class="text-gray-400">Halaman ini</span>
        </a>
        <a href="#sec-register" class="toc-entry flex items-center justify-between px-3 py-2 rounded-lg transition text-gray-700">
            <span>2. Cara Mendaftar & Login</span><span class="text-gray-400">Semua pengguna</span>
        </a>
        <a href="#sec-author" class="toc-entry flex items-center justify-between px-3 py-2 rounded-lg transition text-gray-700">
            <span class="font-semibold text-blue-700">3. Dashboard Pemakalah (Author)</span><span class="text-gray-400">✍️</span>
        </a>
        <a href="#sec-author-paper" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>3.1 Submit & Kelola Paper</span>
        </a>
        <a href="#sec-author-payment" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>3.2 Pembayaran & Upload Bukti</span>
        </a>
        <a href="#sec-author-deliverable" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>3.3 Upload Berkas / Deliverables</span>
        </a>
        <a href="#sec-author-video" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>3.4 Submit Video Presentasi</span>
        </a>
        <a href="#sec-author-loa" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>3.5 Download LOA & Sertifikat</span>
        </a>
        <a href="#sec-participant" class="toc-entry flex items-center justify-between px-3 py-2 rounded-lg transition text-gray-700">
            <span class="font-semibold text-teal-700">4. Dashboard Peserta (Participant)</span><span class="text-gray-400">🎟️</span>
        </a>
        <a href="#sec-reviewer" class="toc-entry flex items-center justify-between px-3 py-2 rounded-lg transition text-gray-700">
            <span class="font-semibold text-indigo-700">5. Dashboard Reviewer</span><span class="text-gray-400">🔍</span>
        </a>
        <a href="#sec-admin" class="toc-entry flex items-center justify-between px-3 py-2 rounded-lg transition text-gray-700">
            <span class="font-semibold text-red-700">6. Dashboard Admin / Editor</span><span class="text-gray-400">⚙️</span>
        </a>
        <a href="#sec-admin-conference" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>6.1 Kelola Konferensi</span>
        </a>
        <a href="#sec-admin-paper" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>6.2 Kelola Paper & Review</span>
        </a>
        <a href="#sec-admin-payment" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>6.3 Verifikasi Pembayaran</span>
        </a>
        <a href="#sec-admin-cert" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>6.4 Generate LOA & Sertifikat</span>
        </a>
        <a href="#sec-admin-content" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>6.5 Kelola Konten & Pengumuman</span>
        </a>
        <a href="#sec-admin-users" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>6.6 Kelola Pengguna & Impersonasi</span>
        </a>
        <a href="#sec-admin-settings" class="toc-entry flex items-center justify-between px-3 py-2 pl-8 rounded-lg transition text-gray-600">
            <span>6.7 Pengaturan Sistem</span>
        </a>
        <a href="#sec-helpdesk" class="toc-entry flex items-center justify-between px-3 py-2 rounded-lg transition text-gray-700">
            <span>7. Helpdesk & Bantuan</span>
        </a>
        <a href="#sec-verify" class="toc-entry flex items-center justify-between px-3 py-2 rounded-lg transition text-gray-700">
            <span>8. Verifikasi Dokumen (LOA / Sertifikat)</span>
        </a>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     SECTION HELPER MACRO
════════════════════════════════════════════════════════════ --}}
@php
function stepItem(string $n, string $text): string {
    $colors = ['1'=>'bg-blue-600','2'=>'bg-blue-600','3'=>'bg-blue-600','4'=>'bg-blue-600','5'=>'bg-blue-600'];
    return '<div class="flex gap-3 items-start">
        <div class="step-num bg-blue-600 text-white mt-0.5">'.$n.'</div>
        <p class="text-gray-700 text-sm leading-relaxed pt-1">'.$text.'</p>
    </div>';
}
@endphp

{{-- ═══════════════════════════════════════════════════════════
     1. GAMBARAN UMUM
════════════════════════════════════════════════════════════ --}}
<div id="sec-overview" class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-7 mb-6">
    <div class="flex items-center gap-3 mb-5">
        <span class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black text-lg">1</span>
        <h2 class="text-xl font-bold text-gray-800">Gambaran Umum Sistem</h2>
    </div>
    <p class="text-gray-600 text-sm leading-relaxed mb-5">
        <strong>{{ $siteName }}</strong> adalah platform manajemen prosiding konferensi ilmiah yang mengelola seluruh proses mulai dari pendaftaran peserta, pengiriman dan review paper, pembayaran registrasi, hingga penerbitan sertifikat dan prosiding digital.
    </p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-center">
            <div class="text-2xl mb-1">✍️</div>
            <p class="text-sm font-bold text-blue-800">Pemakalah</p>
            <p class="text-xs text-blue-600 mt-1">Submit & presentasi paper ilmiah</p>
        </div>
        <div class="bg-teal-50 border border-teal-100 rounded-xl p-4 text-center">
            <div class="text-2xl mb-1">🎟️</div>
            <p class="text-sm font-bold text-teal-800">Peserta</p>
            <p class="text-xs text-teal-600 mt-1">Daftar & akses materi konferensi</p>
        </div>
        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 text-center">
            <div class="text-2xl mb-1">🔍</div>
            <p class="text-sm font-bold text-indigo-800">Reviewer</p>
            <p class="text-xs text-indigo-600 mt-1">Menilai paper yang masuk</p>
        </div>
        <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center">
            <div class="text-2xl mb-1">⚙️</div>
            <p class="text-sm font-bold text-red-800">Admin / Editor</p>
            <p class="text-xs text-red-600 mt-1">Mengelola seluruh sistem</p>
        </div>
    </div>
    <div class="mt-5 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
        <p class="text-sm text-yellow-800"><strong>URL Sistem:</strong> <a href="{{ url('/') }}" class="text-blue-600 underline">{{ url('/') }}</a></p>
        <p class="text-sm text-yellow-800 mt-1"><strong>Halaman Login:</strong> <a href="{{ url('/login') }}" class="text-blue-600 underline">{{ url('/login') }}</a></p>
        <p class="text-sm text-yellow-800 mt-1"><strong>Halaman Daftar:</strong> <a href="{{ url('/register') }}" class="text-blue-600 underline">{{ url('/register') }}</a></p>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     2. REGISTRASI & LOGIN
════════════════════════════════════════════════════════════ --}}
<div id="sec-register" class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-7 mb-6">
    <div class="flex items-center gap-3 mb-5">
        <span class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black text-lg">2</span>
        <h2 class="text-xl font-bold text-gray-800">Cara Mendaftar & Login</h2>
    </div>

    <h3 class="font-semibold text-gray-700 mb-3 mt-1">Pendaftaran Akun Baru</h3>
    <div class="space-y-3 mb-6">
        <div class="flex gap-3 items-start"><div class="step-num bg-blue-600 text-white mt-0.5">1</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Buka halaman utama website, klik tombol <strong>Register</strong> di pojok kanan atas navigasi.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-blue-600 text-white mt-0.5">2</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Isi formulir: <strong>Nama Lengkap</strong> (sesuai ijazah), <strong>Email</strong>, <strong>Institusi</strong>, <strong>Nomor HP/WhatsApp</strong>, <strong>Password</strong> (min. 8 karakter), lalu konfirmasi password.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-blue-600 text-white mt-0.5">3</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Pilih <strong>Peran</strong>: <em>Pemakalah (Author)</em> atau <em>Peserta (Participant)</em>. Akun Reviewer dan Admin dibuat oleh panitia.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-blue-600 text-white mt-0.5">4</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Klik <strong>Daftar</strong>. Anda akan langsung diarahkan ke Dashboard sesuai peran yang dipilih.</p></div>
    </div>

    <h3 class="font-semibold text-gray-700 mb-3">Login ke Sistem</h3>
    <div class="space-y-3 mb-5">
        <div class="flex gap-3 items-start"><div class="step-num bg-blue-600 text-white mt-0.5">1</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Kunjungi <a href="{{ url('/login') }}" class="text-blue-600 underline">{{ url('/login') }}</a>.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-blue-600 text-white mt-0.5">2</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Masukkan <strong>Email</strong> dan <strong>Password</strong> yang terdaftar, lalu klik <strong>Masuk</strong>.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-blue-600 text-white mt-0.5">3</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Jika lupa password, klik <strong>Lupa Password?</strong> — masukkan email dan ikuti instruksi yang dikirim ke email Anda.</p></div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <p class="text-sm text-blue-800"><strong>💡 Tips Keamanan:</strong> Jangan gunakan password yang sama dengan akun lain. Segera ganti password bawaan (untuk akun yang dibuat admin) melalui menu <strong>Edit Profile → Ganti Password</strong>.</p>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     3. DASHBOARD AUTHOR
════════════════════════════════════════════════════════════ --}}
<div id="sec-author" class="bg-white rounded-2xl shadow-sm border border-blue-100 px-8 py-7 mb-6">
    <div class="flex items-center gap-3 mb-2">
        <span class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black text-lg">3</span>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Dashboard Pemakalah (Author)</h2>
            <p class="text-sm text-blue-600">Panduan lengkap untuk mempresentasikan paper di konferensi</p>
        </div>
    </div>

    <div class="mt-5 bg-blue-50 rounded-xl p-4 text-sm text-blue-800 mb-6">
        <strong>Alur Pemakalah:</strong>
        <div class="flex items-center gap-2 mt-2 flex-wrap text-xs font-semibold">
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">① Submit Paper</span>
            <span class="text-blue-400">→</span>
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">② Proses Review</span>
            <span class="text-blue-400">→</span>
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">③ Pembayaran</span>
            <span class="text-blue-400">→</span>
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">④ Upload Berkas</span>
            <span class="text-blue-400">→</span>
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">⑤ Submit Video</span>
            <span class="text-blue-400">→</span>
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">⑥ Download LOA & Sertifikat</span>
        </div>
    </div>

    {{-- 3.1 Submit Paper --}}
    <div id="sec-author-paper" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-blue-100 text-blue-700 rounded-md flex items-center justify-center text-xs font-black">3.1</span>
            Submit & Kelola Paper
        </h3>
        <div class="space-y-3 mb-4">
            <div class="flex gap-3 items-start"><div class="step-num bg-blue-500 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Di sidebar kiri, klik menu <strong>Submit Paper</strong> untuk membuat pengiriman baru.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-blue-500 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Isi <strong>Judul Paper</strong>, <strong>Abstrak</strong> (minimal 150 kata), <strong>Kata Kunci</strong> (pisahkan dengan koma), dan <strong>Topik/Bidang Ilmu</strong>.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-blue-500 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Isi <strong>Nama Penulis</strong> dan co-authors. Pastikan nama sesuai ejaan yang diinginkan di sertifikat.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-blue-500 text-white mt-0.5 text-xs">4</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Upload file paper sesuai format yang ditentukan panitia (biasanya <strong>.docx</strong> atau <strong>.pdf</strong>). Pastikan menggunakan template resmi yang tersedia.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-blue-500 text-white mt-0.5 text-xs">5</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Klik <strong>Submit Paper</strong>. Status akan berubah ke <span class="bg-yellow-100 text-yellow-700 px-1.5 rounded text-xs font-semibold">Submitted</span>.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-blue-500 text-white mt-0.5 text-xs">6</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Pantau status di menu <strong>Paper Saya</strong>. Jika ada catatan revisi, unggah ulang file paper yang sudah diperbaiki.</p></div>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
            <p class="text-xs font-bold text-gray-500 uppercase mb-2">Status Paper</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                <span class="bg-yellow-100 text-yellow-800 px-2 py-1.5 rounded-lg font-medium">⏳ Submitted — Menunggu review</span>
                <span class="bg-blue-100 text-blue-800 px-2 py-1.5 rounded-lg font-medium">🔍 Under Review — Sedang dinilai</span>
                <span class="bg-orange-100 text-orange-800 px-2 py-1.5 rounded-lg font-medium">✏️ Revision Required — Perlu revisi</span>
                <span class="bg-green-100 text-green-800 px-2 py-1.5 rounded-lg font-medium">✅ Accepted — Diterima</span>
                <span class="bg-red-100 text-red-800 px-2 py-1.5 rounded-lg font-medium">❌ Rejected — Ditolak</span>
                <span class="bg-purple-100 text-purple-800 px-2 py-1.5 rounded-lg font-medium">💳 Payment Verified — Lunas</span>
            </div>
        </div>
    </div>

    {{-- 3.2 Pembayaran --}}
    <div id="sec-author-payment" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-blue-100 text-blue-700 rounded-md flex items-center justify-center text-xs font-black">3.2</span>
            Pembayaran Registrasi
        </h3>
        <p class="text-sm text-gray-600 mb-3">Dilakukan setelah paper berstatus <span class="bg-green-100 text-green-700 px-1.5 rounded text-xs font-semibold">Accepted</span>.</p>
        <div class="space-y-3 mb-4">
            <div class="flex gap-3 items-start"><div class="step-num bg-green-600 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Buka menu <strong>LOA & Tagihan</strong> di sidebar. Informasi tagihan dan rekening tujuan transfer tertera di halaman ini.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-green-600 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Lakukan transfer sesuai nominal yang tertera. Pastikan nominal tepat agar verifikasi lebih cepat.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-green-600 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Dari detail paper, klik tombol <strong>Upload Bukti Bayar</strong>. Upload foto/scan bukti transfer (JPG, PNG, atau PDF, maks. 5 MB).</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-green-600 text-white mt-0.5 text-xs">4</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Pilih metode pembayaran yang digunakan, lalu klik <strong>Upload Pembayaran</strong>. Tunggu verifikasi panitia (1–2 hari kerja).</p></div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 text-xs text-yellow-800">
            <strong>⚠️ Penting:</strong> Simpan bukti transfer sampai konferensi selesai. Jangan upload ulang jika sudah menunggu verifikasi — hubungi panitia melalui Helpdesk jika lebih dari 2 hari belum terverifikasi.
        </div>
    </div>

    {{-- 3.3 Deliverables --}}
    <div id="sec-author-deliverable" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-blue-100 text-blue-700 rounded-md flex items-center justify-center text-xs font-black">3.3</span>
            Upload Berkas Pendukung (Deliverables)
        </h3>
        <p class="text-sm text-gray-600 mb-3">Dilakukan setelah pembayaran terverifikasi. Buka detail paper lalu klik <strong>Upload Berkas</strong>.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4 text-sm">
            <div class="border border-gray-200 rounded-xl p-3">
                <p class="font-semibold text-gray-700 mb-1">📄 Paper Final</p>
                <p class="text-xs text-gray-500">Versi akhir setelah revisi. Format: PDF/DOCX</p>
            </div>
            <div class="border border-gray-200 rounded-xl p-3">
                <p class="font-semibold text-gray-700 mb-1">📊 Slide Presentasi</p>
                <p class="text-xs text-gray-500">File PPT/PPTX atau PDF slide</p>
            </div>
            <div class="border border-gray-200 rounded-xl p-3">
                <p class="font-semibold text-gray-700 mb-1">🖼️ Poster</p>
                <p class="text-xs text-gray-500">Jika diminta. Format: PDF/PNG</p>
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex gap-3 items-start"><div class="step-num bg-blue-500 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 pt-1">Buka <strong>Paper Saya</strong> → klik paper → klik <strong>Upload Berkas</strong>.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-blue-500 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 pt-1">Upload setiap file sesuai jenisnya. Klik <strong>Upload</strong> untuk masing-masing file.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-blue-500 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 pt-1">Perhatikan <strong>batas waktu pengumpulan</strong> yang tertera di halaman Tanggal Penting.</p></div>
        </div>
    </div>

    {{-- 3.4 Video --}}
    <div id="sec-author-video" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-red-100 text-red-700 rounded-md flex items-center justify-center text-xs font-black">3.4</span>
            Submit Video Presentasi
        </h3>
        <div class="space-y-3">
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Rekam video presentasi Anda. Durasi yang disarankan: <strong>10–15 menit</strong>. Sertakan slide di video.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Upload video ke <strong>YouTube</strong>. Atur visibilitas ke <em>Unlisted</em> (tidak publik, hanya yang punya link) atau <em>Public</em>.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Dari Dashboard, buka menu <strong>Video Pemaparan</strong> di sidebar. Temukan paper yang sesuai.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">4</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Tempelkan URL YouTube di kolom yang tersedia, lalu klik <strong>Simpan URL Video</strong>.</p></div>
        </div>
    </div>

    {{-- 3.5 LOA & Sertifikat --}}
    <div id="sec-author-loa" class="mb-2">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-yellow-100 text-yellow-700 rounded-md flex items-center justify-center text-xs font-black">3.5</span>
            Download LOA & Sertifikat
        </h3>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="border border-green-200 rounded-xl p-4">
                <p class="font-bold text-green-800 mb-2">📋 Letter of Acceptance (LOA)</p>
                <ol class="text-xs text-gray-600 space-y-1 list-decimal list-inside">
                    <li>Buka menu <strong>LOA & Tagihan</strong> di sidebar.</li>
                    <li>Klik tombol <strong>Download LOA</strong>.</li>
                    <li>LOA diterbitkan setelah paper diterima & pembayaran terverifikasi.</li>
                    <li>Scan QR Code di LOA untuk verifikasi keaslian dokumen.</li>
                </ol>
            </div>
            <div class="border border-yellow-200 rounded-xl p-4">
                <p class="font-bold text-yellow-800 mb-2">🏅 Sertifikat</p>
                <ol class="text-xs text-gray-600 space-y-1 list-decimal list-inside">
                    <li>Buka menu <strong>Sertifikat</strong> di sidebar.</li>
                    <li>Sertifikat tersedia setelah konferensi selesai dan diterbitkan panitia.</li>
                    <li>Klik <strong>Download</strong> untuk mengunduh PDF sertifikat.</li>
                    <li>Setiap sertifikat memiliki nomor unik + QR Code verifikasi.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     4. DASHBOARD PARTICIPANT
════════════════════════════════════════════════════════════ --}}
<div id="sec-participant" class="bg-white rounded-2xl shadow-sm border border-teal-100 px-8 py-7 mb-6">
    <div class="flex items-center gap-3 mb-5">
        <span class="w-9 h-9 bg-teal-600 text-white rounded-xl flex items-center justify-center font-black text-lg">4</span>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Dashboard Peserta (Participant)</h2>
            <p class="text-sm text-teal-600">Daftar, bayar, akses materi, dan unduh sertifikat kehadiran</p>
        </div>
    </div>

    <div class="mt-2 bg-teal-50 rounded-xl p-4 text-sm text-teal-800 mb-6">
        <strong>Alur Peserta:</strong>
        <div class="flex items-center gap-2 mt-2 flex-wrap text-xs font-semibold">
            <span class="bg-teal-200 text-teal-800 px-2 py-1 rounded">① Daftar & Login</span>
            <span class="text-teal-400">→</span>
            <span class="bg-teal-200 text-teal-800 px-2 py-1 rounded">② Bayar Registrasi</span>
            <span class="text-teal-400">→</span>
            <span class="bg-teal-200 text-teal-800 px-2 py-1 rounded">③ Akses Materi</span>
            <span class="text-teal-400">→</span>
            <span class="bg-teal-200 text-teal-800 px-2 py-1 rounded">④ Download Sertifikat</span>
        </div>
    </div>

    <div class="space-y-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2"><span class="text-teal-600 font-black">My Information</span> — Data Profil Peserta</h3>
            <p class="text-sm text-gray-600">Buka menu <strong>My Information</strong> untuk melihat dan memperbarui data pendaftaran Anda. Pastikan nama dan institusi sesuai agar sertifikat diterbitkan dengan benar.</p>
        </div>
        <div>
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2"><span class="text-teal-600 font-black">Payment</span> — Upload Bukti Pembayaran</h3>
            <div class="space-y-2">
                <div class="flex gap-3 items-start"><div class="step-num bg-teal-600 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 pt-1">Buka menu <strong>Payment</strong>. Informasi paket registrasi dan rekening tujuan tertera di halaman ini.</p></div>
                <div class="flex gap-3 items-start"><div class="step-num bg-teal-600 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 pt-1">Transfer sesuai nominal, lalu klik <strong>Upload Bukti Pembayaran</strong>. Upload file bukti transfer (JPG/PNG/PDF, maks. 5MB).</p></div>
                <div class="flex gap-3 items-start"><div class="step-num bg-teal-600 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 pt-1">Tunggu verifikasi panitia 1–2 hari kerja. Notifikasi akan dikirim via email.</p></div>
            </div>
        </div>
        <div>
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2"><span class="text-teal-600 font-black">Materials & Certificates</span> — Materi & Sertifikat</h3>
            <p class="text-sm text-gray-600 mb-2">Setelah pembayaran terverifikasi, Anda dapat mengakses:</p>
            <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside ml-2">
                <li>Materi Keynote Speaker (slide/video)</li>
                <li>Prosiding dan kumpulan paper peserta</li>
                <li>Sertifikat kehadiran (tersedia pasca konferensi)</li>
            </ul>
            <p class="text-sm text-gray-600 mt-2">Klik <strong>Download</strong> pada setiap item untuk mengunduh. Sertifikat dilengkapi QR Code untuk verifikasi keaslian.</p>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     5. DASHBOARD REVIEWER
════════════════════════════════════════════════════════════ --}}
<div id="sec-reviewer" class="bg-white rounded-2xl shadow-sm border border-indigo-100 px-8 py-7 mb-6">
    <div class="flex items-center gap-3 mb-5">
        <span class="w-9 h-9 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-black text-lg">5</span>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Dashboard Reviewer</h2>
            <p class="text-sm text-indigo-600">Akun Reviewer dibuat oleh Admin — cek email untuk kredensial</p>
        </div>
    </div>

    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 text-sm text-indigo-800 mb-6">
        <strong>Catatan:</strong> Akun reviewer tidak dapat didaftarkan sendiri. Admin yang akan membuat akun dan mengirimkan kredensial login melalui email.
    </div>

    <h3 class="font-semibold text-gray-700 mb-3">Melakukan Review Paper</h3>
    <div class="space-y-3 mb-5">
        <div class="flex gap-3 items-start"><div class="step-num bg-indigo-600 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Login menggunakan email dan password yang diberikan Admin. Segera <strong>ganti password</strong> melalui menu <strong>Edit Profile</strong>.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-indigo-600 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Buka menu <strong>Tugas Review</strong> di sidebar. Daftar paper yang ditugaskan kepada Anda akan tampil beserta deadline review.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-indigo-600 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Klik judul paper → klik <strong>Download Paper</strong> untuk mengunduh dan membaca paper.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-indigo-600 text-white mt-0.5 text-xs">4</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Isi formulir review: berikan skor untuk setiap aspek penilaian, tulis komentar/saran detail untuk penulis.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-indigo-600 text-white mt-0.5 text-xs">5</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Pilih rekomendasi keputusan: <strong>Accept</strong> / <strong>Minor Revision</strong> / <strong>Major Revision</strong> / <strong>Reject</strong>, lalu klik <strong>Simpan Review</strong>.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-indigo-600 text-white mt-0.5 text-xs">6</div><p class="text-sm text-gray-700 leading-relaxed pt-1">Hasil review akan dikirimkan ke editor dan penulis secara otomatis. Review yang sudah disimpan tidak dapat diubah kecuali diminta editor.</p></div>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 text-xs text-yellow-800">
        <strong>⚠️ Kerahasiaan:</strong> Identitas reviewer bersifat rahasia (double-blind review). Jangan mengungkapkan identitas Anda kepada penulis paper yang Anda review.
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     6. DASHBOARD ADMIN / EDITOR
════════════════════════════════════════════════════════════ --}}
<div id="sec-admin" class="bg-white rounded-2xl shadow-sm border border-red-100 px-8 py-7 mb-6">
    <div class="flex items-center gap-3 mb-5">
        <span class="w-9 h-9 bg-red-600 text-white rounded-xl flex items-center justify-center font-black text-lg">6</span>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Dashboard Admin / Editor</h2>
            <p class="text-sm text-red-600">Panduan lengkap pengelolaan sistem konferensi</p>
        </div>
    </div>

    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-800 mb-6">
        <strong>Perbedaan Admin vs Editor:</strong> Admin memiliki akses penuh ke semua menu termasuk manajemen pengguna, pengaturan sistem, dan database. Editor hanya dapat mengelola Paper, Pembayaran, dan Konferensi.
    </div>

    {{-- 6.1 Konferensi --}}
    <div id="sec-admin-conference" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-red-100 text-red-700 rounded-md flex items-center justify-center text-xs font-black">6.1</span>
            Kelola Konferensi — Menu: Kegiatan Prosiding
        </h3>
        <div class="space-y-2 mb-3">
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 pt-1">Buka <strong>Kegiatan Prosiding</strong> → klik <strong>+ Tambah Konferensi</strong>. Isi: nama, akronim, deskripsi, tanggal, lokasi, status (Draft/Published).</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 pt-1">Aktifkan toggle <strong>Konferensi Aktif</strong> untuk menjadikannya konferensi utama saat ini. Hanya 1 konferensi yang aktif pada satu waktu.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 pt-1">Tambahkan <strong>Tanggal Penting</strong> (deadline submit, pengumuman, batas bayar, dll.) di tab Tanggal Penting.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">4</div><p class="text-sm text-gray-700 pt-1">Tambahkan <strong>Keynote Speaker</strong>, <strong>Topik</strong>, dan <strong>Paket Registrasi</strong> di tab masing-masing.</p></div>
        </div>
    </div>

    {{-- 6.2 Paper --}}
    <div id="sec-admin-paper" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-red-100 text-red-700 rounded-md flex items-center justify-center text-xs font-black">6.2</span>
            Kelola Paper & Review — Menu: Kelola Paper
        </h3>
        <div class="space-y-2 mb-3">
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 pt-1">Gunakan <strong>filter status</strong> untuk menyaring paper (Submitted, Under Review, Revision, Accepted, Rejected).</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 pt-1">Klik judul paper → <strong>Assign Reviewer</strong> untuk menugaskan reviewer, atau langsung ubah status paper.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 pt-1">Isi <strong>catatan editor</strong> yang akan terlihat oleh penulis, lalu simpan.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">4</div><p class="text-sm text-gray-700 pt-1">Sistem mengirim email notifikasi otomatis ke penulis setiap kali status berubah.</p></div>
        </div>
    </div>

    {{-- 6.3 Pembayaran --}}
    <div id="sec-admin-payment" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-red-100 text-red-700 rounded-md flex items-center justify-center text-xs font-black">6.3</span>
            Verifikasi Pembayaran — Menu: Pembayaran
        </h3>
        <div class="space-y-2 mb-3">
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 pt-1">Buka menu <strong>Pembayaran</strong>. Daftar pembayaran menunggu verifikasi tampil di bagian atas.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 pt-1">Klik detail untuk melihat bukti transfer. Periksa nominal, nama pengirim, dan tanggal transfer.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 pt-1">Klik <strong>Verifikasi</strong> jika valid. Status penulis/peserta otomatis diperbarui dan email konfirmasi terkirim.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">4</div><p class="text-sm text-gray-700 pt-1">Gunakan tombol <strong>Export Excel</strong> untuk mengunduh laporan pembayaran dalam format .xlsx.</p></div>
        </div>
    </div>

    {{-- 6.4 Sertifikat --}}
    <div id="sec-admin-cert" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-red-100 text-red-700 rounded-md flex items-center justify-center text-xs font-black">6.4</span>
            Generate LOA & Sertifikat — Menu: Sertifikat
        </h3>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="border border-green-200 rounded-xl p-4">
                <p class="font-bold text-green-800 mb-2 text-sm">Generate LOA (dari halaman Paper)</p>
                <ol class="text-xs text-gray-600 space-y-1 list-decimal list-inside">
                    <li>Buka detail paper yang sudah Accepted & lunas.</li>
                    <li>Klik tombol <strong>Generate LOA</strong>.</li>
                    <li>LOA PDF otomatis dibuat dan tersedia untuk penulis.</li>
                    <li>Notifikasi email otomatis terkirim ke penulis.</li>
                </ol>
            </div>
            <div class="border border-yellow-200 rounded-xl p-4">
                <p class="font-bold text-yellow-800 mb-2 text-sm">Generate Sertifikat (Menu: Sertifikat)</p>
                <ol class="text-xs text-gray-600 space-y-1 list-decimal list-inside">
                    <li>Isi data penandatangan (nama, jabatan, tanda tangan PNG) di tab <strong>Pengaturan</strong>.</li>
                    <li>Preview desain di tab <strong>Preview</strong>.</li>
                    <li>Di tab <strong>Generate</strong>, pilih tipe sertifikat (Author/Peserta/Reviewer).</li>
                    <li>Klik <strong>Generate Semua</strong> untuk batch generate.</li>
                </ol>
            </div>
        </div>
    </div>

    {{-- 6.5 Konten --}}
    <div id="sec-admin-content" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-red-100 text-red-700 rounded-md flex items-center justify-center text-xs font-black">6.5</span>
            Kelola Konten & Pengumuman
        </h3>
        <div class="grid md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="font-semibold text-gray-700 mb-2">📢 Pengumuman</p>
                <ol class="text-xs text-gray-600 space-y-1 list-decimal list-inside">
                    <li>Menu <strong>Pengumuman</strong> → Tambah Pengumuman.</li>
                    <li>Isi judul, konten, tipe (info/warning/deadline), dan target audiens.</li>
                    <li>Centang <strong>Tampilkan sebagai Popup</strong> agar muncul saat login.</li>
                    <li>Atur tanggal kedaluwarsa jika perlu, lalu Publish.</li>
                </ol>
            </div>
            <div>
                <p class="font-semibold text-gray-700 mb-2">📰 Berita & Konten Lain</p>
                <ul class="text-xs text-gray-600 space-y-1 list-disc list-inside">
                    <li><strong>Berita</strong> — artikel yang tampil di halaman publik</li>
                    <li><strong>Tutorial</strong> — panduan penggunaan sistem</li>
                    <li><strong>Halaman</strong> — halaman statis (tentang, kontak, dll.)</li>
                    <li><strong>Slider</strong> — banner gambar di halaman utama</li>
                    <li><strong>Menu</strong> — kelola navigasi website publik</li>
                    <li><strong>Supporter</strong> — logo sponsor/mitra konferensi</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- 6.6 Users --}}
    <div id="sec-admin-users" class="mb-8">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-red-100 text-red-700 rounded-md flex items-center justify-center text-xs font-black">6.6</span>
            Kelola Pengguna & Impersonasi — Menu: Users & Roles
        </h3>
        <div class="space-y-2 mb-4">
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 pt-1">Menu <strong>Users & Roles</strong> — lihat semua pengguna terdaftar, ubah peran (author/participant/reviewer/editor/admin), atau nonaktifkan akun.</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 pt-1"><strong>Impersonasi</strong>: klik ikon "Masuk sebagai" di samping nama pengguna untuk login sebagai pengguna tersebut (troubleshooting).</p></div>
            <div class="flex gap-3 items-start"><div class="step-num bg-red-500 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 pt-1">Banner kuning di atas layar menandakan mode impersonasi aktif. Klik <strong>Kembali ke Admin</strong> untuk mengakhiri.</p></div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-3 text-xs text-red-800">
            <strong>⚠️ Perhatian:</strong> Hindari mengubah peran akun yang sedang login. Logout terlebih dahulu jika perlu mengubah peran akun sendiri.
        </div>
    </div>

    {{-- 6.7 Settings --}}
    <div id="sec-admin-settings" class="mb-2">
        <h3 class="flex items-center gap-2 font-bold text-gray-700 text-base mb-3">
            <span class="w-6 h-6 bg-red-100 text-red-700 rounded-md flex items-center justify-center text-xs font-black">6.7</span>
            Pengaturan Sistem
        </h3>
        <div class="grid md:grid-cols-2 gap-3 text-sm">
            <div class="border border-gray-200 rounded-xl p-3">
                <p class="font-semibold text-gray-700 mb-1">🏢 Identitas Website</p>
                <p class="text-xs text-gray-500">Nama website, logo, tagline, alamat, nomor kontak.</p>
            </div>
            <div class="border border-gray-200 rounded-xl p-3">
                <p class="font-semibold text-gray-700 mb-1">📧 Pengaturan Email</p>
                <p class="text-xs text-gray-500">Konfigurasi SMTP untuk pengiriman notifikasi email otomatis.</p>
            </div>
            <div class="border border-gray-200 rounded-xl p-3">
                <p class="font-semibold text-gray-700 mb-1">✉️ Template Email</p>
                <p class="text-xs text-gray-500">Kustomisasi isi email welcome, verifikasi, dan notifikasi.</p>
            </div>
            <div class="border border-gray-200 rounded-xl p-3">
                <p class="font-semibold text-gray-700 mb-1">🎨 Tema Website</p>
                <p class="text-xs text-gray-500">Pilih tampilan halaman publik dari 6 tema yang tersedia.</p>
            </div>
            <div class="border border-gray-200 rounded-xl p-3 md:col-span-2">
                <p class="font-semibold text-gray-700 mb-1">🗄️ Database Manager</p>
                <p class="text-xs text-gray-500">Export backup database (.sql) dan restore data. Lakukan backup rutin minimal seminggu sekali.</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     7. HELPDESK
════════════════════════════════════════════════════════════ --}}
<div id="sec-helpdesk" class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-7 mb-6">
    <div class="flex items-center gap-3 mb-5">
        <span class="w-9 h-9 bg-gray-700 text-white rounded-xl flex items-center justify-center font-black text-lg">7</span>
        <h2 class="text-xl font-bold text-gray-800">Helpdesk & Bantuan Teknis</h2>
    </div>
    <p class="text-sm text-gray-600 mb-4">Fitur Helpdesk tersedia untuk semua peran pengguna (Author, Peserta, Reviewer).</p>
    <div class="space-y-3 mb-5">
        <div class="flex gap-3 items-start"><div class="step-num bg-gray-700 text-white mt-0.5 text-xs">1</div><p class="text-sm text-gray-700 pt-1">Login ke Dashboard → buka menu <strong>Helpdesk</strong> di sidebar.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-gray-700 text-white mt-0.5 text-xs">2</div><p class="text-sm text-gray-700 pt-1">Klik <strong>Buat Tiket Baru</strong>. Isi subjek, deskripsi lengkap masalah, dan kategori.</p></div>
        <div class="flex gap-3 items-start"><div class="step-num bg-gray-700 text-white mt-0.5 text-xs">3</div><p class="text-sm text-gray-700 pt-1">Submit tiket — panitia akan merespons dalam 1×24 jam kerja. Pantau balasan di halaman detail tiket.</p></div>
    </div>
    <div class="grid md:grid-cols-2 gap-3 text-xs">
        <div class="bg-green-50 border border-green-200 rounded-xl p-3">
            <p class="font-bold text-green-800 mb-1">✓ Gunakan Helpdesk untuk:</p>
            <ul class="text-green-700 space-y-0.5 list-disc list-inside">
                <li>Error atau bug pada sistem</li>
                <li>Pertanyaan prosedur pendaftaran</li>
                <li>Permohonan koreksi data</li>
                <li>Masalah atau pertanyaan pembayaran</li>
                <li>Permintaan khusus ke panitia</li>
            </ul>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-3">
            <p class="font-bold text-red-800 mb-1">✕ Hindari untuk:</p>
            <ul class="text-red-700 space-y-0.5 list-disc list-inside">
                <li>Pertanyaan yang sudah dijawab di panduan ini</li>
                <li>Upload ulang bukti bayar (gunakan fitur di dashboard)</li>
                <li>Informasi yang tersedia di pengumuman</li>
            </ul>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     8. VERIFIKASI DOKUMEN
════════════════════════════════════════════════════════════ --}}
<div id="sec-verify" class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-7 mb-10">
    <div class="flex items-center gap-3 mb-5">
        <span class="w-9 h-9 bg-gray-700 text-white rounded-xl flex items-center justify-center font-black text-lg">8</span>
        <h2 class="text-xl font-bold text-gray-800">Verifikasi Keaslian Dokumen</h2>
    </div>
    <p class="text-sm text-gray-600 mb-5">Semua LOA dan Sertifikat yang diterbitkan sistem dilengkapi QR Code dan nomor unik untuk verifikasi keaslian dokumen.</p>
    <div class="grid md:grid-cols-2 gap-4">
        <div class="border border-gray-200 rounded-xl p-4">
            <p class="font-bold text-gray-700 mb-3 text-sm">Cara Verifikasi via QR Code</p>
            <div class="space-y-2">
                <div class="flex gap-2 items-start text-xs text-gray-600"><span class="font-bold text-blue-600">1.</span> Scan QR Code pada dokumen menggunakan kamera HP.</div>
                <div class="flex gap-2 items-start text-xs text-gray-600"><span class="font-bold text-blue-600">2.</span> Browser akan membuka halaman verifikasi otomatis.</div>
                <div class="flex gap-2 items-start text-xs text-gray-600"><span class="font-bold text-blue-600">3.</span> Halaman menampilkan status: <span class="bg-green-100 text-green-700 px-1 rounded font-semibold">VALID</span> atau <span class="bg-red-100 text-red-700 px-1 rounded font-semibold">TIDAK DITEMUKAN</span>.</div>
            </div>
        </div>
        <div class="border border-gray-200 rounded-xl p-4">
            <p class="font-bold text-gray-700 mb-3 text-sm">Cara Verifikasi via URL</p>
            <div class="space-y-2">
                <div class="flex gap-2 items-start text-xs text-gray-600"><span class="font-bold text-blue-600">✓</span> Sertifikat: <code class="bg-gray-100 px-1 rounded">{{ url('/') }}/verify-certificate/[NOMOR]</code></div>
                <div class="flex gap-2 items-start text-xs text-gray-600"><span class="font-bold text-blue-600">✓</span> LOA: <code class="bg-gray-100 px-1 rounded">{{ url('/') }}/verify-loa/[KODE]</code></div>
                <div class="flex gap-2 items-start text-xs text-gray-600"><span class="font-bold text-blue-600">i</span> Ganti <code>[NOMOR]</code> atau <code>[KODE]</code> dengan kode unik yang tertera di dokumen.</div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════════════════ --}}
<div class="text-center text-xs text-gray-400 mb-6">
    <p>Buku Panduan {{ $siteName }} — Dicetak {{ now()->isoFormat('D MMMM Y') }}</p>
    <p class="mt-1">{{ url('/') }} | Untuk pertanyaan teknis, gunakan fitur Helpdesk di dalam sistem.</p>
</div>

</div>{{-- /max-w-4xl --}}
</body>
</html>
