<?php

use Illuminate\Support\Facades\Route;
use Pterodactyl\Http\Controllers\Admin\ProtectManagerController;

/*
|--------------------------------------------------------------------------
| Protect Manager Routes - KALL XTREME X
|--------------------------------------------------------------------------
| Semua route untuk Protect Manager
*/

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth', 'admin']], function () {
    
    // Halaman utama Protect Manager
    Route::get('/protect-manager', [ProtectManagerController::class, 'index'])
         ->name('admin.protect-manager.index');
    
    // Toggle individual protection (AJAX)
    Route::post('/protect-manager/toggle', [ProtectManagerController::class, 'toggle'])
         ->name('admin.protect-manager.toggle');
    
    // Save konfigurasi
    Route::post('/protect-manager/config/save', [ProtectManagerController::class, 'saveConfig'])
         ->name('admin.protect-manager.config.save');
    
    // Bulk install proteksi
    Route::post('/protect-manager/bulk/install', [ProtectManagerController::class, 'bulkInstall'])
         ->name('admin.protect-manager.bulk.install');
    
    // Bulk uninstall proteksi
    Route::post('/protect-manager/bulk/uninstall', [ProtectManagerController::class, 'bulkUninstall'])
         ->name('admin.protect-manager.bulk.uninstall');
});
