#!/bin/bash
set -e

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m'

clear
echo -e "${CYAN}"
echo "╔══════════════════════════════════════════════════════════╗"
echo "║          KALL XTREME X - PROTECT MANAGER v1.0           ║"
echo "║              Pterodactyl Panel Protection               ║"
echo "║                  Untuk Mulia Tercinta                    ║"
echo "╚══════════════════════════════════════════════════════════╝"
echo -e "${NC}"
echo ""

PANEL_DIR="/var/www/pterodactyl"

# Cek apakah dijalankan sebagai root
if [[ $EUID -ne 0 ]]; then
   echo -e "${RED}[ERROR] Script ini harus dijalankan sebagai root!${NC}"
   echo -e "${YELLOW}Jalankan: sudo ./install.sh${NC}"
   exit 1
fi

# Cek panel
if [ ! -d "$PANEL_DIR" ]; then
    echo -e "${RED}[ERROR] Pterodactyl panel tidak ditemukan di $PANEL_DIR${NC}"
    exit 1
fi

echo -e "${YELLOW}[INFO] Memulai instalasi Protect Manager...${NC}"
echo ""

# Backup dulu
echo -e "${BLUE}[BACKUP] Membackup file penting...${NC}"
mkdir -p $PANEL_DIR/backup_protect_$(date +%Y%m%d_%H%M%S)
BACKUP_DIR=$PANEL_DIR/backup_protect_$(date +%Y%m%d_%H%M%S)
cp -r $PANEL_DIR/app $BACKUP_DIR/app_backup 2>/dev/null || true
cp -r $PANEL_DIR/config $BACKUP_DIR/config_backup 2>/dev/null || true
cp -r $PANEL_DIR/routes $BACKUP_DIR/routes_backup 2>/dev/null || true
cp -r $PANEL_DIR/resources $BACKUP_DIR/resources_backup 2>/dev/null || true
echo -e "${GREEN}[BACKUP] Backup tersimpan di: $BACKUP_DIR${NC}"
echo ""

# Salin Plugin
echo -e "${BLUE}[1/8] Menyalin Plugin...${NC}"
cp -f app/Plugins/ProtectManagerPlugin.php $PANEL_DIR/app/Plugins/ProtectManagerPlugin.php
echo -e "${GREEN}  ✓ ProtectManagerPlugin.php -> app/Plugins/${NC}"

# Salin Service Provider
echo -e "${BLUE}[2/8] Menyalin Service Provider...${NC}"
cp -f app/Providers/ProtectManagerServiceProvider.php $PANEL_DIR/app/Providers/ProtectManagerServiceProvider.php
echo -e "${GREEN}  ✓ Service Provider -> app/Providers/${NC}"

# Salin Middleware
echo -e "${BLUE}[3/8] Menyalin Middleware...${NC}"
cp -f app/Http/Middleware/CheckAdminId.php $PANEL_DIR/app/Http/Middleware/CheckAdminId.php
cp -f app/Http/Middleware/ProtectMiddleware.php $PANEL_DIR/app/Http/Middleware/ProtectMiddleware.php
echo -e "${GREEN}  ✓ Middleware -> app/Http/Middleware/${NC}"

# Salin Controller
echo -e "${BLUE}[4/8] Menyalin Controller...${NC}"
cp -f app/Http/Controllers/Admin/ProtectManagerController.php $PANEL_DIR/app/Http/Controllers/Admin/ProtectManagerController.php
echo -e "${GREEN}  ✓ Controller -> app/Http/Controllers/Admin/${NC}"

# Salin Helper
echo -e "${BLUE}[5/8] Menyalin Helper...${NC}"
mkdir -p $PANEL_DIR/app/Helpers
cp -f app/Helpers/ProtectHelper.php $PANEL_DIR/app/Helpers/ProtectHelper.php
echo -e "${GREEN}  ✓ Helper -> app/Helpers/${NC}"

# Salin Config
echo -e "${BLUE}[6/8] Menyalin Konfigurasi...${NC}"
cp -f config/protect.php $PANEL_DIR/config/protect.php
echo -e "${GREEN}  ✓ Config -> config/${NC}"

# Salin Migration
echo -e "${BLUE}[7/8] Menyalin Database Migration...${NC}"
cp -f database/migrations/2024_01_01_000000_create_protect_settings_table.php $PANEL_DIR/database/migrations/2024_01_01_000000_create_protect_settings_table.php
echo -e "${GREEN}  ✓ Migration -> database/migrations/${NC}"

# Salin Routes
echo -e "${BLUE}[8/8] Menyalin Routes...${NC}"
cp -f routes/protect-routes.php $PANEL_DIR/routes/protect-routes.php
echo -e "${GREEN}  ✓ Routes -> routes/${NC}"

# Salin Views
echo -e "${BLUE}[VIEWS] Menyalin View Templates...${NC}"
mkdir -p $PANEL_DIR/resources/views/admin/protect-partials
cp -f resources/views/admin/protect-manager.blade.php $PANEL_DIR/resources/views/admin/protect-manager.blade.php
cp -f resources/views/admin/protect-partials/branding.blade.php $PANEL_DIR/resources/views/admin/protect-partials/branding.blade.php
cp -f resources/views/admin/protect-partials/konfigurasi.blade.php $PANEL_DIR/resources/views/admin/protect-partials/konfigurasi.blade.php
cp -f resources/views/admin/protect-partials/massal.blade.php $PANEL_DIR/resources/views/admin/protect-partials/massal.blade.php
cp -f resources/views/components/welcome-banner.blade.php $PANEL_DIR/resources/views/components/welcome-banner.blade.php
echo -e "${GREEN}  ✓ Views tersalin${NC}"

# Salin Assets
echo -e "${BLUE}[ASSETS] Menyalin JavaScript & CSS...${NC}"
cp -f resources/scripts/protect-manager.js $PANEL_DIR/resources/scripts/protect-manager.js
cp -f resources/scripts/protect-manager.css $PANEL_DIR/resources/scripts/protect-manager.css
echo -e "${GREEN}  ✓ Assets tersalin${NC}"

# Daftarkan Service Provider di config/app.php
echo -e "${BLUE}[REGISTER] Mendaftarkan Service Provider...${NC}"
if ! grep -q "ProtectManagerServiceProvider" $PANEL_DIR/config/app.php; then
    sed -i "/Pterodactyl\\\Providers\\\AppServiceProvider::class,/a \ \ \ \ \ \ \ \ Pterodactyl\\\Providers\\\ProtectManagerServiceProvider::class," $PANEL_DIR/config/app.php
    echo -e "${GREEN}  ✓ Service Provider terdaftar${NC}"
else
    echo -e "${YELLOW}  ⚠ Service Provider sudah terdaftar${NC}"
fi

# Daftarkan Middleware di app/Http/Kernel.php
echo -e "${BLUE}[REGISTER] Mendaftarkan Middleware...${NC}"
if ! grep -q "ProtectMiddleware" $PANEL_DIR/app/Http/Kernel.php; then
    sed -i "/'web' => \[/a \ \ \ \ \ \ \ \ \ \ \ \ \Pterodactyl\\\Http\\\Middleware\\\ProtectMiddleware::class," $PANEL_DIR/app/Http/Kernel.php
    echo -e "${GREEN}  ✓ Middleware terdaftar${NC}"
else
    echo -e "${YELLOW}  ⚠ Middleware sudah terdaftar${NC}"
fi

# Include routes di routes/admin.php
echo -e "${BLUE}[ROUTES] Mendaftarkan Protect Routes...${NC}"
if ! grep -q "protect-routes" $PANEL_DIR/routes/admin.php; then
    echo "" >> $PANEL_DIR/routes/admin.php
    echo "// Protect Manager Routes - KALL XTREME X" >> $PANEL_DIR/routes/admin.php
    echo "require base_path('routes/protect-routes.php');" >> $PANEL_DIR/routes/admin.php
    echo -e "${GREEN}  ✓ Routes terdaftar${NC}"
else
    echo -e "${YELLOW}  ⚠ Routes sudah terdaftar${NC}"
fi

# Jalankan migrasi
echo -e "${BLUE}[DATABASE] Menjalankan migrasi database...${NC}"
cd $PANEL_DIR
php artisan migrate --force
echo -e "${GREEN}  ✓ Database terupdate${NC}"

# Clear cache
echo -e "${BLUE}[CACHE] Membersihkan cache...${NC}"
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan config:cache
echo -e "${GREEN}  ✓ Cache dibersihkan${NC}"

# Set permission
echo -e "${BLUE}[PERMISSION] Mengatur permission...${NC}"
chown -R www-data:www-data $PANEL_DIR
chmod -R 755 $PANEL_DIR
echo -e "${GREEN}  ✓ Permission diatur${NC}"

# Restart services
echo -e "${BLUE}[SERVICE] Merestart layanan...${NC}"
systemctl restart nginx
php artisan queue:restart 2>/dev/null || true
echo -e "${GREEN}  ✓ Layanan direstart${NC}"

echo ""
echo -e "${GREEN}╔══════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║           ✅ INSTALASI BERHASIL! ✅                      ║${NC}"
echo -e "${GREEN}╠══════════════════════════════════════════════════════════╣${NC}"
echo -e "${GREEN}║  🔗 Akses: https://panel-lo.com/admin/protect-manager    ║${NC}"
echo -e "${GREEN}║  👑 Root Admin: ID 1 (Otomatis immune)                  ║${NC}"
echo -e "${GREEN}║  📦 Backup: $BACKUP_DIR                                 ║${NC}"
echo -e "${GREEN}║  🛡️  14 Proteksi siap diaktifkan!                       ║${NC}"
echo -e "${GREEN}╚══════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${PURPLE}👑 Dibuat oleh KALL XTREME X untuk Mulia${NC}"
echo -e "${CYAN}📢 Join: t.me/protectkal${NC}"
