<?php

namespace Database\Seeders;

use App\Models\Tutorial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TutorialSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('tutorials')) {
            $this->command->warn('Table "tutorials" does not exist. Run migrations first: php artisan migrate');
            return;
        }

        Tutorial::truncate();

        $tutorials = [

            // ─────────────────────────────────────────────────────────
            // 1. PANDUAN UMUM
            // ─────────────────────────────────────────────────────────
            [
                'title'      => '🌐 Gambaran Umum Sistem Konferensi',
                'content'    => "Sistem ini adalah platform manajemen konferensi ilmiah yang digunakan untuk proses pendaftaran, pengiriman paper, review, pembayaran, hingga penerbitan sertifikat.\n\nAda 4 jenis akun yang tersedia:\n• AUTHOR (Pemakalah) — untuk peserta yang akan mempresentasikan paper\n• PARTICIPANT (Peserta) — untuk peserta umum yang mengikuti konferensi\n• REVIEWER — untuk tim reviewer yang menilai paper\n• ADMIN / EDITOR — untuk panitia pengelola sistem\n\nSetelah mendaftar, Anda akan mendapatkan email konfirmasi. Login menggunakan email dan password yang didaftarkan.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 1,
                'is_active'  => true,
            ],

            // ─────────────────────────────────────────────────────────
            // 2. PANDUAN AUTHOR
            // ─────────────────────────────────────────────────────────
            [
                'title'      => '✍️ [AUTHOR] Langkah 1 — Registrasi & Login',
                'content'    => "1. Buka halaman utama website konferensi.\n2. Klik tombol \"Register\" di pojok kanan atas.\n3. Isi formulir pendaftaran:\n   • Nama lengkap (sesuai ijazah / sertifikat)\n   • Email aktif\n   • Institusi/Universitas\n   • Nomor HP/WhatsApp\n   • Password (minimal 8 karakter)\n4. Pilih peran: Author / Pemakalah.\n5. Klik \"Daftar\" — cek email untuk konfirmasi.\n6. Setelah terdaftar, login menggunakan email dan password Anda.\n7. Anda akan diarahkan ke Dashboard Author.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 10,
                'is_active'  => true,
            ],
            [
                'title'      => '✍️ [AUTHOR] Langkah 2 — Submit Paper',
                'content'    => "1. Dari Dashboard, klik menu \"Paper Saya\" di sidebar kiri.\n2. Klik tombol \"+ Submit Paper Baru\".\n3. Isi formulir pengiriman paper:\n   • Judul paper (gunakan huruf kapital di awal)\n   • Abstrak (min. 150 kata)\n   • Kata kunci / Keywords (pisahkan dengan koma)\n   • Topik / Bidang keilmuan\n   • Nama penulis lengkap & co-authors (jika ada)\n4. Upload file paper dalam format yang ditentukan (biasanya .docx atau .pdf).\n5. Klik \"Submit Paper\".\n6. Status paper akan berubah menjadi \"Submitted\" — menunggu review.\n\nCATATAN: Pastikan paper sudah sesuai template yang disediakan panitia sebelum dikirim.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 11,
                'is_active'  => true,
            ],
            [
                'title'      => '✍️ [AUTHOR] Langkah 3 — Memantau Status Review',
                'content'    => "1. Buka menu \"Paper Saya\" di sidebar.\n2. Klik judul paper untuk melihat detail.\n3. Status paper akan berubah secara otomatis:\n   • Submitted → Paper sudah terkirim, menunggu reviewer\n   • Under Review → Sedang dalam proses penilaian\n   • Revision Required → Anda perlu merevisi paper sesuai catatan reviewer\n   • Accepted → Paper diterima! Lanjut ke tahap pembayaran\n   • Rejected → Paper tidak diterima\n4. Jika ada catatan revisi, baca komentar reviewer di halaman detail paper, lakukan revisi, lalu upload ulang file paper.\n5. Tunggu notifikasi email untuk setiap perubahan status.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 12,
                'is_active'  => true,
            ],
            [
                'title'      => '✍️ [AUTHOR] Langkah 4 — Pembayaran Registrasi',
                'content'    => "Setelah paper diterima (status: Accepted), Anda perlu melakukan pembayaran:\n\n1. Buka menu \"Paper Saya\" → klik paper yang sudah diterima.\n2. Klik tombol \"Upload Bukti Bayar\".\n3. Transfer biaya registrasi ke rekening yang tertera di halaman pembayaran.\n4. Upload foto/scan bukti transfer (JPG, PNG, atau PDF, maks. 5 MB).\n5. Pilih metode pembayaran yang Anda gunakan.\n6. Klik \"Upload Bukti Pembayaran\".\n7. Tunggu konfirmasi dari bendahara panitia (1-2 hari kerja).\n8. Setelah diverifikasi, status berubah menjadi \"Payment Verified\".\n\nIMPORTANT: Simpan bukti transfer sampai konferensi selesai.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 13,
                'is_active'  => true,
            ],
            [
                'title'      => '✍️ [AUTHOR] Langkah 5 — Upload Berkas Pendukung (Deliverables)',
                'content'    => "Setelah pembayaran terverifikasi, upload berkas pendukung presentasi:\n\n1. Buka \"Paper Saya\" → klik paper Anda.\n2. Klik tombol \"Upload Berkas\".\n3. Upload file yang diperlukan:\n   • File Paper Final (PDF/DOCX) — versi final setelah revisi\n   • Poster Presentasi (PDF/PNG) — jika diminta\n   • Slide Presentasi / PPT (PPTX/PDF)\n4. Setiap file dapat diupload secara terpisah sesuai jenisnya.\n5. Klik \"Upload\" untuk masing-masing file.\n6. Status akan berubah ke \"Deliverables Submitted\" setelah semua file terupload.\n\nBatas waktu pengumpulan berkas biasanya tertera di halaman Tanggal Penting.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 14,
                'is_active'  => true,
            ],
            [
                'title'      => '✍️ [AUTHOR] Langkah 6 — Submit Video Presentasi',
                'content'    => "Jika konferensi mewajibkan video presentasi:\n\n1. Upload video presentasi Anda ke YouTube (atur sebagai \"Unlisted\" atau \"Public\").\n2. Salin URL video YouTube Anda.\n3. Di Dashboard, buka menu \"Video Pemaparan\" di sidebar kiri.\n4. Temukan paper yang sesuai, tempelkan URL YouTube di kolom yang tersedia.\n5. Klik \"Simpan URL Video\".\n6. Video Anda akan dapat diakses oleh reviewer dan peserta lain.\n\nTIPS: Durasi video yang disarankan 10-15 menit. Sertakan slide presentasi di video.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 15,
                'is_active'  => true,
            ],
            [
                'title'      => '✍️ [AUTHOR] Langkah 7 — Download LOA & Sertifikat',
                'content'    => "LOA (Letter of Acceptance):\n1. Setelah paper diterima dan pembayaran diverifikasi, panitia akan menerbitkan LOA.\n2. Buka menu \"LOA & Tagihan\" di sidebar kiri.\n3. Klik tombol \"Download LOA\" untuk mengunduh surat penerimaan.\n4. LOA dilengkapi QR Code untuk verifikasi keaslian dokumen.\n5. Scan QR Code atau kunjungi conference.stifar.ac.id/verify-loa/[KODE] untuk verifikasi.\n\nSertifikat:\n1. Setelah konferensi selesai, panitia akan menerbitkan sertifikat.\n2. Buka menu \"Sertifikat\" di sidebar kiri.\n3. Klik \"Download\" untuk mengunduh sertifikat dalam format PDF.\n4. Sertifikat dilengkapi nomor unik dan QR Code untuk verifikasi keaslian.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 16,
                'is_active'  => true,
            ],

            // ─────────────────────────────────────────────────────────
            // 3. PANDUAN PARTICIPANT
            // ─────────────────────────────────────────────────────────
            [
                'title'      => '🎟️ [PESERTA] Langkah 1 — Registrasi & Login',
                'content'    => "1. Buka halaman utama website konferensi.\n2. Klik tombol \"Register\" di pojok kanan atas.\n3. Isi formulir pendaftaran:\n   • Nama lengkap\n   • Email aktif\n   • Institusi/Universitas/Instansi\n   • Nomor HP/WhatsApp\n   • Password\n4. Pilih peran: Peserta / Participant.\n5. Klik \"Daftar\" — cek email untuk konfirmasi.\n6. Login ke Dashboard Peserta.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 20,
                'is_active'  => true,
            ],
            [
                'title'      => '🎟️ [PESERTA] Langkah 2 — Pembayaran & Verifikasi',
                'content'    => "1. Dari Dashboard, buka menu \"Pembayaran\" di sidebar kiri.\n2. Pilih paket registrasi yang sesuai (Early Bird / Regular / Online).\n3. Transfer biaya pendaftaran ke rekening yang tertera.\n4. Upload bukti transfer:\n   • Klik \"Upload Bukti Pembayaran\"\n   • Pilih file (JPG/PNG/PDF, maks. 5MB)\n   • Isi metode pembayaran\n   • Klik \"Upload\"\n5. Tunggu konfirmasi dari panitia (1-2 hari kerja).\n6. Setelah diverifikasi, status berubah menjadi \"Verified\" — pendaftaran Anda resmi terkonfirmasi.\n7. Anda akan menerima email konfirmasi dan undangan grup WhatsApp dari panitia.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 21,
                'is_active'  => true,
            ],
            [
                'title'      => '🎟️ [PESERTA] Langkah 3 — Download Materi Konferensi',
                'content'    => "Setelah pembayaran terverifikasi, Anda dapat mengakses materi konferensi:\n\n1. Dari Dashboard, buka menu \"Materi\" di sidebar kiri.\n2. Materi akan tampil berdasarkan kategori:\n   • Materi Keynote Speaker\n   • Presentasi Pemakalah\n   • File PPT / Slide\n   • Dokumen Prosiding\n3. Klik tombol \"Download\" pada materi yang ingin diunduh.\n4. Materi hanya tersedia setelah konferensi berlangsung (kecuali ditentukan lain oleh panitia).\n\nCATATAN: Materi bersifat rahasia dan hanya untuk peserta terdaftar. Dilarang disebarluaskan tanpa izin penyelenggara.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 22,
                'is_active'  => true,
            ],
            [
                'title'      => '🎟️ [PESERTA] Langkah 4 — Download Sertifikat',
                'content'    => "Setelah konferensi selesai:\n\n1. Buka menu \"Sertifikat\" di sidebar kiri Dashboard.\n2. Sertifikat kehadiran akan tersedia jika data Anda sudah dikonfirmasi hadir oleh panitia.\n3. Klik \"Download\" untuk mengunduh sertifikat PDF.\n4. Sertifikat memiliki nomor unik dan QR Code untuk verifikasi keaslian.\n5. Untuk memverifikasi sertifikat, scan QR Code atau kunjungi conference.stifar.ac.id/verify-certificate/[NOMOR]\n\nJika sertifikat belum tersedia, hubungi panitia melalui menu Helpdesk atau kontak yang tersedia.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 23,
                'is_active'  => true,
            ],

            // ─────────────────────────────────────────────────────────
            // 4. PANDUAN REVIEWER
            // ─────────────────────────────────────────────────────────
            [
                'title'      => '🔍 [REVIEWER] Langkah 1 — Login & Akses Dashboard',
                'content'    => "Akun reviewer dibuat dan diberikan kepada Anda oleh Admin:\n\n1. Cek email dari panitia — berisi username dan password akun reviewer.\n2. Buka halaman login: conference.stifar.ac.id/login\n3. Masukkan email dan password yang diberikan.\n4. Anda akan diarahkan ke Dashboard Reviewer.\n5. Disarankan untuk segera mengganti password melalui menu \"Profil\".\n\nTIPS: Aktifkan notifikasi email agar mendapat pemberitahuan saat ada paper baru yang perlu direview.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 30,
                'is_active'  => true,
            ],
            [
                'title'      => '🔍 [REVIEWER] Langkah 2 — Melakukan Review Paper',
                'content'    => "1. Dari Dashboard, buka menu \"Tugas Review\" di sidebar kiri.\n2. Daftar paper yang ditugaskan kepada Anda akan tampil.\n3. Klik judul paper untuk membuka halaman review.\n4. Unduh file paper dengan klik tombol \"Download Paper\".\n5. Baca paper dengan seksama.\n6. Isi formulir review:\n   • Skor penilaian untuk setiap aspek (orisinalitas, metodologi, penulisan, relevansi)\n   • Komentar/saran rinci untuk penulis\n   • Rekomendasi keputusan: Accept / Minor Revision / Major Revision / Reject\n7. Klik \"Simpan Review\" untuk menyimpan penilaian.\n8. Hasil review akan dikirimkan ke admin dan penulis secara otomatis.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 31,
                'is_active'  => true,
            ],

            // ─────────────────────────────────────────────────────────
            // 5. PANDUAN ADMIN / EDITOR
            // ─────────────────────────────────────────────────────────
            [
                'title'      => '⚙️ [ADMIN] Langkah 1 — Kelola Konferensi',
                'content'    => "Membuat dan mengatur data konferensi:\n\n1. Buka menu \"Konferensi\" di sidebar admin.\n2. Klik \"+ Tambah Konferensi\" untuk membuat konferensi baru.\n3. Isi data:\n   • Nama konferensi, akronim, deskripsi\n   • Tanggal mulai & selesai, lokasi/venue\n   • Status: Draft / Published\n   • Aktifkan toggle \"Konferensi Aktif\" untuk menjadikannya konferensi utama\n4. Tambahkan Tanggal Penting (deadline submit, pengumuman, dll).\n5. Tambahkan Keynote Speaker.\n6. Atur Paket Registrasi (harga untuk author, peserta, dll).\n7. Simpan.\n\nHanya 1 konferensi yang bisa aktif pada satu waktu.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 40,
                'is_active'  => true,
            ],
            [
                'title'      => '⚙️ [ADMIN] Langkah 2 — Kelola Paper & Review',
                'content'    => "Mengelola paper yang masuk:\n\n1. Buka menu \"Paper\" di sidebar admin.\n2. Gunakan filter status (Submitted, Under Review, dll) untuk menyaring paper.\n3. Klik judul paper untuk melihat detail.\n4. Tindakan yang bisa dilakukan:\n   • Assign Reviewer — pilih reviewer yang akan menilai paper\n   • Ubah Status — terima, tolak, atau minta revisi\n   • Download paper — unduh file paper untuk dibaca\n   • Isi catatan editor (editor notes) untuk penulis\n5. Setelah paper diputuskan diterima, status berubah ke \"Accepted\".\n6. Sistem akan mengirim notifikasi email otomatis ke penulis.\n\nEditor can also manage papers with limited access (no user management).",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 41,
                'is_active'  => true,
            ],
            [
                'title'      => '⚙️ [ADMIN] Langkah 3 — Verifikasi Pembayaran',
                'content'    => "Memverifikasi bukti pembayaran dari author/peserta:\n\n1. Buka menu \"Pembayaran\" di sidebar admin.\n2. Daftar pembayaran yang menunggu verifikasi akan tampil.\n3. Klik detail pembayaran untuk melihat bukti transfer.\n4. Periksa:\n   • Nominal sesuai paket\n   • Nama pengirim sesuai pendaftar\n   • Tanggal transfer masih valid\n5. Klik \"Verifikasi\" jika valid, atau \"Tolak\" jika bermasalah.\n6. Setelah diverifikasi, status otomatis berubah dan penulis/peserta mendapat notifikasi.\n7. Gunakan tombol \"Export Excel\" untuk mengunduh laporan pembayaran.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 42,
                'is_active'  => true,
            ],
            [
                'title'      => '⚙️ [ADMIN] Langkah 4 — Generate & Kirim LOA',
                'content'    => "Menerbitkan Letter of Acceptance (LOA) untuk pemakalah:\n\n1. Buka menu \"Paper\" → klik paper yang sudah diterima dan pembayarannya terverifikasi.\n2. Klik tombol \"Generate LOA\".\n3. LOA otomatis dibuat dalam format PDF dengan:\n   • Nomor LOA unik\n   • Data paper dan penulis\n   • Informasi konferensi\n   • QR Code untuk verifikasi\n   • Tanda tangan Ketua dan Sekretaris (sesuai pengaturan)\n4. File LOA tersimpan di sistem dan bisa diakses penulis dari menu \"LOA & Tagihan\".\n5. Notifikasi email otomatis dikirim ke penulis.\n\nPastikan data tanda tangan sudah diatur di menu Sertifikat → Pengaturan sebelum generate LOA.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 43,
                'is_active'  => true,
            ],
            [
                'title'      => '⚙️ [ADMIN] Langkah 5 — Generate Sertifikat',
                'content'    => "Menerbitkan sertifikat untuk seluruh peserta:\n\n1. Buka menu \"Sertifikat\" di sidebar admin.\n2. Tab \"Pengaturan\" — isi data penandatangan:\n   • Nama & jabatan Ketua Panitia\n   • Nama & jabatan Sekretaris\n   • Upload tanda tangan (PNG transparan, maks. 2MB)\n3. Tab \"Preview\" — cek tampilan sertifikat sebelum diterbitkan.\n4. Tab \"Generate\" — pilih konferensi dan tipe sertifikat (Author / Peserta / Reviewer).\n5. Klik \"Generate Semua Sertifikat\" untuk batch generate.\n6. Sertifikat akan tersedia di dashboard masing-masing penerima.\n7. Setiap sertifikat memiliki nomor unik dan QR Code verifikasi.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 44,
                'is_active'  => true,
            ],
            [
                'title'      => '⚙️ [ADMIN] Langkah 6 — Kelola Pengumuman & Berita',
                'content'    => "Mengelola pengumuman dan berita:\n\nPENGUMUMAN:\n1. Buka menu \"Pengumuman\" di sidebar.\n2. Klik \"+ Tambah Pengumuman\".\n3. Isi judul, konten, tipe (info/warning/deadline), dan target audiens.\n4. Centang \"Tampilkan sebagai Popup\" agar popup muncul di dashboard pengguna saat login.\n5. Atur tanggal kedaluwarsa jika perlu.\n6. Publish.\n\nBERITA:\n1. Buka menu \"Berita\" di sidebar.\n2. Klik \"+ Tambah Berita\".\n3. Isi judul, konten, gambar cover, kategori.\n4. Atur status: Draft atau Published.\n5. Berita yang dipublish tampil di halaman utama website.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 45,
                'is_active'  => true,
            ],
            [
                'title'      => '⚙️ [ADMIN] Langkah 7 — Kelola Pengguna & Impersonasi',
                'content'    => "Mengelola akun pengguna:\n\n1. Buka menu \"Pengguna & Peran\" di sidebar admin.\n2. Lihat daftar semua pengguna terdaftar.\n3. Tindakan yang tersedia:\n   • Ubah peran (role) pengguna: author / participant / reviewer / editor / admin\n   • Nonaktifkan akun\n   • Hapus akun\n\nFITUR IMPERSONASI (Login sebagai pengguna lain):\n1. Klik ikon \"Masuk sebagai\" di samping nama pengguna.\n2. Anda akan login sebagai pengguna tersebut untuk keperluan troubleshooting.\n3. Banner kuning akan muncul di atas layar menandakan mode impersonasi aktif.\n4. Klik \"Kembali ke Admin\" untuk keluar dari mode impersonasi.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 46,
                'is_active'  => true,
            ],
            [
                'title'      => '⚙️ [ADMIN] Langkah 8 — Pengaturan Umum & Backup Database',
                'content'    => "Pengaturan Sistem:\n1. Menu \"Pengaturan → Umum\" — ubah nama website, logo, tagline, kontak.\n2. Menu \"Pengaturan → Email\" — konfigurasi SMTP untuk pengiriman email.\n3. Menu \"Pengaturan → Tema\" — pilih tampilan template website publik.\n\nBackup & Restore Database:\n1. Buka menu \"Database\" di sidebar admin.\n2. Klik \"Export Database\" untuk mengunduh backup SQL.\n3. Simpan file backup secara berkala (minimal sepekan sekali).\n4. Untuk restore, gunakan file .sql yang sudah didownload melalui menu yang sama.\n\nExport Data Pembayaran:\n1. Buka menu \"Pembayaran\".\n2. Klik \"Export Excel\" untuk mengunduh laporan dalam format .xlsx.",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 47,
                'is_active'  => true,
            ],

            // ─────────────────────────────────────────────────────────
            // 6. HELPDESK & KONTAK
            // ─────────────────────────────────────────────────────────
            [
                'title'      => '💬 Bantuan & Helpdesk',
                'content'    => "Jika mengalami masalah teknis atau memiliki pertanyaan:\n\n1. Login ke Dashboard Anda.\n2. Buka menu \"Helpdesk\" di sidebar (tersedia untuk semua peran).\n3. Klik \"Buat Tiket Baru\".\n4. Isi:\n   • Subjek / judul masalah\n   • Deskripsi lengkap permasalahan\n   • Kategori masalah\n5. Submit tiket — panitia akan merespons dalam 1x24 jam kerja.\n6. Pantau status tiket dan balas pesan di halaman detail tiket.\n\nJenis masalah yang bisa dilaporkan:\n• Error/bug pada sistem\n• Pertanyaan tentang prosedur\n• Permohonan koreksi data\n• Masalah pembayaran\n• Permintaan khusus kepada panitia",
                'pdf_path'   => null,
                'pdf_label'  => null,
                'sort_order' => 50,
                'is_active'  => true,
            ],
        ];

        foreach ($tutorials as $data) {
            Tutorial::create($data);
        }
    }
}
