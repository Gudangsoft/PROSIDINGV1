@echo off
setlocal enabledelayedexpansion

:: ============================================
:: Setup Script - Prosiding Conference System
:: For Windows
:: ============================================

echo.
echo ============================================
echo   Prosiding Conference Management System
echo   Installation Script for Windows
echo ============================================
echo.

:: Check if PHP is installed
where php >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] PHP tidak ditemukan!
    echo Silakan install PHP terlebih dahulu.
    echo Download: https://windows.php.net/download/
    pause
    exit /b 1
)

:: Check PHP version
for /f "tokens=2 delims= " %%i in ('php -v 2^>nul ^| findstr /i "^PHP"') do set PHP_VERSION=%%i
echo [OK] PHP ditemukan: %PHP_VERSION%

:: Check if Composer is installed
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Composer tidak ditemukan!
    echo Silakan install Composer terlebih dahulu.
    echo Download: https://getcomposer.org/download/
    pause
    exit /b 1
)
echo [OK] Composer ditemukan

:: Check if Node.js is installed
where node >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Node.js tidak ditemukan!
    echo Silakan install Node.js terlebih dahulu.
    echo Download: https://nodejs.org/
    pause
    exit /b 1
)

for /f "tokens=*" %%i in ('node -v') do set NODE_VERSION=%%i
echo [OK] Node.js ditemukan: %NODE_VERSION%

:: Check if NPM is installed
where npm >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] NPM tidak ditemukan!
    pause
    exit /b 1
)

for /f "tokens=*" %%i in ('npm -v') do set NPM_VERSION=%%i
echo [OK] NPM ditemukan: %NPM_VERSION%

echo.
echo ============================================
echo   Langkah 1: Setup Environment File
echo ============================================
echo.

:: Copy .env.example to .env if not exists
if not exist .env (
    if exist .env.example (
        copy .env.example .env >nul
        echo [OK] File .env berhasil dibuat dari .env.example
    ) else (
        echo [ERROR] File .env.example tidak ditemukan!
        pause
        exit /b 1
    )
) else (
    echo [SKIP] File .env sudah ada
)

echo.
echo ============================================
echo   Langkah 2: Install Composer Dependencies
echo ============================================
echo.

call composer install
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Gagal install Composer dependencies!
    pause
    exit /b 1
)
echo [OK] Composer dependencies berhasil diinstall

echo.
echo ============================================
echo   Langkah 3: Generate Application Key
echo ============================================
echo.

:: Check if APP_KEY is empty
findstr /C:"APP_KEY=$" .env >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    php artisan key:generate
    echo [OK] Application key berhasil di-generate
) else (
    findstr /C:"APP_KEY=" .env | findstr /V /C:"APP_KEY=base64" >nul 2>nul
    if %ERRORLEVEL% EQU 0 (
        php artisan key:generate
        echo [OK] Application key berhasil di-generate
    ) else (
        echo [SKIP] Application key sudah ada
    )
)

echo.
echo ============================================
echo   Langkah 4: Setup Database
echo ============================================
echo.

:: Create SQLite database if using SQLite
findstr /C:"DB_CONNECTION=sqlite" .env >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    if not exist database\database.sqlite (
        echo. > database\database.sqlite
        echo [OK] File database SQLite berhasil dibuat
    ) else (
        echo [SKIP] File database SQLite sudah ada
    )
)

:: Run migrations
echo [INFO] Menjalankan migrasi database...
php artisan migrate --force
if %ERRORLEVEL% NEQ 0 (
    echo [WARNING] Migrasi mungkin sudah pernah dijalankan sebelumnya
) else (
    echo [OK] Migrasi database berhasil
)

echo.
echo ============================================
echo   Langkah 5: Create Storage Link
echo ============================================
echo.

php artisan storage:link 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [SKIP] Storage link sudah ada
) else (
    echo [OK] Storage link berhasil dibuat
)

echo.
echo ============================================
echo   Langkah 6: Seed Database
echo ============================================
echo.

set /p SEED_DB="Apakah ingin mengisi data awal (seeder)? (y/n): "
if /i "%SEED_DB%"=="y" (
    php artisan db:seed --force
    if %ERRORLEVEL% NEQ 0 (
        echo [WARNING] Beberapa seeder mungkin sudah pernah dijalankan
    ) else (
        echo [OK] Database seeding berhasil
    )
) else (
    echo [SKIP] Database seeding dilewati
)

echo.
echo ============================================
echo   Langkah 7: Install NPM Dependencies
echo ============================================
echo.

call npm install
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Gagal install NPM dependencies!
    pause
    exit /b 1
)
echo [OK] NPM dependencies berhasil diinstall

echo.
echo ============================================
echo   Langkah 8: Build Assets
echo ============================================
echo.

call npm run build
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Gagal build assets!
    pause
    exit /b 1
)
echo [OK] Assets berhasil di-build

echo.
echo ============================================
echo   Langkah 9: Clear Cache
echo ============================================
echo.

php artisan optimize:clear
echo [OK] Cache berhasil dibersihkan

echo.
echo ============================================
echo   INSTALASI SELESAI!
echo ============================================
echo.
echo Aplikasi siap dijalankan.
echo.
echo Untuk menjalankan dalam mode development:
echo   composer dev
echo.
echo Atau jalankan secara manual:
echo   php artisan serve
echo   npm run dev  (di terminal terpisah)
echo.
echo Akses aplikasi di: http://localhost:8000
echo.
echo Akun default (jika seeder dijalankan):
echo   Admin    : admin@prosiding.test / password
echo   Editor   : editor@prosiding.test / password
echo   Reviewer : reviewer@prosiding.test / password
echo.
echo PENTING: Segera ubah password default setelah login!
echo.

pause
