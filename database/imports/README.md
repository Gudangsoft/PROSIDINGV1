# Dummy Data Import Files

Folder ini berisi file-file untuk mengimpor data dummy ke dalam aplikasi.

## File yang Tersedia

| File | Deskripsi | Format |
|------|-----------|--------|
| `dummy_data.sql` | Data lengkap semua tabel | SQL |
| `users.csv` | Data users (authors, reviewers, editor) | CSV |
| `papers.csv` | Data papers dengan berbagai status | CSV |
| `committees.csv` | Data committee members | CSV |
| `topics.csv` | Data topik konferensi | CSV |

## Cara Import

### 1. Import SQL (Rekomendasi)

**Via Admin Panel:**
1. Login sebagai Admin
2. Buka menu **Database Manager**
3. Klik tombol **Import Database**
4. Pilih file `dummy_data.sql`
5. Klik **Import**

**Via Terminal:**
```bash
# Windows (Command Prompt)
mysql -u root -p prosidingv1 < database/imports/dummy_data.sql

# Windows (PowerShell)
Get-Content database\imports\dummy_data.sql | mysql -u root -p prosidingv1
```

### 2. Import via Laravel Seeder

```bash
php artisan db:seed --class=DummyDataSeeder
```

## Data yang Diimport

| Data | Jumlah |
|------|--------|
| Conference | 1 (SNTII 2026) |
| Topics | 10 |
| Keynote Speakers | 5 |
| Committee Members | 13 |
| Registration Packages | 4 |
| Important Dates | 8 |
| Journal Publications | 4 |
| Supporters/Sponsors | 9 |
| Users | 16 (10 Authors, 5 Reviewers, 1 Editor) |
| Papers | 15 (berbagai status) |
| Reviews | 26 |
| Payments | 5 |
| News | 4 |
| Announcements | 2 |
| Sliders | 3 |

## Akun Login untuk Testing

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@prosiding.test | password |
| **Editor** | olivia.editor@prosiding.test | password |
| **Reviewer** | joko.susilo@reviewer.ac.id | password |
| **Author** | aditya.pratama@ui.ac.id | password |

> **Note:** Password untuk semua akun dummy adalah `password`

## Status Paper

File import mencakup paper dengan berbagai status untuk testing alur lengkap:

- `submitted` - Paper baru disubmit
- `screening` - Dalam proses screening
- `in_review` - Sedang direview
- `revision_required` - Perlu revisi
- `revised` - Sudah direvisi
- `accepted` - Diterima
- `payment_pending` - Menunggu pembayaran
- `payment_uploaded` - Bukti pembayaran diupload
- `payment_verified` - Pembayaran terverifikasi
- `completed` - Proses selesai

## Catatan Penting

1. **Backup database** sebelum import jika ada data existing
2. File SQL menggunakan `SET FOREIGN_KEY_CHECKS = 0` untuk menghindari constraint error
3. User ID dimulai dari 100 untuk menghindari konflik dengan admin existing
4. Semua file paper dummy (PDF) tidak disertakan - hanya path referensi

## Troubleshooting

**Error: Duplicate entry**
- Pastikan ID tidak konflik dengan data existing
- Atau jalankan `php artisan migrate:fresh` sebelum import

**Error: Foreign key constraint**
- Pastikan roles table sudah ada (jalankan RolesSeeder terlebih dahulu)
- Periksa conference_id apakah sudah sesuai

**Error: Unknown column**
- Periksa struktur tabel apakah sesuai dengan migrasi terbaru
- Jalankan `php artisan migrate` untuk update schema
