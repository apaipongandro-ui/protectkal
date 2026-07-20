#!/bin/bash
set -e

# ============================================================
# UNINSTALL SCRIPT - Protect Manager by KALL XTREME X
# AMAN! Gak bakal ngerusak panel Pterodactyl lo!
# ============================================================

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
PURPLE='\033[0;35m'
NC='\033[0m'

clear

echo -e "${RED}"
echo "╔══════════════════════════════════════════════════════════╗"
echo "║     🗑️  UNINSTALL PROTECT MANAGER - KALL XTREME X       ║"
echo "║              AMAN! TIDAK MERUSAK PANEL!                 ║"
echo "╚══════════════════════════════════════════════════════════╝"
echo -e "${NC}"
echo ""

PANEL_DIR="/var/www/pterodactyl"

# ============================================================
# CEK APAKAH DIJALANKAN SEBAGAI ROOT
# ============================================================
if [[ $EUID -ne 0 ]]; then
   echo -e "${RED}[ERROR] Script ini harus dijalankan sebagai root!${NC}"
   echo -e "${YELLOW}Jalankan: sudo ./uninstall.sh${NC}"
   exit 1
fi

# ============================================================
# CEK APAKAH PANEL ADA
# ============================================================
if [ ! -d "$PANEL_DIR" ]; then
    echo -e "${RED}[ERROR] Pterodactyl panel tidak ditemukan di $PANEL_DIR${NC}"
    echo -e "${YELLOW}Pastikan panel terinstall di lokasi yang benar${NC}"
    exit 1
fi

# ============================================================
# CEK APAKAH PROTECT MANAGER TERINSTALL
# ============================================================
if [ ! -f "$PANEL_DIR/app/Plugins/ProtectManagerPlugin.php" ] && \
   [ ! -f "$PANEL_DIR/config/protect.php" ]; then
    echo -e "${YELLOW}[INFO] Protect Manager tidak terdeteksi di panel ini.${NC}"
    echo -e "${YELLOW}Sepertinya belum pernah diinstall atau sudah dihapus manual.${NC}"
    echo ""
    read -p "Tetap lanjutkan uninstall? (y/n): " force_continue
    if [ "$force_continue" != "y" ]; then
        echo -e "${GREEN}Uninstall dibatalkan. Panel aman!${NC}"
        exit 0
    fi
fi

# ============================================================
# KONFIRMASI PENGGUNA
# ============================================================
echo -e "${YELLOW}⚠️  PERINGATAN:${NC}"
echo -e "${YELLOW}Anda akan menghapus Protect Manager dari panel.${NC}"
echo -e "${YELLOW}Semua file plugin, config, views, dan assets akan dihapus.${NC}"
echo -e "${YELLOW}Database table 'protect_settings' akan TETAP DISIMPAN.${NC}"
echo ""
echo -e "${CYAN}Panel Pterodactyl TIDAK AKAN TERPENGARUH.${NC}"
echo -e "${CYAN}Server, user, node, dan data lainnya TETAP AMAN.${NC}"
echo ""
read -p "Apakah Anda yakin ingin melanjutkan? (y/n): " confirm

if [ "$confirm" != "y" ]; then
    echo -e "${GREEN}✅ Uninstall dibatalkan. Panel tetap aman!${NC}"
    exit 0
fi

echo ""
echo -e "${BLUE}🔍 Memeriksa file Protect Manager...${NC}"
echo ""

# ============================================================
# BACKUP SEBELUM HAPUS (JAGA-JAGA KALO NYESEL)
# ============================================================
BACKUP_DIR="$PANEL_DIR/backup_protect_uninstall_$(date +%Y%m%d_%H%M%S)"
echo -e "${BLUE}[BACKUP] Membackup file sebelum dihapus...${NC}"
mkdir -p "$BACKUP_DIR"

# Backup file-file Protect Manager kalo ada
if [ -f "$PANEL_DIR/app/Plugins/ProtectManagerPlugin.php" ]; then
    mkdir -p "$BACKUP_DIR/app/Plugins"
    cp "$PANEL_DIR/app/Plugins/ProtectManagerPlugin.php" "$BACKUP_DIR/app/Plugins/"
    echo -e "  ✓ Backup: app/Plugins/ProtectManagerPlugin.php"
fi

if [ -f "$PANEL_DIR/app/Providers/ProtectManagerServiceProvider.php" ]; then
    mkdir -p "$BACKUP_DIR/app/Providers"
    cp "$PANEL_DIR/app/Providers/ProtectManagerServiceProvider.php" "$BACKUP_DIR/app/Providers/"
    echo -e "  ✓ Backup: app/Providers/ProtectManagerServiceProvider.php"
fi

if [ -f "$PANEL_DIR/app/Http/Middleware/CheckAdminId.php" ]; then
    mkdir -p "$BACKUP_DIR/app/Http/Middleware"
    cp "$PANEL_DIR/app/Http/Middleware/CheckAdminId.php" "$BACKUP_DIR/app/Http/Middleware/"
    echo -e "  ✓ Backup: app/Http/Middleware/CheckAdminId.php"
fi

if [ -f "$PANEL_DIR/app/Http/Middleware/ProtectMiddleware.php" ]; then
    mkdir -p "$BACKUP_DIR/app/Http/Middleware"
    cp "$PANEL_DIR/app/Http/Middleware/ProtectMiddleware.php" "$BACKUP_DIR/app/Http/Middleware/"
    echo -e "  ✓ Backup: app/Http/Middleware/ProtectMiddleware.php"
fi

if [ -f "$PANEL_DIR/app/Http/Controllers/Admin/ProtectManagerController.php" ]; then
    mkdir -p "$BACKUP_DIR/app/Http/Controllers/Admin"
    cp "$PANEL_DIR/app/Http/Controllers/Admin/ProtectManagerController.php" "$BACKUP_DIR/app/Http/Controllers/Admin/"
    echo -e "  ✓ Backup: app/Http/Controllers/Admin/ProtectManagerController.php"
fi

if [ -f "$PANEL_DIR/app/Helpers/ProtectHelper.php" ]; then
    mkdir -p "$BACKUP_DIR/app/Helpers"
    cp "$PANEL_DIR/app/Helpers/ProtectHelper.php" "$BACKUP_DIR/app/Helpers/"
    echo -e "  ✓ Backup: app/Helpers/ProtectHelper.php"
fi

if [ -f "$PANEL_DIR/config/protect.php" ]; then
    mkdir -p "$BACKUP_DIR/config"
    cp "$PANEL_DIR/config/protect.php" "$BACKUP_DIR/config/"
    echo -e "  ✓ Backup: config/protect.php"
fi

if [ -f "$PANEL_DIR/routes/protect-routes.php" ]; then
    mkdir -p "$BACKUP_DIR/routes"
    cp "$PANEL_DIR/routes/protect-routes.php" "$BACKUP_DIR/routes/"
    echo -e "  ✓ Backup: routes/protect-routes.php"
fi

if [ -d "$PANEL_DIR/resources/views/admin/protect-partials" ]; then
    mkdir -p "$BACKUP_DIR/resources/views/admin/protect-partials"
    cp -r "$PANEL_DIR/resources/views/admin/protect-partials/"* "$BACKUP_DIR/resources/views/admin/protect-partials/" 2>/dev/null || true
    echo -e "  ✓ Backup: resources/views/admin/protect-partials/"
fi

if [ -f "$PANEL_DIR/resources/views/admin/protect-manager.blade.php" ]; then
    mkdir -p "$BACKUP_DIR/resources/views/admin"
    cp "$PANEL_DIR/resources/views/admin/protect-manager.blade.php" "$BACKUP_DIR/resources/views/admin/"
    echo -e "  ✓ Backup: resources/views/admin/protect-manager.blade.php"
fi

if [ -f "$PANEL_DIR/resources/views/components/welcome-banner.blade.php" ]; then
    mkdir -p "$BACKUP_DIR/resources/views/components"
    cp "$PANEL_DIR/resources/views/components/welcome-banner.blade.php" "$BACKUP_DIR/resources/views/components/"
    echo -e "  ✓ Backup: resources/views/components/welcome-banner.blade.php"
fi

if [ -f "$PANEL_DIR/resources/scripts/protect-manager.js" ]; then
    mkdir -p "$BACKUP_DIR/resources/scripts"
    cp "$PANEL_DIR/resources/scripts/protect-manager.js" "$BACKUP_DIR/resources/scripts/"
    echo -e "  ✓ Backup: resources/scripts/protect-manager.js"
fi

if [ -f "$PANEL_DIR/resources/scripts/protect-manager.css" ]; then
    mkdir -p "$BACKUP_DIR/resources/scripts"
    cp "$PANEL_DIR/resources/scripts/protect-manager.css" "$BACKUP_DIR/resources/scripts/"
    echo -e "  ✓ Backup: resources/scripts/protect-manager.css"
fi

if [ -f "$PANEL_DIR/database/migrations/2024_01_01_000000_create_protect_settings_table.php" ]; then
    mkdir -p "$BACKUP_DIR/database/migrations"
    cp "$PANEL_DIR/database/migrations/2024_01_01_000000_create_protect_settings_table.php" "$BACKUP_DIR/database/migrations/"
    echo -e "  ✓ Backup: database/migrations/2024_01_01_..."
fi

echo -e "${GREEN}✅ Backup tersimpan di: $BACKUP_DIR${NC}"
echo ""

# ============================================================
# HAPUS FILE-FILE PROTECT MANAGER
# ============================================================
echo -e "${RED}[UNINSTALL] Menghapus file Protect Manager...${NC}"
echo ""

DELETED_COUNT=0

# Hapus Plugin
if [ -f "$PANEL_DIR/app/Plugins/ProtectManagerPlugin.php" ]; then
    rm -f "$PANEL_DIR/app/Plugins/ProtectManagerPlugin.php"
    echo -e "  🗑️  Hapus: app/Plugins/ProtectManagerPlugin.php"
    ((DELETED_COUNT++))
fi

# Hapus Service Provider
if [ -f "$PANEL_DIR/app/Providers/ProtectManagerServiceProvider.php" ]; then
    rm -f "$PANEL_DIR/app/Providers/ProtectManagerServiceProvider.php"
    echo -e "  🗑️  Hapus: app/Providers/ProtectManagerServiceProvider.php"
    ((DELETED_COUNT++))
fi

# Hapus Middleware
if [ -f "$PANEL_DIR/app/Http/Middleware/CheckAdminId.php" ]; then
    rm -f "$PANEL_DIR/app/Http/Middleware/CheckAdminId.php"
    echo -e "  🗑️  Hapus: app/Http/Middleware/CheckAdminId.php"
    ((DELETED_COUNT++))
fi

if [ -f "$PANEL_DIR/app/Http/Middleware/ProtectMiddleware.php" ]; then
    rm -f "$PANEL_DIR/app/Http/Middleware/ProtectMiddleware.php"
    echo -e "  🗑️  Hapus: app/Http/Middleware/ProtectMiddleware.php"
    ((DELETED_COUNT++))
fi

# Hapus Controller
if [ -f "$PANEL_DIR/app/Http/Controllers/Admin/ProtectManagerController.php" ]; then
    rm -f "$PANEL_DIR/app/Http/Controllers/Admin/ProtectManagerController.php"
    echo -e "  🗑️  Hapus: app/Http/Controllers/Admin/ProtectManagerController.php"
    ((DELETED_COUNT++))
fi

# Hapus Helper
if [ -f "$PANEL_DIR/app/Helpers/ProtectHelper.php" ]; then
    rm -f "$PANEL_DIR/app/Helpers/ProtectHelper.php"
    echo -e "  🗑️  Hapus: app/Helpers/ProtectHelper.php"
    ((DELETED_COUNT++))
fi

# Hapus Config
if [ -f "$PANEL_DIR/config/protect.php" ]; then
    rm -f "$PANEL_DIR/config/protect.php"
    echo -e "  🗑️  Hapus: config/protect.php"
    ((DELETED_COUNT++))
fi

# Hapus Routes
if [ -f "$PANEL_DIR/routes/protect-routes.php" ]; then
    rm -f "$PANEL_DIR/routes/protect-routes.php"
    echo -e "  🗑️  Hapus: routes/protect-routes.php"
    ((DELETED_COUNT++))
fi

# Hapus Views
if [ -f "$PANEL_DIR/resources/views/admin/protect-manager.blade.php" ]; then
    rm -f "$PANEL_DIR/resources/views/admin/protect-manager.blade.php"
    echo -e "  🗑️  Hapus: resources/views/admin/protect-manager.blade.php"
    ((DELETED_COUNT++))
fi

if [ -d "$PANEL_DIR/resources/views/admin/protect-partials" ]; then
    rm -rf "$PANEL_DIR/resources/views/admin/protect-partials"
    echo -e "  🗑️  Hapus: resources/views/admin/protect-partials/"
    ((DELETED_COUNT++))
fi

if [ -f "$PANEL_DIR/resources/views/components/welcome-banner.blade.php" ]; then
    rm -f "$PANEL_DIR/resources/views/components/welcome-banner.blade.php"
    echo -e "  🗑️  Hapus: resources/views/components/welcome-banner.blade.php"
    ((DELETED_COUNT++))
fi

# Hapus Assets
if [ -f "$PANEL_DIR/resources/scripts/protect-manager.js" ]; then
    rm -f "$PANEL_DIR/resources/scripts/protect-manager.js"
    echo -e "  🗑️  Hapus: resources/scripts/protect-manager.js"
    ((DELETED_COUNT++))
fi

if [ -f "$PANEL_DIR/resources/scripts/protect-manager.css" ]; then
    rm -f "$PANEL_DIR/resources/scripts/protect-manager.css"
    echo -e "  🗑️  Hapus: resources/scripts/protect-manager.css"
    ((DELETED_COUNT++))
fi

# Hapus Migration
if [ -f "$PANEL_DIR/database/migrations/2024_01_01_000000_create_protect_settings_table.php" ]; then
    rm -f "$PANEL_DIR/database/migrations/2024_01_01_000000_create_protect_settings_table.php"
    echo -e "  🗑️  Hapus: database/migrations/2024_01_01_..."
    ((DELETED_COUNT++))
fi

echo ""
echo -e "${YELLOW}[INFO] $DELETED_COUNT file berhasil dihapus${NC}"
echo ""

# ============================================================
# BERSIHKAN REGISTRASI DI config/app.php
# ============================================================
echo -e "${BLUE}[CLEANUP] Membersihkan registrasi di config/app.php...${NC}"
if grep -q "ProtectManagerServiceProvider" "$PANEL_DIR/config/app.php"; then
    sed -i '/ProtectManagerServiceProvider/d' "$PANEL_DIR/config/app.php"
    echo -e "  ✓ Service Provider dihapus dari config/app.php"
else
    echo -e "  - Service Provider tidak ditemukan (mungkin sudah dihapus manual)"
fi

# ============================================================
# BERSIHKAN MIDDLEWARE DI app/Http/Kernel.php
# ============================================================
echo -e "${BLUE}[CLEANUP] Membersihkan middleware di Kernel.php...${NC}"
if grep -q "ProtectMiddleware" "$PANEL_DIR/app/Http/Kernel.php"; then
    sed -i '/ProtectMiddleware/d' "$PANEL_DIR/app/Http/Kernel.php"
    echo -e "  ✓ Middleware dihapus dari Kernel.php"
else
    echo -e "  - Middleware tidak ditemukan (mungkin sudah dihapus manual)"
fi

# ============================================================
# BERSIHKAN ROUTES DI routes/admin.php
# ============================================================
echo -e "${BLUE}[CLEANUP] Membersihkan routes di routes/admin.php...${NC}"
if grep -q "protect-routes" "$PANEL_DIR/routes/admin.php"; then
    sed -i '/protect-routes/d' "$PANEL_DIR/routes/admin.php"
    sed -i '/Protect Manager Routes/d' "$PANEL_DIR/routes/admin.php"
    echo -e "  ✓ Routes dihapus dari routes/admin.php"
else
    echo -e "  - Routes tidak ditemukan (mungkin sudah dihapus manual)"
fi

# ============================================================
# CLEAR CACHE
# ============================================================
echo -e "${BLUE}[CACHE] Membersihkan cache panel...${NC}"
cd "$PANEL_DIR"
php artisan config:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
echo -e "  ✓ Cache dibersihkan"
echo ""

# ============================================================
# RESTART SERVICES
# ============================================================
echo -e "${BLUE}[SERVICE] Merestart layanan...${NC}"
systemctl restart nginx 2>/dev/null || service nginx restart 2>/dev/null || true
php artisan queue:restart 2>/dev/null || true
echo -e "  ✓ Layanan direstart"
echo ""

# ============================================================
# INFORMASI DATABASE
# ============================================================
echo -e "${YELLOW}╔══════════════════════════════════════════════════════════╗${NC}"
echo -e "${YELLOW}║  ℹ️  INFORMASI DATABASE                                  ║${NC}"
echo -e "${YELLOW}╠══════════════════════════════════════════════════════════╣${NC}"
echo -e "${YELLOW}║  Table 'protect_settings' TIDAK dihapus.                ║${NC}"
echo -e "${YELLOW}║  Jika ingin menghapus, jalankan:                        ║${NC}"
echo -e "${YELLOW}║  php artisan tinker                                    ║${NC}"
echo -e "${YELLOW}║  >>> DB::statement('DROP TABLE protect_settings');     ║${NC}"
echo -e "${YELLOW}╚══════════════════════════════════════════════════════════╝${NC}"
echo ""

# ============================================================
# SELESAI
# ============================================================
echo -e "${GREEN}╔══════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║         ✅ UNINSTALL BERHASIL! ✅                        ║${NC}"
echo -e "${GREEN}╠══════════════════════════════════════════════════════════╣${NC}"
echo -e "${GREEN}║  🗑️  $DELETED_COUNT file Protect Manager dihapus        ${NC}"
echo -e "${GREEN}║  💾 Backup disimpan di:                                 ${NC}"
echo -e "${GREEN}║     $BACKUP_DIR                                        ${NC}"
echo -e "${GREEN}║  🛡️  Panel Pterodactyl TETAP AMAN                      ${NC}"
echo -e "${GREEN}║  📊 Table database TETAP ADA                           ${NC}"
echo -e "${GREEN}╠══════════════════════════════════════════════════════════╣${NC}"
echo -e "${GREEN}║  Untuk install ulang:                                  ${NC}"
echo -e "${GREEN}║  cd /var/www/pterodactyl/protectkal                    ${NC}"
echo -e "${GREEN}║  sudo ./install.sh                                      ${NC}"
echo -e "${GREEN}║                                                        ${NC}"
echo -e "${GREEN}║  Untuk restore backup:                                 ${NC}"
echo -e "${GREEN}║  cp -r $BACKUP_DIR/* /var/www/pterodactyl/             ${NC}"
echo -e "${GREEN}╚══════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${PURPLE}👑 KALL XTREME X - Melayani Mulia${NC}"
echo -e "${CYAN}📢 Protector of Pterodactyl${NC}"