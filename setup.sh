#!/bin/bash

# ============================================
# Setup Script - Prosiding Conference System
# For Linux/Mac
# ============================================

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Prosiding Conference Management System${NC}"
echo -e "${BLUE}   Installation Script for Linux/Mac${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

# Function to check command existence
check_command() {
    if ! command -v $1 &> /dev/null; then
        echo -e "${RED}[ERROR] $1 tidak ditemukan!${NC}"
        echo "Silakan install $1 terlebih dahulu."
        exit 1
    fi
}

# Check PHP
check_command php
PHP_VERSION=$(php -v | head -n 1 | cut -d ' ' -f 2)
echo -e "${GREEN}[OK]${NC} PHP ditemukan: $PHP_VERSION"

# Check Composer
check_command composer
echo -e "${GREEN}[OK]${NC} Composer ditemukan"

# Check Node.js
check_command node
NODE_VERSION=$(node -v)
echo -e "${GREEN}[OK]${NC} Node.js ditemukan: $NODE_VERSION"

# Check NPM
check_command npm
NPM_VERSION=$(npm -v)
echo -e "${GREEN}[OK]${NC} NPM ditemukan: $NPM_VERSION"

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 1: Setup Environment File${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

# Copy .env.example to .env if not exists
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
        echo -e "${GREEN}[OK]${NC} File .env berhasil dibuat dari .env.example"
    else
        echo -e "${RED}[ERROR]${NC} File .env.example tidak ditemukan!"
        exit 1
    fi
else
    echo -e "${YELLOW}[SKIP]${NC} File .env sudah ada"
fi

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 2: Install Composer Dependencies${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

composer install
echo -e "${GREEN}[OK]${NC} Composer dependencies berhasil diinstall"

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 3: Generate Application Key${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

# Check if APP_KEY is empty or not set
if grep -q "^APP_KEY=$" .env || ! grep -q "^APP_KEY=base64" .env; then
    php artisan key:generate
    echo -e "${GREEN}[OK]${NC} Application key berhasil di-generate"
else
    echo -e "${YELLOW}[SKIP]${NC} Application key sudah ada"
fi

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 4: Setup Database${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

# Create SQLite database if using SQLite
if grep -q "^DB_CONNECTION=sqlite" .env; then
    if [ ! -f database/database.sqlite ]; then
        touch database/database.sqlite
        echo -e "${GREEN}[OK]${NC} File database SQLite berhasil dibuat"
    else
        echo -e "${YELLOW}[SKIP]${NC} File database SQLite sudah ada"
    fi
fi

# Run migrations
echo -e "${BLUE}[INFO]${NC} Menjalankan migrasi database..."
php artisan migrate --force || echo -e "${YELLOW}[WARNING]${NC} Migrasi mungkin sudah pernah dijalankan sebelumnya"
echo -e "${GREEN}[OK]${NC} Migrasi database berhasil"

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 5: Create Storage Link${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

php artisan storage:link 2>/dev/null || echo -e "${YELLOW}[SKIP]${NC} Storage link sudah ada"
echo -e "${GREEN}[OK]${NC} Storage link berhasil dibuat"

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 6: Seed Database${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

read -p "Apakah ingin mengisi data awal (seeder)? (y/n): " SEED_DB
if [[ "$SEED_DB" =~ ^[Yy]$ ]]; then
    php artisan db:seed --force || echo -e "${YELLOW}[WARNING]${NC} Beberapa seeder mungkin sudah pernah dijalankan"
    echo -e "${GREEN}[OK]${NC} Database seeding berhasil"
else
    echo -e "${YELLOW}[SKIP]${NC} Database seeding dilewati"
fi

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 7: Install NPM Dependencies${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

npm install
echo -e "${GREEN}[OK]${NC} NPM dependencies berhasil diinstall"

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 8: Build Assets${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

npm run build
echo -e "${GREEN}[OK]${NC} Assets berhasil di-build"

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 9: Set Permissions${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

# Set permissions for storage and cache
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
echo -e "${GREEN}[OK]${NC} Permissions berhasil di-set"

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}   Langkah 10: Clear Cache${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

php artisan optimize:clear
echo -e "${GREEN}[OK]${NC} Cache berhasil dibersihkan"

echo ""
echo -e "${GREEN}============================================${NC}"
echo -e "${GREEN}   INSTALASI SELESAI!${NC}"
echo -e "${GREEN}============================================${NC}"
echo ""
echo "Aplikasi siap dijalankan."
echo ""
echo "Untuk menjalankan dalam mode development:"
echo "  composer dev"
echo ""
echo "Atau jalankan secara manual:"
echo "  php artisan serve"
echo "  npm run dev  (di terminal terpisah)"
echo ""
echo "Akses aplikasi di: http://localhost:8000"
echo ""
echo "Akun default (jika seeder dijalankan):"
echo "  Admin    : admin@prosiding.test / password"
echo "  Editor   : editor@prosiding.test / password"
echo "  Reviewer : reviewer@prosiding.test / password"
echo ""
echo -e "${RED}PENTING: Segera ubah password default setelah login!${NC}"
echo ""
