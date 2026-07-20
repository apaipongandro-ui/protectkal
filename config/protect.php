<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ProtectKal Configuration
    |--------------------------------------------------------------------------
    | KALL XTREME X - Protect Manager for Pterodactyl Panel
    | Dibuat untuk Mulia
    */
    
    // Nama brand yang tampil di footer
    'brand_name' => env('PROTECT_BRAND_NAME', 'ProtectKal'),
    
    // Judul panel di tab browser
    'panel_title' => env('PROTECT_PANEL_TITLE', 'Pterodactyl Panel - Protected'),
    
    // Teks proteksi
    'protection_text' => env('PROTECT_TEXT', '🛡️ Protected by ProtectKal'),
    
    // Label brand
    'label_brand' => env('PROTECT_LABEL', 'ProtectKal'),
    
    // Telegram Integration
    'telegram' => [
        'admin1' => env('PROTECT_TELEGRAM_ADMIN1', ''),
        'admin2' => env('PROTECT_TELEGRAM_ADMIN2', ''),
        'bot_username' => env('PROTECT_TELEGRAM_BOT', ''),
    ],
    
    // Welcome Banner
    'welcome_banner' => [
        'enabled' => env('PROTECT_BANNER_ENABLED', false),
        'title' => env('PROTECT_BANNER_TITLE', 'Selamat Datang!'),
        'message' => env('PROTECT_BANNER_MESSAGE', ''),
    ],
    
    // Custom Abort Messages
    'abort_messages' => [
        'default' => '🛡️ Akses ditolak oleh ProtectKal!',
        'delete_server' => '❌ PROTECT1: Anda tidak diizinkan menghapus server!',
        'modify_user' => '❌ PROTECT2: Anda tidak diizinkan mengubah data user!',
        'access_location' => '❌ PROTECT3: Menu Location dikunci!',
        'access_nodes' => '❌ PROTECT4: Menu Nodes dikunci!',
        'access_nests' => '❌ PROTECT5: Menu Nests disembunyikan!',
        'access_settings' => '❌ PROTECT6: Menu Settings dikunci!',
        'server_file' => '❌ PROTECT7: Akses file server diblokir!',
        'server_controller' => '❌ PROTECT8: Kontrol server diblokir!',
        'modify_server' => '❌ PROTECT9: Modifikasi server dilarang!',
        'server_link' => '❌ PROTECT10: Tautan server dilindungi!',
        'server_link_v2' => '❌ PROTECT11: Tautan server dikunci ketat!',
        'consolidation' => '❌ PROTECT12: Konsolidasi proteksi aktif!',
        'app_api' => '❌ PROTECT13: Application API dikunci!',
        'create_delete_admin' => '❌ PROTECT14: Manajemen admin dikunci!',
    ],
    
    // 14 Proteksi Status (bisa di-override via database)
    'protections' => [
        'protect1' => false,  // Anti Delete Server
        'protect2' => false,  // Anti Hapus/Ubah User
        'protect3' => false,  // Anti Akses Location
        'protect4' => false,  // Anti Akses Nodes
        'protect5' => false,  // Nests + Branding + Welcome Banner
        'protect6' => false,  // Anti Akses Settings
        'protect7' => false,  // Anti Akses Server File
        'protect8' => false,  // Anti Akses Server Controller
        'protect9' => false,  // Anti Modifikasi Server
        'protect10' => false, // Anti Tautan Server v1
        'protect11' => false, // Anti Tautan Server v2
        'protect12' => false, // Konsolidasi Proteksi
        'protect13' => false, // Proteksi Application API
        'protect14' => false, // Anti Create/Delete Admin
    ],
];
