<?php

namespace Pterodactyl\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class ProtectHelper
{
    /**
     * Cek apakah user adalah Root Admin
     */
    public static function isRootAdmin()
    {
        return Auth::check() && Auth::id() === 1;
    }
    
    /**
     * Dapatkan semua settings proteksi
     */
    public static function getSettings()
    {
        return Cache::remember('protect_settings', 3600, function () {
            return DB::table('protect_settings')->first();
        });
    }
    
    /**
     * Cek apakah proteksi tertentu aktif
     */
    public static function isProtectionActive($name)
    {
        $settings = self::getSettings();
        
        if (!$settings) return false;
        
        $protects = [
            'delete_server' => 'protect1',
            'modify_user' => 'protect2',
            'access_location' => 'protect3',
            'access_nodes' => 'protect4',
            'nests_branding' => 'protect5',
            'access_settings' => 'protect6',
            'server_file' => 'protect7',
            'server_controller' => 'protect8',
            'modify_server' => 'protect9',
            'server_link' => 'protect10',
            'server_link_v2' => 'protect11',
            'consolidation' => 'protect12',
            'app_api' => 'protect13',
            'create_delete_admin' => 'protect14'
        ];
        
        if (isset($protects[$name])) {
            $column = $protects[$name];
            return (bool) ($settings->{$column} ?? false);
        }
        
        return false;
    }
    
    /**
     * Dapatkan nama brand
     */
    public static function getBrandName()
    {
        $settings = self::getSettings();
        return $settings->brand_name ?? 'ProtectKal';
    }
    
    /**
     * Dapatkan pesan abort
     */
    public static function getAbortMessage($type = 'default')
    {
        $settings = self::getSettings();
        
        if ($settings && $settings->abort_message) {
            return $settings->abort_message;
        }
        
        return '🛡️ Akses ditolak oleh ProtectKal! Hubungi Root Admin.';
    }
    
    /**
     * Dapatkan welcome banner data
     */
    public static function getWelcomeBanner()
    {
        $settings = self::getSettings();
        
        if (!$settings || !$settings->show_banner) {
            return null;
        }
        
        return [
            'title' => $settings->welcome_title ?? 'Selamat Datang!',
            'message' => $settings->welcome_message ?? '',
            'telegram_admin1' => $settings->telegram_admin1 ?? null,
            'telegram_admin2' => $settings->telegram_admin2 ?? null,
        ];
    }
}
