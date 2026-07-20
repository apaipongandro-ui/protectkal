{{-- Akses Massal Tab - Canva Edition --}}

<div class="row g-4">
    <div class="col-md-6">
        <div class="pm-header text-center" style="border-radius: 25px; padding: 40px; border-color: rgba(67, 233, 123, 0.5);">
            <div style="font-size: 3.5em;" class="mb-3">🚀</div>
            <h5 style="font-weight: 700;" class="mb-3">Bulk Install</h5>
            <p style="color: var(--text-muted);" class="mb-4">Aktifkan <strong>semua 14 proteksi</strong> sekaligus!</p>
            <button class="pm-btn" onclick="ProtectManager.bulkInstall()" {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                <i class="fas fa-shield-haltered me-2"></i> INSTALL SEMUA
            </button>
            <div class="mt-3" style="color: var(--text-muted); font-size: 0.85em;">
                Status: <strong>{{ $activeProtects ?? 0 }}</strong>/14 aktif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="pm-header text-center" style="border-radius: 25px; padding: 40px; border-color: rgba(244, 63, 94, 0.5);">
            <div style="font-size: 3.5em;" class="mb-3">🗑️</div>
            <h5 style="font-weight: 700;" class="mb-3">Bulk Uninstall</h5>
            <p style="color: var(--text-muted);" class="mb-4">Nonaktifkan <strong>semua 14 proteksi</strong>!</p>
            <button class="pm-btn-outline" onclick="ProtectManager.bulkUninstall()" {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                <i class="fas fa-unlock me-2"></i> UNINSTALL SEMUA
            </button>
            <div class="mt-3" style="color: var(--text-muted); font-size: 0.85em;">
                Status: <strong>{{ $inactiveProtects ?? 0 }}</strong>/14 nonaktif
            </div>
        </div>
    </div>
</div>