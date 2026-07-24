#!/bin/bash
# ============================================================
# 🔍 DRY-RUN CHECKER - Protect Manager v2.0 Canva Edition
# 👑 KALL XTREME X untuk MULIA
# 
# Script ini HANYA mengecek kesiapan instalasi.
# TIDAK mengubah apapun di panel lo!
# AMAN dijalankan berkali-kali!
# ============================================================

set -e

# ============================================================
# COLOR DEFINITIONS
# ============================================================
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
PURPLE='\033[0;35m'
WHITE='\033[1;37m'
BOLD='\033[1m'
NC='\033[0m' # No Color

# ============================================================
# BANNER
# ============================================================
clear
echo -e "${CYAN}"
echo "╔══════════════════════════════════════════════════════════════╗"
echo "║                                                              ║"
echo "║     🔍  DRY-RUN CHECKER                                     ║"
echo "║     🛡️  Protect Manager v2.0 - Canva Edition                ║"
echo "║     👑  KALL XTREME X untuk MULIA                           ║"
echo "║                                                              ║"
echo "║     Script ini TIDAK mengubah apapun di panel!              ║"
echo "║     Hanya mengecek kesiapan instalasi saja.                 ║"
echo "║     AMAN dijalankan berkali-kali!                           ║"
echo "║                                                              ║"
echo "╚══════════════════════════════════════════════════════════════╝"
echo -e "${NC}"

# ============================================================
# VARIABLES
# ============================================================
PANEL_DIR="/var/www/pterodactyl"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ERRORS=0
WARNINGS=0
PASSED=0
TOTAL_CHECKS=10

echo -e "${WHITE}${BOLD}📁 Informasi:${NC}"
echo -e "   📂 Folder script : ${CYAN}${SCRIPT_DIR}${NC}"
echo -e "   📂 Folder panel  : ${CYAN}${PANEL_DIR}${NC}"
echo -e "   🕐 Waktu         : $(date '+%Y-%m-%d %H:%M:%S')"
echo ""
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# ============================================================
# CHECK 1: PANEL DIRECTORY
# ============================================================
echo -e "${WHITE}${BOLD}[1/${TOTAL_CHECKS}] Mengecek folder panel...${NC}"
if [ -d "$PANEL_DIR" ]; then
    echo -e "${GREEN}   ✅ Panel Pterodactyl ditemukan!${NC}"
    echo -e "      Lokasi: ${PANEL_DIR}"
    ((PASSED++))
else
    echo -e "${RED}   ❌ Panel Pterodactyl TIDAK ditemukan di ${PANEL_DIR}${NC}"
    echo -e "${YELLOW}      Pastikan panel terinstall di lokasi yang benar.${NC}"
    echo -e "${YELLOW}      Jika panel di lokasi lain, edit variabel PANEL_DIR di script ini.${NC}"
    ((ERRORS++))
fi
echo ""

# ============================================================
# CHECK 2: PANEL STRUCTURE
# ============================================================
echo -e "${WHITE}${BOLD}[2/${TOTAL_CHECKS}] Mengecek struktur folder panel...${NC}"
REQUIRED_FOLDERS=("app" "config" "database" "resources" "routes" "public")
MISSING_FOLDERS=()

for folder in "${REQUIRED_FOLDERS[@]}"; do
    if [ -d "$PANEL_DIR/$folder" ]; then
        echo -e "${GREEN}   ✅ Folder ${folder}/ ada${NC}"
    else
        echo -e "${RED}   ❌ Folder ${folder}/ TIDAK ADA!${NC}"
        MISSING_FOLDERS+=("$folder")
        ((ERRORS++))
    fi
done

if [ ${#MISSING_FOLDERS[@]} -gt 0 ]; then
    echo -e "${RED}   ⚠️  Folder hilang: ${MISSING_FOLDERS[*]}${NC}"
    echo -e "${RED}   Panel mungkin corrupt atau bukan Pterodactyl!${NC}"
else
    ((PASSED++))
fi
echo ""

# ============================================================
# CHECK 3: EXISTING INSTALLATION
# ============================================================
echo -e "${WHITE}${BOLD}[3/${TOTAL_CHECKS}] Mengecek instalasi sebelumnya...${NC}"
EXISTING_FILES=0

FILES_TO_CHECK=(
    "app/Plugins/ProtectManagerPlugin.php"
    "app/Providers/ProtectManagerServiceProvider.php"
    "app/Http/Middleware/CheckAdminId.php"
    "app/Http/Middleware/ProtectMiddleware.php"
    "app/Http/Controllers/Admin/ProtectManagerController.php"
    "app/Helpers/ProtectHelper.php"
    "config/protect.php"
    "routes/protect-routes.php"
    "resources/views/admin/protect-manager.blade.php"
    "resources/views/admin/protect-partials/branding.blade.php"
    "resources/views/admin/protect-partials/konfigurasi.blade.php"
    "resources/views/admin/protect-partials/massal.blade.php"
    "resources/views/components/welcome-banner.blade.php"
    "resources/scripts/protect-manager.css"
    "resources/scripts/protect-manager.js"
    "database/migrations/2024_01_01_000000_create_protect_settings_table.php"
)

for file in "${FILES_TO_CHECK[@]}"; do
    if [ -f "$PANEL_DIR/$file" ]; then
        ((EXISTING_FILES++))
    fi
done

if [ $EXISTING_FILES -gt 0 ]; then
    echo -e "${YELLOW}   ⚠️  Ditemukan ${EXISTING_FILES} file dari instalasi sebelumnya${NC}"
    echo -e "${YELLOW}   File-file ini akan DI-BACKUP sebelum ditimpa.${NC}"
    echo -e "${YELLOW}   Tidak perlu khawatir!${NC}"
    ((WARNINGS++))
else
    echo -e "${GREEN}   ✅ Tidak ada instalasi sebelumnya. Instalasi bersih!${NC}"
    ((PASSED++))
fi
echo ""

# ============================================================
# CHECK 4: SOURCE FILES
# ============================================================
echo -e "${WHITE}${BOLD}[4/${TOTAL_CHECKS}] Mengecek file source di repo...${NC}"
REQUIRED_SOURCE_FILES=(
    "install.sh"
    "app/Plugins/ProtectManagerPlugin.php"
    "app/Providers/ProtectManagerServiceProvider.php"
    "config/protect.php"
    "resources/views/admin/protect-manager.blade.php"
    "resources/scripts/protect-manager.css"
    "resources/scripts/protect-manager.js"
)
MISSING_SOURCE=()

for file in "${REQUIRED_SOURCE_FILES[@]}"; do
    if [ -f "$SCRIPT_DIR/$file" ]; then
        echo -e "${GREEN}   ✅ ${file} ada${NC}"
    else
        echo -e "${RED}   ❌ ${file} TIDAK ADA!${NC}"
        MISSING_SOURCE+=("$file")
        ((ERRORS++))
    fi
done

if [ ${#MISSING_SOURCE[@]} -gt 0 ]; then
    echo -e "${RED}   ⚠️  File hilang: ${MISSING_SOURCE[*]}${NC}"
    echo -e "${RED}   Repository tidak lengkap! Coba git pull atau clone ulang.${NC}"
else
    ((PASSED++))
fi
echo ""

# ============================================================
# CHECK 5: PHP VERSION
# ============================================================
echo -e "${WHITE}${BOLD}[5/${TOTAL_CHECKS}] Mengecek versi PHP...${NC}"
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -v 2>/dev/null | head -n 1 | grep -oP 'PHP \K[0-9]+\.[0-9]+')
    PHP_MAJOR=$(echo "$PHP_VERSION" | cut -d'.' -f1)
    PHP_MINOR=$(echo "$PHP_VERSION" | cut -d'.' -f2)
    
    echo -e "   Versi PHP terdeteksi: ${CYAN}${PHP_VERSION}${NC}"
    
    if [ "$PHP_MAJOR" -ge 8 ]; then
        echo -e "${GREEN}   ✅ PHP 8.0+ terpenuhi!${NC}"
        ((PASSED++))
    elif [ "$PHP_MAJOR" -eq 7 ] && [ "$PHP_MINOR" -ge 4 ]; then
        echo -e "${YELLOW}   ⚠️  PHP 7.4+ terdeteksi. Masih bisa, tapi rekomendasi PHP 8.0+${NC}"
        ((WARNINGS++))
    else
        echo -e "${RED}   ❌ PHP terlalu lama! Minimal PHP 7.4, rekomendasi 8.0+${NC}"
        ((ERRORS++))
    fi
else
    echo -e "${RED}   ❌ PHP tidak ditemukan!${NC}"
    ((ERRORS++))
fi
echo ""

# ============================================================
# CHECK 6: DATABASE CONNECTION
# ============================================================
echo -e "${WHITE}${BOLD}[6/${TOTAL_CHECKS}] Mengecek koneksi database...${NC}"
if [ -f "$PANEL_DIR/.env" ]; then
    DB_CONNECTION=$(grep DB_CONNECTION "$PANEL_DIR/.env" | cut -d'=' -f2)
    DB_DATABASE=$(grep DB_DATABASE "$PANEL_DIR/.env" | cut -d'=' -f2)
    
    echo -e "   Database: ${CYAN}${DB_CONNECTION:-unknown}${NC} / ${CYAN}${DB_DATABASE:-unknown}${NC}"
    
    if php "$PANEL_DIR/artisan" migrate:status &>/dev/null; then
        echo -e "${GREEN}   ✅ Koneksi database OK!${NC}"
        ((PASSED++))
    else
        echo -e "${YELLOW}   ⚠️  Tidak bisa mengecek migrasi. Mungkin environment berbeda.${NC}"
        echo -e "${YELLOW}   Installer akan mencoba menjalankan migrasi nanti.${NC}"
        ((WARNINGS++))
    fi
else
    echo -e "${YELLOW}   ⚠️  File .env tidak ditemukan.${NC}"
    echo -e "${YELLOW}   Installer akan tetap mencoba koneksi database.${NC}"
    ((WARNINGS++))
fi
echo ""

# ============================================================
# CHECK 7: REGISTRASI SERVICE PROVIDER
# ============================================================
echo -e "${WHITE}${BOLD}[7/${TOTAL_CHECKS}] Mengecek registrasi Service Provider...${NC}"
if [ -f "$PANEL_DIR/config/app.php" ]; then
    if grep -q "ProtectManagerServiceProvider" "$PANEL_DIR/config/app.php" 2>/dev/null; then
        echo -e "${YELLOW}   ⚠️  Service Provider SUDAH terdaftar${NC}"
        echo -e "${YELLOW}   Mungkin dari instalasi sebelumnya. Installer akan skip.${NC}"
        ((WARNINGS++))
    else
        echo -e "${GREEN}   ✅ Service Provider belum terdaftar (aman ditambah)${NC}"
        ((PASSED++))
    fi
else
    echo -e "${RED}   ❌ config/app.php tidak ditemukan!${NC}"
    ((ERRORS++))
fi
echo ""

# ============================================================
# CHECK 8: MIDDLEWARE REGISTRATION
# ============================================================
echo -e "${WHITE}${BOLD}[8/${TOTAL_CHECKS}] Mengecek registrasi Middleware...${NC}"
if [ -f "$PANEL_DIR/app/Http/Kernel.php" ]; then
    if grep -q "ProtectMiddleware" "$PANEL_DIR/app/Http/Kernel.php" 2>/dev/null; then
        echo -e "${YELLOW}   ⚠️  Middleware SUDAH terdaftar${NC}"
        ((WARNINGS++))
    else
        echo -e "${GREEN}   ✅ Middleware belum terdaftar (aman ditambah)${NC}"
        ((PASSED++))
    fi
else
    echo -e "${RED}   ❌ app/Http/Kernel.php tidak ditemukan!${NC}"
    ((ERRORS++))
fi
echo ""

# ============================================================
# CHECK 9: ROUTES REGISTRATION
# ============================================================
echo -e "${WHITE}${BOLD}[9/${TOTAL_CHECKS}] Mengecek registrasi Routes...${NC}"
if [ -f "$PANEL_DIR/routes/admin.php" ]; then
    if grep -q "protect-routes" "$PANEL_DIR/routes/admin.php" 2>/dev/null; then
        echo -e "${YELLOW}   ⚠️  Protect routes SUDAH terdaftar${NC}"
        ((WARNINGS++))
    else
        echo -e "${GREEN}   ✅ Protect routes belum terdaftar (aman ditambah)${NC}"
        ((PASSED++))
    fi
else
    echo -e "${YELLOW}   ⚠️  routes/admin.php tidak ditemukan. Mungkin struktur berbeda.${NC}"
    echo -e "${YELLOW}   Installer akan mencoba mendaftarkan routes.${NC}"
    ((WARNINGS++))
fi
echo ""

# ============================================================
# CHECK 10: PERMISSIONS
# ============================================================
echo -e "${WHITE}${BOLD}[10/${TOTAL_CHECKS}] Mengecek permission write...${NC}"
PERMISSION_OK=true

DIRS_TO_CHECK=(
    "app"
    "app/Plugins"
    "app/Providers"
    "app/Http/Middleware"
    "app/Http/Controllers/Admin"
    "app/Helpers"
    "config"
    "routes"
    "resources/views/admin"
    "resources/views/components"
    "resources/scripts"
    "database/migrations"
)

for dir in "${DIRS_TO_CHECK[@]}"; do
    if [ -d "$PANEL_DIR/$dir" ]; then
        if [ -w "$PANEL_DIR/$dir" ]; then
            echo -e "${GREEN}   ✅ ${dir}/ writable${NC}"
        else
            echo -e "${RED}   ❌ ${dir}/ TIDAK writable!${NC}"
            PERMISSION_OK=false
            ((ERRORS++))
        fi
    else
        echo -e "${YELLOW}   ⚠️  ${dir}/ tidak ada, akan dibuat saat install${NC}"
    fi
done

if [ "$PERMISSION_OK" = true ]; then
    echo -e "${GREEN}   ✅ Semua permission OK!${NC}"
    ((PASSED++))
else
    echo -e "${RED}   ❌ Ada masalah permission!${NC}"
    echo -e "${YELLOW}   Solusi: jalankan installer dengan sudo${NC}"
    echo -e "${YELLOW}   sudo ./install.sh${NC}"
fi
echo ""

# ============================================================
# ADDITIONAL INFO
# ============================================================
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""
echo -e "${WHITE}${BOLD}📊 Informasi Tambahan:${NC}"
echo ""

# Disk space
if command -v df &> /dev/null; then
    DISK_USAGE=$(df -h "$PANEL_DIR" 2>/dev/null | tail -1 | awk '{print $5}' 2>/dev/null || echo "unknown")
    DISK_AVAIL=$(df -h "$PANEL_DIR" 2>/dev/null | tail -1 | awk '{print $4}' 2>/dev/null || echo "unknown")
    echo -e "   💾 Disk usage : ${CYAN}${DISK_USAGE:-unknown}${NC} (Available: ${CYAN}${DISK_AVAIL:-unknown}${NC})"
fi

# Memory
if command -v free &> /dev/null; then
    MEM_AVAIL=$(free -h 2>/dev/null | awk '/^Mem:/ {print $7}' 2>/dev/null || echo "unknown")
    echo -e "   🧠 Memory avail: ${CYAN}${MEM_AVAIL:-unknown}${NC}"
fi

# Nginx/Apache status
if systemctl is-active --quiet nginx 2>/dev/null; then
    echo -e "   🌐 Web server  : ${GREEN}Nginx (active)${NC}"
elif systemctl is-active --quiet apache2 2>/dev/null; then
    echo -e "   🌐 Web server  : ${GREEN}Apache (active)${NC}"
else
    echo -e "   🌐 Web server  : ${YELLOW}Unknown/Not running${NC}"
fi

# PHP-FPM status
if systemctl is-active --quiet php*-fpm 2>/dev/null; then
    PHP_FPM=$(systemctl list-units --type=service 2>/dev/null | grep php.*fpm | awk '{print $1}' | head -1)
    echo -e "   🔧 PHP-FPM     : ${GREEN}${PHP_FPM:-active}${NC}"
else
    echo -e "   🔧 PHP-FPM     : ${YELLOW}Not detected${NC}"
fi

echo ""

# ============================================================
# SUMMARY
# ============================================================
echo -e "${CYAN}╔══════════════════════════════════════════════════════════════╗${NC}"
echo -e "${CYAN}║                                                              ║${NC}"
echo -e "${CYAN}║                      📋 HASIL PENGECEKAN                     ║${NC}"
echo -e "${CYAN}║                                                              ║${NC}"
echo -e "${CYAN}╠══════════════════════════════════════════════════════════════╣${NC}"
echo -e "${CYAN}║                                                              ║${NC}"

# Hitung persentase
TOTAL_ISSUES=$((ERRORS + WARNINGS))
PASS_PERCENT=$((PASSED * 100 / TOTAL_CHECKS))

echo -e "${CYAN}║   ✅ Passed  : ${GREEN}${PASSED}/${TOTAL_CHECKS}${NC} (${GREEN}${PASS_PERCENT}%${NC})"
echo -e "${CYAN}║   ⚠️  Warning: ${YELLOW}${WARNINGS}${NC}"
echo -e "${CYAN}║   ❌ Errors  : ${RED}${ERRORS}${NC}"
echo -e "${CYAN}║                                                              ║${NC}"
echo -e "${CYAN}╠══════════════════════════════════════════════════════════════╣${NC}"
echo -e "${CYAN}║                                                              ║${NC}"

if [ $ERRORS -eq 0 ] && [ $WARNINGS -eq 0 ]; then
    echo -e "${CYAN}║   ${GREEN}🌟 SEMPURNA! ${NC}                                        ${CYAN}║${NC}"
    echo -e "${CYAN}║   ${GREEN}Panel siap diinstall Protect Manager v2.0!${NC}            ${CYAN}║${NC}"
    echo -e "${CYAN}║   ${GREEN}Jalankan: sudo ./install.sh${NC}                          ${CYAN}║${NC}"
elif [ $ERRORS -eq 0 ] && [ $WARNINGS -gt 0 ]; then
    echo -e "${CYAN}║   ${YELLOW}⚠️  ADA ${WARNINGS} PERINGATAN${NC}                                ${CYAN}║${NC}"
    echo -e "${CYAN}║   ${YELLOW}Instalasi MASIH BISA dilanjutkan.${NC}                    ${CYAN}║${NC}"
    echo -e "${CYAN}║   ${YELLOW}Jalankan: sudo ./install.sh${NC}                          ${CYAN}║${NC}"
elif [ $ERRORS -gt 0 ] && [ $ERRORS -le 3 ]; then
    echo -e "${CYAN}║   ${RED}⚠️  ADA ${ERRORS} ERROR!${NC}                                     ${CYAN}║${NC}"
    echo -e "${CYAN}║   ${RED}Perbaiki dulu masalah di atas sebelum install.${NC}        ${CYAN}║${NC}"
else
    echo -e "${CYAN}║   ${RED}🚨 TERLALU BANYAK ERROR (${ERRORS})!${NC}                          ${CYAN}║${NC}"
    echo -e "${CYAN}║   ${RED}JANGAN INSTALL! Panel mungkin tidak kompatibel.${NC}        ${CYAN}║${NC}"
    echo -e "${CYAN}║   ${RED}Hubungi developer untuk bantuan.${NC}                      ${CYAN}║${NC}"
fi

echo -e "${CYAN}║                                                              ║${NC}"
echo -e "${CYAN}╚══════════════════════════════════════════════════════════════╝${NC}"
echo ""

# ============================================================
# RECOMMENDATIONS
# ============================================================
if [ $ERRORS -gt 0 ]; then
    echo -e "${YELLOW}${BOLD}💡 Rekomendasi perbaikan:${NC}"
    echo ""
    
    if [[ " ${MISSING_SOURCE[*]} " =~ "install.sh" ]]; then
        echo -e "   ${YELLOW}• File install.sh hilang → Clone ulang repository${NC}"
    fi
    
    if [[ " ${MISSING_FOLDERS[*]} " =~ "app" ]]; then
        echo -e "   ${YELLOW}• Folder panel tidak lengkap → Pastikan ini adalah Pterodactyl Panel${NC}"
    fi
    
    if [ "$PERMISSION_OK" = false ]; then
        echo -e "   ${YELLOW}• Permission bermasalah → sudo ./install.sh${NC}"
    fi
    
    echo ""
fi

# ============================================================
# FOOTER
# ============================================================
echo -e "${PURPLE}${BOLD}👑 KALL XTREME X - Melindungi Panel Lo${NC}"
echo -e "${CYAN}📢 Channel: t.me/protectkal${NC}"
echo -e "${WHITE}💡 Tips: Script ini bisa dijalankan berkali-kali. AMAN!${NC}"
echo ""
echo -e "${YELLOW}📝 Log disimpan di: /tmp/protectkal-check-$(date +%Y%m%d_%H%M%S).log${NC}"

# ============================================================
# SAVE LOG
# ============================================================
LOG_FILE="/tmp/protectkal-check-$(date +%Y%m%d_%H%M%S).log"
{
    echo "Protect Manager Dry-Run Check Log"
    echo "================================="
    echo "Date: $(date)"
    echo "Panel: $PANEL_DIR"
    echo "Script: $SCRIPT_DIR"
    echo ""
    echo "Results:"
    echo "  Passed: $PASSED/$TOTAL_CHECKS"
    echo "  Warnings: $WARNINGS"
    echo "  Errors: $ERRORS"
    echo ""
    echo "PHP Version: ${PHP_VERSION:-unknown}"
    echo "Database: ${DB_CONNECTION:-unknown}/${DB_DATABASE:-unknown}"
} > "$LOG_FILE" 2>/dev/null || true

# ============================================================
# EXIT WITH APPROPRIATE CODE
# ============================================================
if [ $ERRORS -gt 0 ]; then
    exit 1
else
    exit 0
fi