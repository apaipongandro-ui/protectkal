# 🛡️ ProtectKal - Pterodactyl Panel Protection Manager

**Created by KALL XTREME X for Mulia**

---

## 📋 Deskripsi

ProtectKal adalah addon proteksi lengkap untuk Pterodactyl Panel yang menyediakan **14 lapis proteksi** untuk mengamankan panel hosting Anda dari admin/sub-admin yang tidak bertanggung jawab.

---

## 🎯 Fitur Utama

### 14 Proteksi Lengkap:
1. **Anti Delete Server** - Mencegah penghapusan server
2. **Anti Hapus/Ubah User** - Lindungi data user
3. **Anti Akses Location** - Blokir menu Location
4. **Anti Akses Nodes** - Blokir menu Nodes
5. **Nests + Branding + Welcome Banner** - Sembunyikan Nests & branding
6. **Anti Akses Settings** - Blokir menu Settings
7. **Anti Akses Server File** - Proteksi file server
8. **Anti Akses Server Controller** - Proteksi kontrol server
9. **Anti Modifikasi Server** - Cegah modifikasi server
10. **Anti Tautan Server v1** - Proteksi tautan server
11. **Anti Tautan Server v2** - Proteksi lanjutan
12. **Konsolidasi Proteksi** - Proteksi menyeluruh
13. **Proteksi Application API** - Blokir API
14. **Anti Create/Delete Admin** - Kunci manajemen admin

### Fitur Tambahan:
- 🎨 Branding kustom (footer, title, badge)
- 📱 Integrasi Telegram
- 🚀 Welcome Banner di dashboard client
- ⚡ Bulk Install/Uninstall
- 🔄 Real-time toggle via AJAX
- 👑 Auto-detect Root Admin (ID 1)

---

## 🚀 Cara Install

```bash
# 1. Clone repository
cd /var/www/pterodactyl
git clone https://github.com/YOUR_USERNAME/protectkal.git
cd protectkal

# 2. Beri permission execute
chmod +x install.sh

# 3. Jalankan installer
sudo ./install.sh

# 4. Selesai! Akses di:
# https://panel-anda.com/admin/protect-manager
