# Panduan Instalasi

Panduan lengkap untuk menginstall dan menjalankan aplikasi Prosiding Conference Management System.

## 🌐 Cara Termudah: Setup Wizard via Browser

Aplikasi ini memiliki **halaman setup wizard interaktif** yang bisa diakses via browser. Cocok untuk orang awam dan deployment ke cPanel tanpa akses terminal.

### Langkah-langkah:

1. **Upload file ke hosting/server**
   - Upload semua file ke folder `public_html` atau subdomain

2. **Akses halaman setup**
   ```
   http://domain-anda.com/setup
   ```

3. **Ikuti wizard step-by-step:**
   
   | Step | Keterangan |
   |------|------------|
   | 🔐 **Token Auth** | Masukkan token keamanan: `setup-prosiding` |
   | ✅ **Cek Sistem** | Otomatis mengecek PHP, extension, folder permission |
   | ⚙️ **Konfigurasi** | Isi nama aplikasi, URL, database, email |
   | 🗃️ **Database** | Test koneksi, jalankan migrasi & seeder |
   | 🚀 **Finalisasi** | Storage link, clear cache, selesai! |

4. **Selesai!** Aplikasi siap digunakan

> **Catatan Keamanan:** Setelah setup selesai, halaman `/setup` akan otomatis terkunci. Untuk setup ulang, hapus file `storage/app/setup_complete.lock`.

---

## Persyaratan Sistem

### Software yang Diperlukan

| Software | Versi Minimum | Keterangan |
|----------|---------------|------------|
| PHP | 8.2 | Dengan extension: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML, GD/Imagick |
| Composer | 2.x | Package manager PHP |
| Node.js | 18.x | Untuk build assets |
| NPM | 9.x | Sudah termasuk dengan Node.js |
| Database | SQLite / MySQL 8.0+ / PostgreSQL 14+ | Default menggunakan SQLite |

### PHP Extensions yang Diperlukan
```
php-bcmath
php-ctype
php-curl
php-dom
php-fileinfo
php-json
php-mbstring
php-openssl
php-pdo
php-pdo_sqlite (atau pdo_mysql untuk MySQL)
php-tokenizer
php-xml
php-gd
php-zip
```

## Instalasi Cepat (Quick Install)

### Windows - Menggunakan Installer Interaktif (Recommended)

```powershell
# Clone atau extract project ke folder yang diinginkan
cd d:\LPKD-APJI\PROSIDINGV1

# Opsi 1: Jalankan installer PowerShell (recommended - tampilan modern)
.\install.ps1

# Opsi 2: Jalankan installer Batch (kompatibel semua Windows)
.\install.bat

# Opsi 3: Jalankan setup sederhana
.\setup.bat
```

**Fitur Installer Interaktif:**
- 🚀 Install otomatis dengan satu klik
- 📦 Install manual step-by-step
- 🔧 Tools & utilities (clear cache, reset database, dll)
- ▶️ Jalankan aplikasi langsung dari menu
- ❓ Cek persyaratan sistem

### Linux/Mac

```bash
# Clone atau extract project ke folder yang diinginkan
cd /path/to/prosiding

# Berikan permission untuk script
chmod +x setup.sh

# Jalankan script instalasi
./setup.sh
```

## Instalasi Manual (Step by Step)

### Langkah 1: Persiapan Environment

```bash
# Copy file environment
cp .env.example .env

# Edit file .env sesuai kebutuhan (opsional)
# Untuk MySQL, ubah konfigurasi database:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=prosiding
# DB_USERNAME=root
# DB_PASSWORD=your_password
```

### Langkah 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Langkah 3: Setup Aplikasi

```bash
# Generate application key
php artisan key:generate

# Buat database SQLite (jika menggunakan SQLite)
# Windows PowerShell:
New-Item -ItemType File -Path database\database.sqlite -Force

# Linux/Mac:
touch database/database.sqlite

# Jalankan migrasi database
php artisan migrate

# Buat symbolic link untuk storage
php artisan storage:link
```

### Langkah 4: Seed Data Awal

```bash
# Jalankan semua seeder
php artisan db:seed

# Atau jalankan seeder tertentu saja:
php artisan db:seed --class=RolesSeeder
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=SettingsSeeder
php artisan db:seed --class=ThemePresetSeeder
```

### Langkah 5: Build Assets

```bash
# Build untuk production
npm run build

# Atau untuk development (dengan hot reload)
npm run dev
```

## Menjalankan Aplikasi

### Mode Development

```bash
# Cara 1: Menggunakan composer script (recommended)
composer dev

# Cara 2: Jalankan server secara manual
php artisan serve
# Buka terminal baru untuk Vite
npm run dev
```

Server akan berjalan di: http://localhost:8000

### Mode Production

```bash
# Build assets terlebih dahulu
npm run build

# Jalankan dengan web server (Apache/Nginx)
# Arahkan document root ke folder /public
```

## Konfigurasi Database

### SQLite (Default)

Tidak perlu konfigurasi tambahan. Database akan otomatis dibuat di `database/database.sqlite`.

### MySQL

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prosiding
DB_USERNAME=root
DB_PASSWORD=your_password
```

Buat database di MySQL:
```sql
CREATE DATABASE prosiding CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### PostgreSQL

Edit file `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=prosiding
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

## Konfigurasi Email

### Untuk Development (Log)

```env
MAIL_MAILER=log
```

Email akan ditulis ke file log di `storage/logs/laravel.log`.

### Untuk Production (SMTP)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Akun Default

Setelah menjalankan seeder, akun default yang tersedia:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@prosiding.test | password |
| Editor | editor@prosiding.test | password |
| Reviewer | reviewer@prosiding.test | password |

> **Penting:** Segera ubah password default setelah login pertama kali!

## Troubleshooting

### Error: "The stream or file could not be opened"

```bash
# Set permission untuk folder storage dan cache
# Linux/Mac:
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows: pastikan folder tidak read-only
```

### Error: "Class not found"

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Error: "Vite manifest not found"

```bash
npm run build
```

### Error: Database connection

```bash
# Periksa konfigurasi database di .env
# Untuk SQLite, pastikan file database ada:
php artisan migrate
```

### Error: "Permission denied" saat upload

```bash
# Linux/Mac:
chmod -R 775 storage/app/public
php artisan storage:link
```

## Perintah Artisan Berguna

```bash
# Clear semua cache
php artisan optimize:clear

# Rebuild cache untuk production
php artisan optimize

# Lihat semua route
php artisan route:list

# Buat user baru via tinker
php artisan tinker
> User::create(['name'=>'Admin', 'email'=>'admin@test.com', 'password'=>bcrypt('password'), 'role'=>'admin']);

# Fresh migration (hapus semua data dan migrasi ulang)
php artisan migrate:fresh --seed
```

## Struktur Folder Penting

```
├── app/                    # Kode aplikasi
│   ├── Http/Controllers/   # Controllers
│   ├── Livewire/          # Livewire components
│   ├── Models/            # Eloquent models
│   └── Services/          # Business logic services
├── config/                # Konfigurasi aplikasi
├── database/
│   ├── migrations/        # File migrasi database
│   └── seeders/          # Data seeder
├── public/               # Document root (untuk web server)
├── resources/
│   ├── css/             # CSS/Tailwind
│   ├── js/              # JavaScript
│   └── views/           # Blade templates
├── routes/
│   └── web.php          # Web routes
├── storage/             # File uploads, logs, cache
└── .env                 # Environment configuration
```

## Bantuan Lebih Lanjut

- Dokumentasi Laravel: https://laravel.com/docs
- Dokumentasi Livewire: https://livewire.laravel.com/docs
- Dokumentasi Tailwind CSS: https://tailwindcss.com/docs

## Lisensi

MIT License
