#!/bin/bash
# ==============================================================================
# Script Otomasi Deployment Laravel di HestiaCP
# Aplikasi: Coding for Kids & A.I. for Learning
# ==============================================================================

set -e

# Warna output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}======================================================${NC}"
echo -e "${GREEN}🚀 Memulai Deployment Laravel di HestiaCP...${NC}"
echo -e "${BLUE}======================================================${NC}"

# 1. Pastikan berada di direktori aplikasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$PROJECT_DIR"
echo -e "${YELLOW}📁 Lokasi Direktori:${NC} $PROJECT_DIR"

# 2. Cek file .env
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚙️ File .env tidak ditemukan. Menyalin dari .env.example...${NC}"
    cp .env.example .env
    php artisan key:generate
else
    echo -e "${GREEN}✓ File .env sudah ada.${NC}"
fi

# 3. Mode Maintenance sementara saat update
echo -e "${BLUE}🔒 Mengaktifkan Maintenance Mode...${NC}"
php artisan down || true

# 4. Instalasi Dependency Composer (jika ada update)
if command -v composer &> /dev/null; then
    echo -e "${BLUE}📦 Mengoptimalkan Composer Autoloader...${NC}"
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# 5. Jalankan Database Migration
echo -e "${BLUE}🗄️ Menjalankan Database Migration...${NC}"
php artisan migrate --force

# 6. Bersihkan dan buat Cache Baru (Config, Route, View)
echo -e "${BLUE}⚡ Mengoptimalkan Cache Laravel...${NC}"
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Symlink Storage
echo -e "${BLUE}🔗 Menghubungkan Storage Symlink...${NC}"
php artisan storage:link || true

# 8. Pengaturan Hak Akses (Permissions) untuk HestiaCP / Nginx / Apache
echo -e "${BLUE}🛡️ Menyesuaikan Hak Akses Folder storage & bootstrap/cache...${NC}"
chmod -R 775 storage bootstrap/cache

# Jika script dijalankan sebagai root / sudo, sesuaikan owner ke user web dan www-data
if [ "$EUID" -eq 0 ]; then
    CURRENT_USER=$(stat -c '%U' "$PROJECT_DIR")
    echo -e "${YELLOW}Menyetel grup www-data untuk web server...${NC}"
    chown -R "$CURRENT_USER":www-data storage bootstrap/cache
fi

# 9. Matikan Maintenance Mode
echo -e "${GREEN}🔓 Mematikan Maintenance Mode...${NC}"
php artisan up

echo -e "${BLUE}======================================================${NC}"
echo -e "${GREEN}✅ Deployment Berhasil Selesai!${NC}"
echo -e "Silakan akses website dan dashboard admin:"
echo -e "🔗 Landing Page : URL domain Anda"
echo -e "🔑 Admin Portal : /admin/login (admin@codingforkids.id / admin12345)"
echo -e "${BLUE}======================================================${NC}"

