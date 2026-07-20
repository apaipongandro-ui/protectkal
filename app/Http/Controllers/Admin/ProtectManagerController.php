<?php

namespace Pterodactyl\Http\Controllers\Admin;

use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Pterodactyl\Plugins\ProtectManagerPlugin;

class ProtectManagerController extends Controller
{
    protected $plugin;
    
    public function __construct(ProtectManagerPlugin $plugin)
    {
        $this->plugin = $plugin;
    }
    
    /**
     * Halaman utama Protect Manager
     */
    public function index()
    {
        // Hanya Root Admin yang bisa akses halaman ini
        if (Auth::id() !== 1) {
            abort(403, 'Hanya Root Admin (ID 1) yang bisa mengakses Protect Manager!');
        }
        
        $settings = DB::table('protect_settings')->first();
        
        if (!$settings) {
            // Insert default settings if not exists
            DB::table('protect_settings')->insert([
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $settings = DB::table('protect_settings')->first();
        }
        
        // Hitung proteksi aktif
        $activeCount = $this->plugin->getActiveCount();
        $inactiveCount = 14 - $activeCount;
        
        return view('admin.protect-manager', [
            'settings' => $settings,
            'activeProtects' => $activeCount,
            'inactiveProtects' => $inactiveCount,
            // 14 proteksi status
            'protect1' => $settings->protect1 ?? false,
            'protect2' => $settings->protect2 ?? false,
            'protect3' => $settings->protect3 ?? false,
            'protect4' => $settings->protect4 ?? false,
            'protect5' => $settings->protect5 ?? false,
            'protect6' => $settings->protect6 ?? false,
            'protect7' => $settings->protect7 ?? false,
            'protect8' => $settings->protect8 ?? false,
            'protect9' => $settings->protect9 ?? false,
            'protect10' => $settings->protect10 ?? false,
            'protect11' => $settings->protect11 ?? false,
            'protect12' => $settings->protect12 ?? false,
            'protect13' => $settings->protect13 ?? false,
            'protect14' => $settings->protect14 ?? false,
        ]);
    }
    
    /**
     * Toggle proteksi individual (AJAX)
     */
    public function toggle(Request $request)
    {
        if (Auth::id() !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Root Admin yang bisa mengubah proteksi!'
            ], 403);
        }
        
        $protect = $request->input('protect');
        $status = $request->input('status');
        
        // Validasi nama proteksi
        $validProtects = [
            'protect1', 'protect2', 'protect3', 'protect4',
            'protect5', 'protect6', 'protect7', 'protect8',
            'protect9', 'protect10', 'protect11', 'protect12',
            'protect13', 'protect14'
        ];
        
        if (!in_array($protect, $validProtects)) {
            return response()->json([
                'success' => false,
                'message' => 'Nama proteksi tidak valid!'
            ], 400);
        }
        
        // Update database
        DB::table('protect_settings')->update([
            $protect => (bool)$status,
            'updated_at' => now()
        ]);
        
        // Clear cache
        Cache::forget('protect_settings');
        
        $statusText = $status ? 'diaktifkan' : 'dinonaktifkan';
        $protectNumber = str_replace('protect', '', $protect);
        
        return response()->json([
            'success' => true,
            'message' => "✅ Protect {$protectNumber} berhasil {$statusText}!"
        ]);
    }
    
    /**
     * Simpan konfigurasi
     */
    public function saveConfig(Request $request)
    {
        if (Auth::id() !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Root Admin yang bisa mengubah konfigurasi!'
            ], 403);
        }
        
        $data = $request->only([
            'brand_name',
            'panel_title',
            'protection_text',
            'abort_message',
            'telegram_admin1',
            'telegram_admin2',
            'telegram_bot_username',
            'label_brand',
            'welcome_title',
            'welcome_message',
            'show_banner'
        ]);
        
        $data['updated_at'] = now();
        
        DB::table('protect_settings')->update($data);
        
        // Clear cache
        Cache::forget('protect_settings');
        
        return response()->json([
            'success' => true,
            'message' => '✅ Konfigurasi berhasil disimpan!'
        ]);
    }
    
    /**
     * Bulk install proteksi
     */
    public function bulkInstall(Request $request)
    {
        if (Auth::id() !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Root Admin yang bisa melakukan bulk install!'
            ], 403);
        }
        
        $protects = $request->input('protects', []);
        
        if (empty($protects)) {
            // Install semua
            $protects = [
                'protect1', 'protect2', 'protect3', 'protect4',
                'protect5', 'protect6', 'protect7', 'protect8',
                'protect9', 'protect10', 'protect11', 'protect12',
                'protect13', 'protect14'
            ];
        }
        
        $updateData = [];
        foreach ($protects as $protect) {
            $updateData[$protect] = true;
        }
        $updateData['updated_at'] = now();
        
        DB::table('protect_settings')->update($updateData);
        Cache::forget('protect_settings');
        
        return response()->json([
            'success' => true,
            'message' => '✅ ' . count($protects) . ' proteksi berhasil diaktifkan massal!'
        ]);
    }
    
    /**
     * Bulk uninstall proteksi
     */
    public function bulkUninstall(Request $request)
    {
        if (Auth::id() !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Root Admin yang bisa melakukan bulk uninstall!'
            ], 403);
        }
        
        $protects = $request->input('protects', []);
        
        if (empty($protects)) {
            // Uninstall semua
            $protects = [
                'protect1', 'protect2', 'protect3', 'protect4',
                'protect5', 'protect6', 'protect7', 'protect8',
                'protect9', 'protect10', 'protect11', 'protect12',
                'protect13', 'protect14'
            ];
        }
        
        $updateData = [];
        foreach ($protects as $protect) {
            $updateData[$protect] = false;
        }
        $updateData['updated_at'] = now();
        
        DB::table('protect_settings')->update($updateData);
        Cache::forget('protect_settings');
        
        return response()->json([
            'success' => true,
            'message' => '✅ ' . count($protects) . ' proteksi berhasil dinonaktifkan massal!'
        ]);
    }
}
