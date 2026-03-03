@echo off
chcp 65001 >nul 2>&1
setlocal enabledelayedexpansion
title Prosiding Conference System - Installer
mode con: cols=80 lines=40
color 0B

:MAIN_MENU
cls
echo.
echo  ╔══════════════════════════════════════════════════════════════════════════╗
echo  ║                                                                          ║
echo  ║   ██████╗ ██████╗  ██████╗ ███████╗██╗██████╗ ██╗███╗   ██╗ ██████╗      ║
echo  ║   ██╔══██╗██╔══██╗██╔═══██╗██╔════╝██║██╔══██╗██║████╗  ██║██╔════╝      ║
echo  ║   ██████╔╝██████╔╝██║   ██║███████╗██║██║  ██║██║██╔██╗ ██║██║  ███╗     ║
echo  ║   ██╔═══╝ ██╔══██╗██║   ██║╚════██║██║██║  ██║██║██║╚██╗██║██║   ██║     ║
echo  ║   ██║     ██║  ██║╚██████╔╝███████║██║██████╔╝██║██║ ╚████║╚██████╔╝     ║
echo  ║   ╚═╝     ╚═╝  ╚═╝ ╚═════╝ ╚══════╝╚═╝╚═════╝ ╚═╝╚═╝  ╚═══╝ ╚═════╝     ║
echo  ║                                                                          ║
echo  ║              Conference Management System - Installer                    ║
echo  ║                                                                          ║
echo  ╚══════════════════════════════════════════════════════════════════════════╝
echo.
echo     Selamat datang di Installer Prosiding Conference System!
echo     Pilih menu di bawah ini untuk memulai:
echo.
echo     ┌────────────────────────────────────────────────────────────────────┐
echo     │                                                                    │
echo     │   [1] 🚀 Install Otomatis (Recommended)                           │
echo     │       Install semua dependensi dan setup database otomatis        │
echo     │                                                                    │
echo     │   [2] 📦 Install Manual (Step by Step)                            │
echo     │       Pilih langkah instalasi satu per satu                       │
echo     │                                                                    │
echo     │   [3] 🔧 Tools ^& Utilities                                        │
echo     │       Clear cache, reset database, dll                            │
echo     │                                                                    │
echo     │   [4] ▶️  Jalankan Aplikasi                                        │
echo     │       Mulai server development                                    │
echo     │                                                                    │
echo     │   [5] ❓ Cek Persyaratan Sistem                                   │
echo     │       Pastikan sistem Anda siap untuk instalasi                   │
echo     │                                                                    │
echo     │   [0] 🚪 Keluar                                                   │
echo     │                                                                    │
echo     └────────────────────────────────────────────────────────────────────┘
echo.
set /p MENU_CHOICE="     Pilih menu [0-5]: "

if "%MENU_CHOICE%"=="1" goto AUTO_INSTALL
if "%MENU_CHOICE%"=="2" goto MANUAL_MENU
if "%MENU_CHOICE%"=="3" goto TOOLS_MENU
if "%MENU_CHOICE%"=="4" goto RUN_APP
if "%MENU_CHOICE%"=="5" goto CHECK_REQUIREMENTS
if "%MENU_CHOICE%"=="0" goto EXIT_APP
goto MAIN_MENU

:CHECK_REQUIREMENTS
cls
echo.
echo  ╔══════════════════════════════════════════════════════════════════════════╗
echo  ║                     CEK PERSYARATAN SISTEM                               ║
echo  ╚══════════════════════════════════════════════════════════════════════════╝
echo.
echo     Memeriksa persyaratan sistem...
echo.

set REQUIREMENTS_MET=1

:: Check PHP
echo     [....] Memeriksa PHP...
where php >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo     [GAGAL] PHP tidak ditemukan!
    echo             Download: https://windows.php.net/download/
    set REQUIREMENTS_MET=0
) else (
    for /f "tokens=2 delims= " %%i in ('php -v 2^>nul ^| findstr /i "^PHP"') do set PHP_VER=%%i
    echo     [  OK ] PHP !PHP_VER! terdeteksi
)

:: Check Composer
echo     [....] Memeriksa Composer...
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo     [GAGAL] Composer tidak ditemukan!
    echo             Download: https://getcomposer.org/download/
    set REQUIREMENTS_MET=0
) else (
    echo     [  OK ] Composer terdeteksi
)

:: Check Node.js
echo     [....] Memeriksa Node.js...
where node >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo     [GAGAL] Node.js tidak ditemukan!
    echo             Download: https://nodejs.org/
    set REQUIREMENTS_MET=0
) else (
    for /f "tokens=*" %%i in ('node -v') do set NODE_VER=%%i
    echo     [  OK ] Node.js !NODE_VER! terdeteksi
)

:: Check NPM
echo     [....] Memeriksa NPM...
where npm >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo     [GAGAL] NPM tidak ditemukan!
    set REQUIREMENTS_MET=0
) else (
    for /f "tokens=*" %%i in ('npm -v') do set NPM_VER=%%i
    echo     [  OK ] NPM !NPM_VER! terdeteksi
)

echo.
if %REQUIREMENTS_MET%==1 (
    echo     ╔════════════════════════════════════════════════════════════════╗
    echo     ║  ✅ SEMUA PERSYARATAN TERPENUHI! Sistem siap untuk instalasi  ║
    echo     ╚════════════════════════════════════════════════════════════════╝
) else (
    echo     ╔════════════════════════════════════════════════════════════════╗
    echo     ║  ❌ BEBERAPA PERSYARATAN BELUM TERPENUHI                       ║
    echo     ║     Silakan install software yang diperlukan terlebih dahulu   ║
    echo     ╚════════════════════════════════════════════════════════════════╝
)
echo.
pause
goto MAIN_MENU

:AUTO_INSTALL
cls
echo.
echo  ╔══════════════════════════════════════════════════════════════════════════╗
echo  ║                       INSTALASI OTOMATIS                                 ║
echo  ╚══════════════════════════════════════════════════════════════════════════╝
echo.
echo     Proses instalasi akan dimulai secara otomatis.
echo     Pastikan koneksi internet Anda stabil.
echo.
set /p CONFIRM="     Lanjutkan instalasi? (y/n): "
if /i not "%CONFIRM%"=="y" goto MAIN_MENU

echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  LANGKAH 1/8: Memeriksa Persyaratan Sistem                    ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.

:: Quick check requirements
set REQ_OK=1
where php >nul 2>nul || set REQ_OK=0
where composer >nul 2>nul || set REQ_OK=0
where node >nul 2>nul || set REQ_OK=0
where npm >nul 2>nul || set REQ_OK=0

if %REQ_OK%==0 (
    echo     ❌ Persyaratan sistem tidak terpenuhi!
    echo        Jalankan "Cek Persyaratan Sistem" dari menu utama.
    pause
    goto MAIN_MENU
)
echo     ✅ Semua persyaratan terpenuhi

echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  LANGKAH 2/8: Membuat File Environment                        ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.

if not exist .env (
    if exist .env.example (
        copy .env.example .env >nul
        echo     ✅ File .env berhasil dibuat
    ) else (
        echo     ❌ File .env.example tidak ditemukan!
        pause
        goto MAIN_MENU
    )
) else (
    echo     ⏭️  File .env sudah ada (skip)
)

echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  LANGKAH 3/8: Install Composer Dependencies                   ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
echo     Menginstall PHP dependencies... (harap tunggu)
echo.

call composer install --no-interaction
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo     ❌ Gagal install Composer dependencies!
    pause
    goto MAIN_MENU
)
echo.
echo     ✅ Composer dependencies berhasil diinstall

echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  LANGKAH 4/8: Generate Application Key                        ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.

php artisan key:generate --force
echo     ✅ Application key berhasil di-generate

echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  LANGKAH 5/8: Setup Database                                  ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.

:: Create SQLite database
if not exist database\database.sqlite (
    echo. > database\database.sqlite
    echo     ✅ File database SQLite berhasil dibuat
) else (
    echo     ⏭️  File database SQLite sudah ada (skip)
)

echo     Menjalankan migrasi database...
php artisan migrate --force
echo     ✅ Migrasi database berhasil

echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  LANGKAH 6/8: Seed Data Awal                                  ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.

set /p DO_SEED="     Isi data contoh (admin user, settings)? (y/n): "
if /i "%DO_SEED%"=="y" (
    php artisan db:seed --force
    echo     ✅ Data awal berhasil ditambahkan
) else (
    echo     ⏭️  Seeding dilewati
)

echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  LANGKAH 7/8: Install NPM Dependencies                        ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
echo     Menginstall Node.js dependencies... (harap tunggu)
echo.

call npm install
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo     ❌ Gagal install NPM dependencies!
    pause
    goto MAIN_MENU
)
echo.
echo     ✅ NPM dependencies berhasil diinstall

echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  LANGKAH 8/8: Build Assets                                    ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
echo     Melakukan build assets... (harap tunggu)
echo.

call npm run build
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo     ❌ Gagal build assets!
    pause
    goto MAIN_MENU
)
echo.
echo     ✅ Assets berhasil di-build

:: Create storage link
php artisan storage:link 2>nul

:: Clear cache
php artisan optimize:clear >nul 2>&1

cls
echo.
echo  ╔══════════════════════════════════════════════════════════════════════════╗
echo  ║                                                                          ║
echo  ║   ██╗███╗   ██╗███████╗████████╗ █████╗ ██╗     ██╗                      ║
echo  ║   ██║████╗  ██║██╔════╝╚══██╔══╝██╔══██╗██║     ██║                      ║
echo  ║   ██║██╔██╗ ██║███████╗   ██║   ███████║██║     ██║                      ║
echo  ║   ██║██║╚██╗██║╚════██║   ██║   ██╔══██║██║     ██║                      ║
echo  ║   ██║██║ ╚████║███████║   ██║   ██║  ██║███████╗███████╗                 ║
echo  ║   ╚═╝╚═╝  ╚═══╝╚══════╝   ╚═╝   ╚═╝  ╚═╝╚══════╝╚══════╝                 ║
echo  ║                                                                          ║
echo  ║               ✅ INSTALASI BERHASIL! ✅                                  ║
echo  ║                                                                          ║
echo  ╚══════════════════════════════════════════════════════════════════════════╝
echo.
echo     ┌────────────────────────────────────────────────────────────────────┐
echo     │                                                                    │
echo     │   🌐 URL Aplikasi : http://localhost:8000                         │
echo     │                                                                    │
echo     │   📧 Akun Default (jika seeder dijalankan):                       │
echo     │                                                                    │
echo     │      Admin    : admin@prosiding.test    / password                │
echo     │      Editor   : editor@prosiding.test   / password                │
echo     │      Reviewer : reviewer@prosiding.test / password                │
echo     │                                                                    │
echo     │   ⚠️  PENTING: Segera ubah password setelah login pertama!        │
echo     │                                                                    │
echo     │   Untuk menjalankan aplikasi:                                     │
echo     │   - Pilih menu [4] dari menu utama, atau                          │
echo     │   - Jalankan: php artisan serve                                   │
echo     │                                                                    │
echo     └────────────────────────────────────────────────────────────────────┘
echo.
pause
goto MAIN_MENU

:MANUAL_MENU
cls
echo.
echo  ╔══════════════════════════════════════════════════════════════════════════╗
echo  ║                       INSTALASI MANUAL                                   ║
echo  ╚══════════════════════════════════════════════════════════════════════════╝
echo.
echo     Pilih langkah yang ingin dijalankan:
echo.
echo     ┌────────────────────────────────────────────────────────────────────┐
echo     │                                                                    │
echo     │   [1] 📄 Buat File .env                                           │
echo     │   [2] 📦 Install Composer Dependencies                            │
echo     │   [3] 🔑 Generate Application Key                                 │
echo     │   [4] 🗃️  Setup Database (Migrasi)                                 │
echo     │   [5] 🌱 Seed Data Awal                                           │
echo     │   [6] 📦 Install NPM Dependencies                                 │
echo     │   [7] 🔨 Build Assets                                             │
echo     │   [8] 🔗 Buat Storage Link                                        │
echo     │                                                                    │
echo     │   [0] ◀️  Kembali ke Menu Utama                                    │
echo     │                                                                    │
echo     └────────────────────────────────────────────────────────────────────┘
echo.
set /p MANUAL_CHOICE="     Pilih langkah [0-8]: "

if "%MANUAL_CHOICE%"=="1" goto MANUAL_ENV
if "%MANUAL_CHOICE%"=="2" goto MANUAL_COMPOSER
if "%MANUAL_CHOICE%"=="3" goto MANUAL_KEY
if "%MANUAL_CHOICE%"=="4" goto MANUAL_MIGRATE
if "%MANUAL_CHOICE%"=="5" goto MANUAL_SEED
if "%MANUAL_CHOICE%"=="6" goto MANUAL_NPM
if "%MANUAL_CHOICE%"=="7" goto MANUAL_BUILD
if "%MANUAL_CHOICE%"=="8" goto MANUAL_STORAGE
if "%MANUAL_CHOICE%"=="0" goto MAIN_MENU
goto MANUAL_MENU

:MANUAL_ENV
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Membuat File .env                                            ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
if not exist .env (
    copy .env.example .env >nul
    echo     ✅ File .env berhasil dibuat dari .env.example
) else (
    echo     ⏭️  File .env sudah ada
)
echo.
pause
goto MANUAL_MENU

:MANUAL_COMPOSER
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Install Composer Dependencies                                ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
call composer install
echo.
echo     ✅ Selesai
pause
goto MANUAL_MENU

:MANUAL_KEY
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Generate Application Key                                     ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
php artisan key:generate
echo.
echo     ✅ Selesai
pause
goto MANUAL_MENU

:MANUAL_MIGRATE
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Setup Database (Migrasi)                                     ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
if not exist database\database.sqlite (
    echo. > database\database.sqlite
    echo     ✅ File database SQLite dibuat
)
php artisan migrate
echo.
echo     ✅ Selesai
pause
goto MANUAL_MENU

:MANUAL_SEED
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Seed Data Awal                                               ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
echo     Pilih seeder:
echo     [1] Semua seeder
echo     [2] Admin User saja
echo     [3] Roles saja
echo     [4] Settings saja
echo     [0] Batal
echo.
set /p SEED_CHOICE="     Pilih [0-4]: "

if "%SEED_CHOICE%"=="1" php artisan db:seed
if "%SEED_CHOICE%"=="2" php artisan db:seed --class=AdminUserSeeder
if "%SEED_CHOICE%"=="3" php artisan db:seed --class=RolesSeeder
if "%SEED_CHOICE%"=="4" php artisan db:seed --class=SettingsSeeder
if "%SEED_CHOICE%"=="0" goto MANUAL_MENU
echo.
echo     ✅ Selesai
pause
goto MANUAL_MENU

:MANUAL_NPM
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Install NPM Dependencies                                     ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
call npm install
echo.
echo     ✅ Selesai
pause
goto MANUAL_MENU

:MANUAL_BUILD
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Build Assets                                                 ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
call npm run build
echo.
echo     ✅ Selesai
pause
goto MANUAL_MENU

:MANUAL_STORAGE
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Buat Storage Link                                            ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
php artisan storage:link
echo.
echo     ✅ Selesai
pause
goto MANUAL_MENU

:TOOLS_MENU
cls
echo.
echo  ╔══════════════════════════════════════════════════════════════════════════╗
echo  ║                        TOOLS ^& UTILITIES                                 ║
echo  ╚══════════════════════════════════════════════════════════════════════════╝
echo.
echo     ┌────────────────────────────────────────────────────────────────────┐
echo     │                                                                    │
echo     │   [1] 🧹 Clear All Cache                                          │
echo     │   [2] 🔄 Fresh Migration (Reset Database)                         │
echo     │   [3] 📊 Lihat Status Migrasi                                     │
echo     │   [4] 📋 Lihat Daftar Route                                       │
echo     │   [5] ⚡ Optimize untuk Production                                │
echo     │   [6] 🔧 Laravel Tinker (Console)                                 │
echo     │                                                                    │
echo     │   [0] ◀️  Kembali ke Menu Utama                                    │
echo     │                                                                    │
echo     └────────────────────────────────────────────────────────────────────┘
echo.
set /p TOOLS_CHOICE="     Pilih tools [0-6]: "

if "%TOOLS_CHOICE%"=="1" goto TOOL_CLEAR
if "%TOOLS_CHOICE%"=="2" goto TOOL_FRESH
if "%TOOLS_CHOICE%"=="3" goto TOOL_MIGRATE_STATUS
if "%TOOLS_CHOICE%"=="4" goto TOOL_ROUTES
if "%TOOLS_CHOICE%"=="5" goto TOOL_OPTIMIZE
if "%TOOLS_CHOICE%"=="6" goto TOOL_TINKER
if "%TOOLS_CHOICE%"=="0" goto MAIN_MENU
goto TOOLS_MENU

:TOOL_CLEAR
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Clear All Cache                                              ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
php artisan optimize:clear
echo.
echo     ✅ Semua cache berhasil dibersihkan
pause
goto TOOLS_MENU

:TOOL_FRESH
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Fresh Migration (Reset Database)                             ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
echo     ⚠️  PERINGATAN: Semua data di database akan DIHAPUS!
echo.
set /p CONFIRM_FRESH="     Yakin ingin melanjutkan? (ketik 'yes' untuk konfirmasi): "
if /i "%CONFIRM_FRESH%"=="yes" (
    php artisan migrate:fresh --seed
    echo.
    echo     ✅ Database berhasil di-reset
) else (
    echo     ❌ Dibatalkan
)
pause
goto TOOLS_MENU

:TOOL_MIGRATE_STATUS
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Status Migrasi                                               ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
php artisan migrate:status
echo.
pause
goto TOOLS_MENU

:TOOL_ROUTES
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Daftar Route                                                 ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
php artisan route:list
echo.
pause
goto TOOLS_MENU

:TOOL_OPTIMIZE
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Optimize untuk Production                                    ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
php artisan optimize
echo.
echo     ✅ Aplikasi telah dioptimasi untuk production
pause
goto TOOLS_MENU

:TOOL_TINKER
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Laravel Tinker                                               ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
echo     Ketik 'exit' untuk keluar dari Tinker
echo.
php artisan tinker
goto TOOLS_MENU

:RUN_APP
cls
echo.
echo  ╔══════════════════════════════════════════════════════════════════════════╗
echo  ║                       JALANKAN APLIKASI                                  ║
echo  ╚══════════════════════════════════════════════════════════════════════════╝
echo.
echo     Pilih mode:
echo.
echo     ┌────────────────────────────────────────────────────────────────────┐
echo     │                                                                    │
echo     │   [1] 🚀 Development Mode (dengan hot reload)                     │
echo     │       Server + Vite dev server berjalan bersamaan                 │
echo     │                                                                    │
echo     │   [2] 🌐 Production Mode (server saja)                            │
echo     │       Hanya menjalankan PHP server                                │
echo     │                                                                    │
echo     │   [0] ◀️  Kembali                                                  │
echo     │                                                                    │
echo     └────────────────────────────────────────────────────────────────────┘
echo.
set /p RUN_CHOICE="     Pilih mode [0-2]: "

if "%RUN_CHOICE%"=="1" goto RUN_DEV
if "%RUN_CHOICE%"=="2" goto RUN_PROD
if "%RUN_CHOICE%"=="0" goto MAIN_MENU
goto RUN_APP

:RUN_DEV
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Development Mode                                             ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
echo     🌐 Server akan berjalan di: http://localhost:8000
echo     🔥 Hot reload aktif untuk perubahan CSS/JS
echo.
echo     Tekan Ctrl+C untuk menghentikan server
echo.
call composer dev
goto MAIN_MENU

:RUN_PROD
cls
echo.
echo     ╔════════════════════════════════════════════════════════════════╗
echo     ║  Production Mode                                              ║
echo     ╚════════════════════════════════════════════════════════════════╝
echo.
echo     🌐 Server berjalan di: http://localhost:8000
echo.
echo     Tekan Ctrl+C untuk menghentikan server
echo.
php artisan serve
goto MAIN_MENU

:EXIT_APP
cls
echo.
echo  ╔══════════════════════════════════════════════════════════════════════════╗
echo  ║                                                                          ║
echo  ║   Terima kasih telah menggunakan Prosiding Conference System!           ║
echo  ║                                                                          ║
echo  ║   Jika ada pertanyaan, silakan hubungi tim support.                     ║
echo  ║                                                                          ║
echo  ╚══════════════════════════════════════════════════════════════════════════╝
echo.
timeout /t 2 >nul
exit /b 0
