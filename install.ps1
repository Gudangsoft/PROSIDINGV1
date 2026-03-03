# ============================================
# Prosiding Conference System - Installer
# PowerShell Version (Modern UI)
# ============================================

$Host.UI.RawUI.WindowTitle = "Prosiding Conference System - Installer"

# Colors
$script:Colors = @{
    Primary   = "Cyan"
    Success   = "Green"
    Warning   = "Yellow"
    Error     = "Red"
    Info      = "White"
    Highlight = "Magenta"
}

function Show-Banner {
    Clear-Host
    Write-Host ""
    Write-Host "  ╔══════════════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Primary
    Write-Host "  ║                                                                          ║" -ForegroundColor $Colors.Primary
    Write-Host "  ║   ██████╗ ██████╗  ██████╗ ███████╗██╗██████╗ ██╗███╗   ██╗ ██████╗      ║" -ForegroundColor $Colors.Primary
    Write-Host "  ║   ██╔══██╗██╔══██╗██╔═══██╗██╔════╝██║██╔══██╗██║████╗  ██║██╔════╝      ║" -ForegroundColor $Colors.Primary
    Write-Host "  ║   ██████╔╝██████╔╝██║   ██║███████╗██║██║  ██║██║██╔██╗ ██║██║  ███╗     ║" -ForegroundColor $Colors.Primary
    Write-Host "  ║   ██╔═══╝ ██╔══██╗██║   ██║╚════██║██║██║  ██║██║██║╚██╗██║██║   ██║     ║" -ForegroundColor $Colors.Primary
    Write-Host "  ║   ██║     ██║  ██║╚██████╔╝███████║██║██████╔╝██║██║ ╚████║╚██████╔╝     ║" -ForegroundColor $Colors.Primary
    Write-Host "  ║   ╚═╝     ╚═╝  ╚═╝ ╚═════╝ ╚══════╝╚═╝╚═════╝ ╚═╝╚═╝  ╚═══╝ ╚═════╝     ║" -ForegroundColor $Colors.Primary
    Write-Host "  ║                                                                          ║" -ForegroundColor $Colors.Primary
    Write-Host "  ║              Conference Management System - Installer                    ║" -ForegroundColor $Colors.Highlight
    Write-Host "  ║                                                                          ║" -ForegroundColor $Colors.Primary
    Write-Host "  ╚══════════════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Primary
    Write-Host ""
}

function Write-Step {
    param([string]$Step, [string]$Total, [string]$Message)
    Write-Host ""
    Write-Host "     ╔════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Primary
    Write-Host "     ║  LANGKAH $Step/$Total`: $($Message.PadRight(46))║" -ForegroundColor $Colors.Primary
    Write-Host "     ╚════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Primary
    Write-Host ""
}

function Write-Status {
    param([string]$Status, [string]$Message)
    switch ($Status) {
        "OK"      { Write-Host "     ✅ $Message" -ForegroundColor $Colors.Success }
        "SKIP"    { Write-Host "     ⏭️  $Message" -ForegroundColor $Colors.Warning }
        "ERROR"   { Write-Host "     ❌ $Message" -ForegroundColor $Colors.Error }
        "INFO"    { Write-Host "     ℹ️  $Message" -ForegroundColor $Colors.Info }
        "WAIT"    { Write-Host "     ⏳ $Message" -ForegroundColor $Colors.Warning }
    }
}

function Test-Requirements {
    $allPassed = $true
    
    # Check PHP
    Write-Host "     Memeriksa PHP..." -ForegroundColor $Colors.Info
    if (Get-Command php -ErrorAction SilentlyContinue) {
        $phpVersion = (php -v | Select-Object -First 1) -replace "PHP ([0-9.]+).*", '$1'
        Write-Status "OK" "PHP $phpVersion terdeteksi"
    } else {
        Write-Status "ERROR" "PHP tidak ditemukan! Download: https://windows.php.net/download/"
        $allPassed = $false
    }
    
    # Check Composer
    Write-Host "     Memeriksa Composer..." -ForegroundColor $Colors.Info
    if (Get-Command composer -ErrorAction SilentlyContinue) {
        Write-Status "OK" "Composer terdeteksi"
    } else {
        Write-Status "ERROR" "Composer tidak ditemukan! Download: https://getcomposer.org/"
        $allPassed = $false
    }
    
    # Check Node.js
    Write-Host "     Memeriksa Node.js..." -ForegroundColor $Colors.Info
    if (Get-Command node -ErrorAction SilentlyContinue) {
        $nodeVersion = node -v
        Write-Status "OK" "Node.js $nodeVersion terdeteksi"
    } else {
        Write-Status "ERROR" "Node.js tidak ditemukan! Download: https://nodejs.org/"
        $allPassed = $false
    }
    
    # Check NPM
    Write-Host "     Memeriksa NPM..." -ForegroundColor $Colors.Info
    if (Get-Command npm -ErrorAction SilentlyContinue) {
        $npmVersion = npm -v
        Write-Status "OK" "NPM $npmVersion terdeteksi"
    } else {
        Write-Status "ERROR" "NPM tidak ditemukan!"
        $allPassed = $false
    }
    
    return $allPassed
}

function Show-MainMenu {
    Show-Banner
    Write-Host "     Selamat datang di Installer Prosiding Conference System!" -ForegroundColor $Colors.Info
    Write-Host "     Pilih menu di bawah ini untuk memulai:" -ForegroundColor $Colors.Info
    Write-Host ""
    Write-Host "     ┌────────────────────────────────────────────────────────────────────┐" -ForegroundColor $Colors.Primary
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   [1] 🚀 Install Otomatis (Recommended)                           │" -ForegroundColor $Colors.Success
    Write-Host "     │       Install semua dependensi dan setup database otomatis        │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   [2] 📦 Install Manual (Step by Step)                            │" -ForegroundColor $Colors.Warning
    Write-Host "     │       Pilih langkah instalasi satu per satu                       │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   [3] 🔧 Tools & Utilities                                        │" -ForegroundColor $Colors.Highlight
    Write-Host "     │       Clear cache, reset database, dll                            │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   [4] ▶️  Jalankan Aplikasi                                        │" -ForegroundColor $Colors.Primary
    Write-Host "     │       Mulai server development                                    │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   [5] ❓ Cek Persyaratan Sistem                                   │" -ForegroundColor $Colors.Info
    Write-Host "     │       Pastikan sistem Anda siap untuk instalasi                   │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   [0] 🚪 Keluar                                                   │" -ForegroundColor $Colors.Error
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     └────────────────────────────────────────────────────────────────────┘" -ForegroundColor $Colors.Primary
    Write-Host ""
    
    $choice = Read-Host "     Pilih menu [0-5]"
    return $choice
}

function Start-AutoInstall {
    Show-Banner
    Write-Host "     ╔════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Primary
    Write-Host "     ║                    INSTALASI OTOMATIS                          ║" -ForegroundColor $Colors.Primary
    Write-Host "     ╚════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Primary
    Write-Host ""
    Write-Host "     Proses instalasi akan dimulai secara otomatis." -ForegroundColor $Colors.Info
    Write-Host "     Pastikan koneksi internet Anda stabil." -ForegroundColor $Colors.Warning
    Write-Host ""
    
    $confirm = Read-Host "     Lanjutkan instalasi? (y/n)"
    if ($confirm -ne "y") { return }
    
    # Step 1: Check Requirements
    Write-Step "1" "8" "Memeriksa Persyaratan Sistem"
    if (-not (Test-Requirements)) {
        Write-Host ""
        Write-Status "ERROR" "Persyaratan sistem tidak terpenuhi!"
        Read-Host "     Tekan Enter untuk kembali"
        return
    }
    
    # Step 2: Create .env
    Write-Step "2" "8" "Membuat File Environment"
    if (-not (Test-Path ".env")) {
        if (Test-Path ".env.example") {
            Copy-Item ".env.example" ".env"
            Write-Status "OK" "File .env berhasil dibuat"
        } else {
            Write-Status "ERROR" "File .env.example tidak ditemukan!"
            Read-Host "     Tekan Enter untuk kembali"
            return
        }
    } else {
        Write-Status "SKIP" "File .env sudah ada"
    }
    
    # Step 3: Composer Install
    Write-Step "3" "8" "Install Composer Dependencies"
    Write-Status "WAIT" "Menginstall PHP dependencies... (harap tunggu)"
    composer install --no-interaction
    Write-Status "OK" "Composer dependencies berhasil diinstall"
    
    # Step 4: Generate Key
    Write-Step "4" "8" "Generate Application Key"
    php artisan key:generate --force
    Write-Status "OK" "Application key berhasil di-generate"
    
    # Step 5: Database
    Write-Step "5" "8" "Setup Database"
    if (-not (Test-Path "database\database.sqlite")) {
        New-Item -ItemType File -Path "database\database.sqlite" -Force | Out-Null
        Write-Status "OK" "File database SQLite berhasil dibuat"
    } else {
        Write-Status "SKIP" "File database SQLite sudah ada"
    }
    Write-Status "WAIT" "Menjalankan migrasi database..."
    php artisan migrate --force
    Write-Status "OK" "Migrasi database berhasil"
    
    # Step 6: Seeding
    Write-Step "6" "8" "Seed Data Awal"
    $doSeed = Read-Host "     Isi data contoh (admin user, settings)? (y/n)"
    if ($doSeed -eq "y") {
        php artisan db:seed --force
        Write-Status "OK" "Data awal berhasil ditambahkan"
    } else {
        Write-Status "SKIP" "Seeding dilewati"
    }
    
    # Step 7: NPM Install
    Write-Step "7" "8" "Install NPM Dependencies"
    Write-Status "WAIT" "Menginstall Node.js dependencies... (harap tunggu)"
    npm install
    Write-Status "OK" "NPM dependencies berhasil diinstall"
    
    # Step 8: Build Assets
    Write-Step "8" "8" "Build Assets"
    Write-Status "WAIT" "Melakukan build assets... (harap tunggu)"
    npm run build
    Write-Status "OK" "Assets berhasil di-build"
    
    # Final setup
    php artisan storage:link 2>$null
    php artisan optimize:clear 2>$null
    
    # Success message
    Clear-Host
    Write-Host ""
    Write-Host "  ╔══════════════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Success
    Write-Host "  ║                                                                          ║" -ForegroundColor $Colors.Success
    Write-Host "  ║               ✅ INSTALASI BERHASIL! ✅                                  ║" -ForegroundColor $Colors.Success
    Write-Host "  ║                                                                          ║" -ForegroundColor $Colors.Success
    Write-Host "  ╚══════════════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Success
    Write-Host ""
    Write-Host "     ┌────────────────────────────────────────────────────────────────────┐" -ForegroundColor $Colors.Primary
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   🌐 URL Aplikasi : http://localhost:8000                         │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   📧 Akun Default (jika seeder dijalankan):                       │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │      Admin    : admin@prosiding.test    / password                │" -ForegroundColor $Colors.Warning
    Write-Host "     │      Editor   : editor@prosiding.test   / password                │" -ForegroundColor $Colors.Warning
    Write-Host "     │      Reviewer : reviewer@prosiding.test / password                │" -ForegroundColor $Colors.Warning
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   ⚠️  PENTING: Segera ubah password setelah login pertama!        │" -ForegroundColor $Colors.Error
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     └────────────────────────────────────────────────────────────────────┘" -ForegroundColor $Colors.Primary
    Write-Host ""
    Read-Host "     Tekan Enter untuk kembali ke menu utama"
}

function Show-ManualMenu {
    while ($true) {
        Show-Banner
        Write-Host "     ╔════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Primary
        Write-Host "     ║                    INSTALASI MANUAL                            ║" -ForegroundColor $Colors.Primary
        Write-Host "     ╚════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Primary
        Write-Host ""
        Write-Host "     ┌────────────────────────────────────────────────────────────────────┐" -ForegroundColor $Colors.Primary
        Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
        Write-Host "     │   [1] 📄 Buat File .env                                           │" -ForegroundColor $Colors.Info
        Write-Host "     │   [2] 📦 Install Composer Dependencies                            │" -ForegroundColor $Colors.Info
        Write-Host "     │   [3] 🔑 Generate Application Key                                 │" -ForegroundColor $Colors.Info
        Write-Host "     │   [4] 🗃️  Setup Database (Migrasi)                                 │" -ForegroundColor $Colors.Info
        Write-Host "     │   [5] 🌱 Seed Data Awal                                           │" -ForegroundColor $Colors.Info
        Write-Host "     │   [6] 📦 Install NPM Dependencies                                 │" -ForegroundColor $Colors.Info
        Write-Host "     │   [7] 🔨 Build Assets                                             │" -ForegroundColor $Colors.Info
        Write-Host "     │   [8] 🔗 Buat Storage Link                                        │" -ForegroundColor $Colors.Info
        Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
        Write-Host "     │   [0] ◀️  Kembali ke Menu Utama                                    │" -ForegroundColor $Colors.Warning
        Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
        Write-Host "     └────────────────────────────────────────────────────────────────────┘" -ForegroundColor $Colors.Primary
        Write-Host ""
        
        $choice = Read-Host "     Pilih langkah [0-8]"
        
        switch ($choice) {
            "1" {
                if (-not (Test-Path ".env")) {
                    Copy-Item ".env.example" ".env"
                    Write-Status "OK" "File .env berhasil dibuat"
                } else {
                    Write-Status "SKIP" "File .env sudah ada"
                }
                Read-Host "     Tekan Enter"
            }
            "2" { composer install; Read-Host "     Tekan Enter" }
            "3" { php artisan key:generate; Read-Host "     Tekan Enter" }
            "4" {
                if (-not (Test-Path "database\database.sqlite")) {
                    New-Item -ItemType File -Path "database\database.sqlite" -Force | Out-Null
                }
                php artisan migrate
                Read-Host "     Tekan Enter"
            }
            "5" { php artisan db:seed; Read-Host "     Tekan Enter" }
            "6" { npm install; Read-Host "     Tekan Enter" }
            "7" { npm run build; Read-Host "     Tekan Enter" }
            "8" { php artisan storage:link; Read-Host "     Tekan Enter" }
            "0" { return }
        }
    }
}

function Show-ToolsMenu {
    while ($true) {
        Show-Banner
        Write-Host "     ╔════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Primary
        Write-Host "     ║                    TOOLS & UTILITIES                           ║" -ForegroundColor $Colors.Primary
        Write-Host "     ╚════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Primary
        Write-Host ""
        Write-Host "     ┌────────────────────────────────────────────────────────────────────┐" -ForegroundColor $Colors.Primary
        Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
        Write-Host "     │   [1] 🧹 Clear All Cache                                          │" -ForegroundColor $Colors.Info
        Write-Host "     │   [2] 🔄 Fresh Migration (Reset Database)                         │" -ForegroundColor $Colors.Error
        Write-Host "     │   [3] 📊 Lihat Status Migrasi                                     │" -ForegroundColor $Colors.Info
        Write-Host "     │   [4] 📋 Lihat Daftar Route                                       │" -ForegroundColor $Colors.Info
        Write-Host "     │   [5] ⚡ Optimize untuk Production                                │" -ForegroundColor $Colors.Info
        Write-Host "     │   [6] 🔧 Laravel Tinker (Console)                                 │" -ForegroundColor $Colors.Highlight
        Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
        Write-Host "     │   [0] ◀️  Kembali ke Menu Utama                                    │" -ForegroundColor $Colors.Warning
        Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
        Write-Host "     └────────────────────────────────────────────────────────────────────┘" -ForegroundColor $Colors.Primary
        Write-Host ""
        
        $choice = Read-Host "     Pilih tools [0-6]"
        
        switch ($choice) {
            "1" { php artisan optimize:clear; Write-Status "OK" "Cache dibersihkan"; Read-Host "     Tekan Enter" }
            "2" {
                Write-Host ""
                Write-Host "     ⚠️  PERINGATAN: Semua data di database akan DIHAPUS!" -ForegroundColor $Colors.Error
                $confirm = Read-Host "     Ketik 'yes' untuk konfirmasi"
                if ($confirm -eq "yes") {
                    php artisan migrate:fresh --seed
                    Write-Status "OK" "Database berhasil di-reset"
                } else {
                    Write-Status "SKIP" "Dibatalkan"
                }
                Read-Host "     Tekan Enter"
            }
            "3" { php artisan migrate:status; Read-Host "     Tekan Enter" }
            "4" { php artisan route:list; Read-Host "     Tekan Enter" }
            "5" { php artisan optimize; Write-Status "OK" "Aplikasi dioptimasi"; Read-Host "     Tekan Enter" }
            "6" { php artisan tinker }
            "0" { return }
        }
    }
}

function Show-RunMenu {
    Show-Banner
    Write-Host "     ╔════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Primary
    Write-Host "     ║                    JALANKAN APLIKASI                           ║" -ForegroundColor $Colors.Primary
    Write-Host "     ╚════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Primary
    Write-Host ""
    Write-Host "     ┌────────────────────────────────────────────────────────────────────┐" -ForegroundColor $Colors.Primary
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   [1] 🚀 Development Mode (dengan hot reload)                     │" -ForegroundColor $Colors.Success
    Write-Host "     │       Server + Vite dev server berjalan bersamaan                 │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   [2] 🌐 Production Mode (server saja)                            │" -ForegroundColor $Colors.Warning
    Write-Host "     │       Hanya menjalankan PHP server                                │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     │   [0] ◀️  Kembali                                                  │" -ForegroundColor $Colors.Info
    Write-Host "     │                                                                    │" -ForegroundColor $Colors.Primary
    Write-Host "     └────────────────────────────────────────────────────────────────────┘" -ForegroundColor $Colors.Primary
    Write-Host ""
    
    $choice = Read-Host "     Pilih mode [0-2]"
    
    switch ($choice) {
        "1" {
            Write-Host ""
            Write-Host "     🌐 Server akan berjalan di: http://localhost:8000" -ForegroundColor $Colors.Success
            Write-Host "     🔥 Hot reload aktif untuk perubahan CSS/JS" -ForegroundColor $Colors.Warning
            Write-Host "     Tekan Ctrl+C untuk menghentikan server" -ForegroundColor $Colors.Info
            Write-Host ""
            composer dev
        }
        "2" {
            Write-Host ""
            Write-Host "     🌐 Server berjalan di: http://localhost:8000" -ForegroundColor $Colors.Success
            Write-Host "     Tekan Ctrl+C untuk menghentikan server" -ForegroundColor $Colors.Info
            Write-Host ""
            php artisan serve
        }
    }
}

function Show-CheckRequirements {
    Show-Banner
    Write-Host "     ╔════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Primary
    Write-Host "     ║                  CEK PERSYARATAN SISTEM                        ║" -ForegroundColor $Colors.Primary
    Write-Host "     ╚════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Primary
    Write-Host ""
    Write-Host "     Memeriksa persyaratan sistem..." -ForegroundColor $Colors.Info
    Write-Host ""
    
    $passed = Test-Requirements
    
    Write-Host ""
    if ($passed) {
        Write-Host "     ╔════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Success
        Write-Host "     ║  ✅ SEMUA PERSYARATAN TERPENUHI! Sistem siap untuk instalasi  ║" -ForegroundColor $Colors.Success
        Write-Host "     ╚════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Success
    } else {
        Write-Host "     ╔════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Error
        Write-Host "     ║  ❌ BEBERAPA PERSYARATAN BELUM TERPENUHI                       ║" -ForegroundColor $Colors.Error
        Write-Host "     ║     Silakan install software yang diperlukan terlebih dahulu   ║" -ForegroundColor $Colors.Error
        Write-Host "     ╚════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Error
    }
    Write-Host ""
    Read-Host "     Tekan Enter untuk kembali"
}

# Main Loop
while ($true) {
    $choice = Show-MainMenu
    
    switch ($choice) {
        "1" { Start-AutoInstall }
        "2" { Show-ManualMenu }
        "3" { Show-ToolsMenu }
        "4" { Show-RunMenu }
        "5" { Show-CheckRequirements }
        "0" {
            Clear-Host
            Write-Host ""
            Write-Host "  ╔══════════════════════════════════════════════════════════════════════════╗" -ForegroundColor $Colors.Primary
            Write-Host "  ║                                                                          ║" -ForegroundColor $Colors.Primary
            Write-Host "  ║   Terima kasih telah menggunakan Prosiding Conference System!           ║" -ForegroundColor $Colors.Success
            Write-Host "  ║                                                                          ║" -ForegroundColor $Colors.Primary
            Write-Host "  ╚══════════════════════════════════════════════════════════════════════════╝" -ForegroundColor $Colors.Primary
            Write-Host ""
            Start-Sleep -Seconds 2
            exit
        }
    }
}
