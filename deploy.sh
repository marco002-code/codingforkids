#!/usr/bin/env bash
# ==============================================================================
# Script Otomasi Deployment Laravel - Production Ready (Auto Git Pull)
# Aplikasi      : Coding for Kids & A.I. for Learning
# Penyelenggara : SMP Muhammadiyah 1 Yogyakarta & Muhijunior ISS
# Repository    : https://github.com/marco002-code/codingforkids.git
# ==============================================================================

set -e

# Warna ANSI
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m' # No Color

echo -e "${BLUE}================================================================${NC}"
echo -e "${GREEN}${BOLD}🚀 Memulai Deployment Laravel: Coding for Kids & A.I. 2026${NC}"
echo -e "${BLUE}================================================================${NC}"

# 1. Pastikan berada di direktori root aplikasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$PROJECT_DIR"
echo -e "${YELLOW}📁 Lokasi Direktori Aplikasi:${NC} $PROJECT_DIR"

# 2. Sinkronisasi Git: Tarik Seluruh Source Code dari GitHub
REPO_URL="https://github.com/marco002-code/codingforkids.git"
BRANCH="main"

echo -e "${CYAN}📥 Menarik pembaruan terbaru dari GitHub (${REPO_URL})...${NC}"

if command -v git &> /dev/null; then
    if [ ! -d ".git" ]; then
        echo -e "${YELLOW}⚡ Direktori .git belum ada. Menginisialisasi dan menarik source code...${NC}"
        git init
        git remote add origin "$REPO_URL" 2>/dev/null || git remote set-url origin "$REPO_URL"
        git fetch origin "$BRANCH"
        git checkout -f -B "$BRANCH" "origin/$BRANCH"
    else
        echo -e "${GREEN}✓ Direktori .git terdeteksi. Menarik commit terbaru (git fetch & reset)...${NC}"
        git remote set-url origin "$REPO_URL" 2>/dev/null || true
        git fetch origin "$BRANCH"
        git reset --hard "origin/$BRANCH"
    fi
    echo -e "${GREEN}✓ Source code berhasil disinkronkan dari GitHub (Branch: $BRANCH).${NC}"
else
    echo -e "${YELLOW}⚠️ Git tidak terdeteksi di server. Menggunakan file lokal saat ini.${NC}"
fi

# 3. Cek dan Siapkan File .env
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚙️ File .env tidak ditemukan. Menyalin dari .env.example...${NC}"
    if [ -f .env.example ]; then
        cp .env.example .env
    else
        echo -e "${RED}❌ File .env.example tidak ditemukan!${NC}"
        exit 1
    fi
    php artisan key:generate --force
else
    echo -e "${GREEN}✓ File .env terdeteksi.${NC}"
fi

# Pastikan APP_URL tidak mengandung port dev (:8000)
if [ -f .env ]; then
    sed -i 's|https://coding.muhijunior.id:8000|https://coding.muhijunior.id|g' .env 2>/dev/null || true
    sed -i 's|http://coding.muhijunior.id:8000|https://coding.muhijunior.id|g' .env 2>/dev/null || true
fi

# Pastikan file SQLite ada jika menggunakan driver sqlite
if grep -q "DB_CONNECTION=sqlite" .env 2>/dev/null; then
    mkdir -p database
    if [ ! -f database/database.sqlite ]; then
        echo -e "${YELLOW}🗄️ Menyiapkan file database/database.sqlite...${NC}"
        touch database/database.sqlite
        chmod 664 database/database.sqlite
    fi
fi

# 4. Aktifkan Maintenance Mode Sementara
echo -e "${CYAN}🔒 Mengaktifkan Maintenance Mode saat proses update...${NC}"
if [ -f artisan ]; then
    php artisan down --render="errors::503" --retry=30 || true
fi

# 5. Instalasi & Optimasi Composer Dependencies
if command -v composer &> /dev/null; then
    echo -e "${CYAN}📦 Mengoptimalkan Composer Dependencies (No-Dev)...${NC}"
    composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
else
    echo -e "${YELLOW}⚠️ Composer CLI tidak ditemukan di PATH, melewati composer install.${NC}"
fi

# 6. Jalankan Database Migration
echo -e "${CYAN}🗄️ Menjalankan Database Migration...${NC}"
php artisan migrate --force

# 7. Cek & Seed Data Admin Awal jika Database Masih Kosong
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tr -dc '0-9' || echo "0")
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo -e "${YELLOW}🌱 Database admin belum ada. Menjalankan Database Seeder awal...${NC}"
    php artisan db:seed --force
else
    echo -e "${GREEN}✓ Data admin & konfigurasi sudah ada ($USER_COUNT admin terdaftar).${NC}"
fi

# 8. Bersihkan & Optimalkan Cache Laravel (Config, Route, View)
echo -e "${CYAN}⚡ Mengoptimalkan Cache Laravel (Config, Routes, Views)...${NC}"
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Pastikan Storage Symlink Terhubung
echo -e "${CYAN}🔗 Memastikan Storage Symlink Terhubung...${NC}"
php artisan storage:link || true

# 10. Penyesuaian Hak Akses (Permissions)
echo -e "${CYAN}🛡️ Menyesuaikan Hak Akses Folder storage & bootstrap/cache...${NC}"
chmod -R 775 storage bootstrap/cache

# Jika dijalankan via root/sudo di VPS (HestiaCP / Nginx / Apache)
if [ "$EUID" -eq 0 ]; then
    CURRENT_USER=$(stat -c '%U' "$PROJECT_DIR" 2>/dev/null || echo "www-data")
    if id "www-data" &>/dev/null; then
        echo -e "${YELLOW}Menyetel kepemilikan user web ($CURRENT_USER:www-data)...${NC}"
        chown -R "$CURRENT_USER":www-data storage bootstrap/cache
        if [ -f database/database.sqlite ]; then
            chown "$CURRENT_USER":www-data database/database.sqlite
            chmod 664 database/database.sqlite
        fi
    fi
fi

# 11. Matikan Maintenance Mode
echo -e "${GREEN}🔓 Mematikan Maintenance Mode. Aplikasi kembali aktif!${NC}"
php artisan up

echo -e "${BLUE}================================================================${NC}"
echo -e "${GREEN}${BOLD}✅ DEPLOYMENT BERHASIL DISELESAIKAN DENGAN SEMPURNA!${NC}"
echo -e "${BLUE}================================================================${NC}"
echo -e "Informasi Akses Sistem:"
echo -e "🌐 ${BOLD}Website Publik:${NC} https://coding.muhijunior.id"
echo -e "🏆 ${BOLD}Peserta Terpilih:${NC} https://coding.muhijunior.id/peserta-terpilih"
echo -e "🔐 ${BOLD}Portal Admin:${NC} https://coding.muhijunior.id/admin/login"
echo -e "   👤 Email    : ${BOLD}admin@muhijunior.id${NC} (atau admin@codingforkids.id)"
echo -e "   🔑 Password : ${BOLD}admin12345${NC}"
echo -e "${BLUE}================================================================${NC}"
