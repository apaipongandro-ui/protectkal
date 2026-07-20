{{-- 
╔══════════════════════════════════════════════════════════════╗
║     🛡️ PROTECT MANAGER v2.0 - CANVA EDITION                ║
║     👑 KALL XTREME X untuk MULIA                           ║
║     📁 File: resources/views/admin/protect-partials/       ║
║              massal.blade.php                               ║
╚══════════════════════════════════════════════════════════════╝
--}}

<div class="pm-massal-container">
    
    {{-- ============================================================ --}}
    {{-- INFO ALERT --}}
    {{-- ============================================================ --}}
    <div class="pm-alert pm-alert-info animate-in delay-1">
        <div class="pm-alert-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="pm-alert-content">
            <h6 class="pm-alert-title">Fitur Akses Massal</h6>
            <p class="pm-alert-text">
                Fitur ini memungkinkan Anda mengaktifkan atau menonaktifkan <strong>semua 14 proteksi</strong> sekaligus. 
                Gunakan dengan hati-hati! Hanya <strong>Root Admin (ID 1)</strong> yang dapat menggunakan fitur ini.
            </p>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- STATS SUMMARY --}}
    {{-- ============================================================ --}}
    <div class="pm-massal-stats animate-in delay-2">
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="pm-massal-stat-card">
                    <div class="pm-massal-stat-icon" style="color: #43e97b;">✅</div>
                    <div class="pm-massal-stat-value" id="massalActiveCount">{{ $activeProtects ?? 0 }}</div>
                    <div class="pm-massal-stat-label">Aktif</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="pm-massal-stat-card">
                    <div class="pm-massal-stat-icon" style="color: #F43F5E;">⛔</div>
                    <div class="pm-massal-stat-value" id="massalInactiveCount">{{ $inactiveProtects ?? 14 }}</div>
                    <div class="pm-massal-stat-label">Nonaktif</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="pm-massal-stat-card">
                    <div class="pm-massal-stat-icon" style="color: #FFD93D;">📊</div>
                    <div class="pm-massal-stat-value" id="massalPercentage">{{ $activeProtects ? round(($activeProtects/14)*100) : 0 }}%</div>
                    <div class="pm-massal-stat-label">Persentase</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="pm-massal-stat-card">
                    <div class="pm-massal-stat-icon" style="color: #45B7D1;">🎯</div>
                    <div class="pm-massal-stat-value">14</div>
                    <div class="pm-massal-stat-label">Total</div>
                </div>
            </div>
        </div>
        
        {{-- Progress Bar --}}
        <div class="pm-massal-progress mt-3">
            <div class="pm-massal-progress-bar">
                <div class="pm-massal-progress-fill" id="massalProgressFill" 
                     style="width: {{ $activeProtects ? round(($activeProtects/14)*100) : 0 }}%;">
                </div>
            </div>
            <div class="pm-massal-progress-text">
                <span id="massalProgressLabel">{{ $activeProtects ? round(($activeProtects/14)*100) : 0 }}% proteksi aktif</span>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MAIN ACTION CARDS --}}
    {{-- ============================================================ --}}
    <div class="row g-4 mt-3">
        
        {{-- ============================================================ --}}
        {{-- BULK INSTALL CARD --}}
        {{-- ============================================================ --}}
        <div class="col-md-6">
            <div class="pm-massal-card pm-massal-install animate-in delay-3">
                <div class="pm-massal-card-glow"></div>
                <div class="pm-massal-card-content">
                    <div class="pm-massal-card-icon-wrapper">
                        <div class="pm-massal-card-icon">
                            🚀
                        </div>
                    </div>
                    
                    <h4 class="pm-massal-card-title">Bulk Install</h4>
                    <p class="pm-massal-card-desc">
                        Aktifkan <strong>semua 14 proteksi</strong> sekaligus untuk mengamankan panel secara penuh.
                    </p>
                    
                    <div class="pm-massal-card-features">
                        <div class="pm-massal-feature">
                            <i class="fas fa-check-circle"></i> Anti Delete Server
                        </div>
                        <div class="pm-massal-feature">
                            <i class="fas fa-check-circle"></i> Anti Modifikasi User
                        </div>
                        <div class="pm-massal-feature">
                            <i class="fas fa-check-circle"></i> Proteksi Nodes & Locations
                        </div>
                        <div class="pm-massal-feature">
                            <i class="fas fa-check-circle"></i> Branding & Welcome Banner
                        </div>
                        <div class="pm-massal-feature">
                            <i class="fas fa-check-circle"></i> API & Admin Protection
                        </div>
                        <div class="pm-massal-feature">
                            <i class="fas fa-check-circle"></i> + 9 Proteksi Lainnya
                        </div>
                    </div>
                    
                    <button class="pm-massal-btn pm-massal-btn-install" 
                            onclick="ProtectManager.bulkInstall()" 
                            {{ Auth::id() !== 1 ? 'disabled' : '' }}
                            id="bulkInstallBtn">
                        <i class="fas fa-shield-haltered me-2"></i> 
                        INSTALL SEMUA PROTEKSI
                        <span class="pm-massal-btn-badge">14</span>
                    </button>
                    
                    <div class="pm-massal-card-status">
                        <i class="fas fa-info-circle me-1"></i>
                        Status saat ini: <strong id="bulkInstallStatus">{{ $activeProtects ?? 0 }}/14 proteksi aktif</strong>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- ============================================================ --}}
        {{-- BULK UNINSTALL CARD --}}
        {{-- ============================================================ --}}
        <div class="col-md-6">
            <div class="pm-massal-card pm-massal-uninstall animate-in delay-4">
                <div class="pm-massal-card-glow"></div>
                <div class="pm-massal-card-content">
                    <div class="pm-massal-card-icon-wrapper uninstall">
                        <div class="pm-massal-card-icon">
                            🗑️
                        </div>
                    </div>
                    
                    <h4 class="pm-massal-card-title">Bulk Uninstall</h4>
                    <p class="pm-massal-card-desc">
                        Nonaktifkan <strong>semua 14 proteksi</strong> sekaligus. Panel akan kembali ke mode normal.
                    </p>
                    
                    <div class="pm-massal-card-warning">
                        <div class="pm-massal-warning-icon">⚠️</div>
                        <div class="pm-massal-warning-text">
                            <strong>PERINGATAN!</strong> Panel tidak akan terlindungi dari admin lain setelah uninstall.
                        </div>
                    </div>
                    
                    <button class="pm-massal-btn pm-massal-btn-uninstall" 
                            onclick="ProtectManager.bulkUninstall()" 
                            {{ Auth::id() !== 1 ? 'disabled' : '' }}
                            id="bulkUninstallBtn">
                        <i class="fas fa-unlock me-2"></i> 
                        UNINSTALL SEMUA PROTEKSI
                        <span class="pm-massal-btn-badge">14</span>
                    </button>
                    
                    <div class="pm-massal-card-status">
                        <i class="fas fa-info-circle me-1"></i>
                        Status saat ini: <strong id="bulkUninstallStatus">{{ $inactiveProtects ?? 14 }}/14 proteksi nonaktif</strong>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    {{-- ============================================================ --}}
    {{-- SELECTIVE BULK SECTION --}}
    {{-- ============================================================ --}}
    <div class="pm-massal-selective animate-in delay-5 mt-4">
        <div class="pm-header" style="border-radius: 20px; padding: 25px; margin-bottom: 0;">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 style="font-weight: 700; margin: 0;">
                    <i class="fas fa-check-square me-2" style="color: #A78BFA;"></i>
                    Pilih Proteksi yang Ingin Diatur
                </h6>
                <div>
                    <button class="pm-btn-sm pm-btn-success me-2" onclick="selectAllProtects()">
                        <i class="fas fa-check-double"></i> Pilih Semua
                    </button>
                    <button class="pm-btn-sm pm-btn-danger" onclick="deselectAllProtects()">
                        <i class="fas fa-times"></i> Hapus Semua
                    </button>
                </div>
            </div>
            
            {{-- Protect Checklist Grid --}}
            <div class="row g-3" id="selectiveProtectList">
                @php
                $protectsChecklist = [
                    ['id' => 'protect1', 'name' => 'Anti Delete Server', 'icon' => '🗑️'],
                    ['id' => 'protect2', 'name' => 'Anti Hapus/Ubah User', 'icon' => '👤'],
                    ['id' => 'protect3', 'name' => 'Anti Akses Location', 'icon' => '📍'],
                    ['id' => 'protect4', 'name' => 'Anti Akses Nodes', 'icon' => '🖥️'],
                    ['id' => 'protect5', 'name' => 'Nests + Branding + Banner', 'icon' => '🎨'],
                    ['id' => 'protect6', 'name' => 'Anti Akses Settings', 'icon' => '⚙️'],
                    ['id' => 'protect7', 'name' => 'Anti Akses Server File', 'icon' => '📁'],
                    ['id' => 'protect8', 'name' => 'Anti Akses Server Controller', 'icon' => '🎮'],
                    ['id' => 'protect9', 'name' => 'Anti Modifikasi Server', 'icon' => '🔄'],
                    ['id' => 'protect10', 'name' => 'Anti Tautan Server v1', 'icon' => '🔗'],
                    ['id' => 'protect11', 'name' => 'Anti Tautan Server v2', 'icon' => '🔒'],
                    ['id' => 'protect12', 'name' => 'Konsolidasi Proteksi', 'icon' => '🛡️'],
                    ['id' => 'protect13', 'name' => 'Proteksi Application API', 'icon' => '🔑'],
                    ['id' => 'protect14', 'name' => 'Anti Create/Delete Admin', 'icon' => '👑'],
                ];
                @endphp
                
                @foreach($protectsChecklist as $protect)
                <div class="col-md-6">
                    <div class="pm-checklist-item {{ $settings->{$protect['id']} ? 'active' : '' }}" id="checklist-{{ $protect['id'] }}">
                        <div class="form-check">
                            <input class="form-check-input selective-checkbox" 
                                   type="checkbox" 
                                   value="{{ $protect['id'] }}" 
                                   id="selective_{{ $protect['id'] }}"
                                   {{ $settings->{$protect['id']} ? 'checked' : '' }}
                                   {{ Auth::id() !== 1 ? 'disabled' : '' }}
                                   onchange="updateSelectiveCount()">
                            <label class="form-check-label" for="selective_{{ $protect['id'] }}">
                                <span class="pm-checklist-icon">{{ $protect['icon'] }}</span>
                                {{ $protect['name'] }}
                                @if($settings->{$protect['id']})
                                    <span class="badge badge-sm" style="background: var(--gradient-4);">AKTIF</span>
                                @else
                                    <span class="badge badge-sm" style="background: rgba(255,255,255,0.1);">NONAKTIF</span>
                                @endif
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Selective Action Buttons --}}
            <div class="pm-selective-actions mt-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <span class="pm-selective-count" id="selectiveCount">
                            <span id="selectedCount">0</span> proteksi dipilih
                        </span>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="pm-btn pm-btn-success me-2" onclick="selectiveInstall()" {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                            <i class="fas fa-check me-2"></i> Install Terpilih
                        </button>
                        <button class="pm-btn pm-btn-danger" onclick="selectiveUninstall()" {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                            <i class="fas fa-times me-2"></i> Uninstall Terpilih
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- HISTORY LOG (Optional) --}}
    {{-- ============================================================ --}}
    <div class="pm-massal-history animate-in delay-6 mt-4">
        <div class="pm-header" style="border-radius: 20px; padding: 25px; margin-bottom: 0;">
            <h6 style="font-weight: 700; margin-bottom: 15px;">
                <i class="fas fa-history me-2" style="color: #FFD93D;"></i>
                Log Aktivitas Massal
            </h6>
            <div id="massalLogContainer">
                <div class="pm-log-empty">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada aktivitas massal</p>
                    <small>Aktivitas akan tercatat di sini setelah Anda melakukan bulk install/uninstall</small>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ============================================================ --}}
{{-- INLINE STYLES --}}
{{-- ============================================================ --}}
<style>
    /* Alert */
    .pm-alert {
        display: flex;
        gap: 15px;
        padding: 20px 25px;
        border-radius: 20px;
        margin-bottom: 20px;
        border: 1px solid;
    }
    
    .pm-alert-info {
        background: rgba(69, 183, 209, 0.1);
        border-color: rgba(69, 183, 209, 0.3);
    }
    
    .pm-alert-icon {
        font-size: 1.5em;
        color: #45B7D1;
        flex-shrink: 0;
        margin-top: 3px;
    }
    
    .pm-alert-title {
        font-weight: 700;
        margin-bottom: 5px;
        color: #45B7D1;
    }
    
    .pm-alert-text {
        color: var(--text-secondary);
        font-size: 0.9em;
        margin-bottom: 0;
    }
    
    /* Massal Stats */
    .pm-massal-stat-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .pm-massal-stat-card:hover {
        border-color: var(--glass-border-hover);
        transform: translateY(-3px);
    }
    
    .pm-massal-stat-icon {
        font-size: 1.8em;
        margin-bottom: 8px;
    }
    
    .pm-massal-stat-value {
        font-size: 2em;
        font-weight: 800;
    }
    
    .pm-massal-stat-label {
        font-size: 0.75em;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    /* Progress Bar */
    .pm-massal-progress-bar {
        width: 100%;
        height: 8px;
        background: rgba(255,255,255,0.1);
        border-radius: 4px;
        overflow: hidden;
    }
    
    .pm-massal-progress-fill {
        height: 100%;
        background: var(--gradient-4);
        border-radius: 4px;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .pm-massal-progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .pm-massal-progress-text {
        text-align: center;
        font-size: 0.8em;
        color: var(--text-muted);
        margin-top: 8px;
    }
    
    /* Massal Cards */
    .pm-massal-card {
        position: relative;
        background: var(--glass-bg);
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        border: 1px solid var(--glass-border);
        border-radius: 25px;
        overflow: hidden;
        transition: all 0.4s ease;
        height: 100%;
    }
    
    .pm-massal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    
    .pm-massal-install:hover {
        border-color: rgba(67, 233, 123, 0.5);
    }
    
    .pm-massal-uninstall:hover {
        border-color: rgba(244, 63, 94, 0.5);
    }
    
    .pm-massal-card-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        opacity: 0;
        transition: opacity 0.4s ease;
        pointer-events: none;
    }
    
    .pm-massal-install .pm-massal-card-glow {
        background: radial-gradient(circle, rgba(67, 233, 123, 0.15), transparent 70%);
    }
    
    .pm-massal-uninstall .pm-massal-card-glow {
        background: radial-gradient(circle, rgba(244, 63, 94, 0.15), transparent 70%);
    }
    
    .pm-massal-card:hover .pm-massal-card-glow {
        opacity: 1;
    }
    
    .pm-massal-card-content {
        position: relative;
        z-index: 1;
        padding: 35px 30px;
        text-align: center;
    }
    
    .pm-massal-card-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        background: var(--gradient-card);
        border: 1px solid var(--glass-border);
    }
    
    .pm-massal-card-icon-wrapper.uninstall {
        background: rgba(244, 63, 94, 0.1);
        border-color: rgba(244, 63, 94, 0.3);
    }
    
    .pm-massal-card-icon {
        font-size: 2.5em;
        animation: float 3s infinite ease-in-out;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .pm-massal-card-title {
        font-weight: 800;
        font-size: 1.5em;
        margin-bottom: 12px;
    }
    
    .pm-massal-card-desc {
        color: var(--text-muted);
        font-size: 0.9em;
        margin-bottom: 20px;
    }
    
    /* Features List */
    .pm-massal-card-features {
        text-align: left;
        margin-bottom: 25px;
        padding: 15px;
        background: rgba(255,255,255,0.03);
        border-radius: 15px;
    }
    
    .pm-massal-feature {
        padding: 6px 0;
        font-size: 0.85em;
        color: var(--text-secondary);
    }
    
    .pm-massal-feature i {
        color: #43e97b;
        margin-right: 8px;
    }
    
    /* Warning */
    .pm-massal-card-warning {
        display: flex;
        gap: 10px;
        padding: 15px;
        background: rgba(244, 63, 94, 0.1);
        border: 1px solid rgba(244, 63, 94, 0.3);
        border-radius: 15px;
        margin-bottom: 25px;
        text-align: left;
    }
    
    .pm-massal-warning-icon {
        font-size: 1.5em;
        flex-shrink: 0;
    }
    
    .pm-massal-warning-text {
        font-size: 0.85em;
        color: #F43F5E;
    }
    
    /* Buttons */
    .pm-massal-btn {
        width: 100%;
        padding: 16px 30px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.95em;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }
    
    .pm-massal-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .pm-massal-btn-install {
        background: var(--gradient-4);
        color: #1a1a2e;
        box-shadow: 0 8px 25px rgba(67, 233, 123, 0.3);
    }
    
    .pm-massal-btn-install:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(67, 233, 123, 0.5);
    }
    
    .pm-massal-btn-uninstall {
        background: transparent;
        color: #F43F5E;
        border: 2px solid rgba(244, 63, 94, 0.5);
    }
    
    .pm-massal-btn-uninstall:hover:not(:disabled) {
        background: rgba(244, 63, 94, 0.1);
        border-color: #F43F5E;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(244, 63, 94, 0.3);
    }
    
    .pm-massal-btn-badge {
        background: rgba(255,255,255,0.3);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.8em;
        font-weight: 800;
    }
    
    /* Card Status */
    .pm-massal-card-status {
        margin-top: 15px;
        font-size: 0.8em;
        color: var(--text-muted);
    }
    
    /* Checklist */
    .pm-checklist-item {
        padding: 12px 15px;
        border-radius: 12px;
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        transition: all 0.3s ease;
    }
    
    .pm-checklist-item:hover {
        border-color: var(--glass-border-hover);
    }
    
    .pm-checklist-item.active {
        background: rgba(67, 233, 123, 0.05);
        border-color: rgba(67, 233, 123, 0.3);
    }
    
    .pm-checklist-icon {
        margin-right: 6px;
    }
    
    .pm-checklist-item .form-check-label {
        color: var(--text-secondary);
        font-size: 0.9em;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .pm-checklist-item .form-check-input {
        cursor: pointer;
    }
    
    .pm-checklist-item .form-check-input:checked {
        background-color: #43e97b;
        border-color: #43e97b;
    }
    
    .badge-sm {
        font-size: 0.65em;
        padding: 3px 10px;
        border-radius: 50px;
        font-weight: 600;
    }
    
    /* Selective Actions */
    .pm-selective-actions {
        padding-top: 20px;
        border-top: 1px solid var(--glass-border);
    }
    
    .pm-selective-count {
        color: var(--text-muted);
        font-size: 0.9em;
    }
    
    #selectedCount {
        font-weight: 700;
        color: #A78BFA;
        font-size: 1.1em;
    }
    
    /* Log */
    .pm-log-empty {
        text-align: center;
        padding: 30px;
        color: var(--text-muted);
    }
    
    .pm-log-empty i {
        font-size: 3em;
        margin-bottom: 15px;
        opacity: 0.5;
    }
    
    .pm-log-empty p {
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .pm-log-empty small {
        font-size: 0.8em;
    }
    
    /* Log Item */
    .pm-log-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        background: var(--glass-bg);
        border-radius: 12px;
        margin-bottom: 8px;
    }
    
    .pm-log-item-icon {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9em;
        flex-shrink: 0;
    }
    
    .pm-log-item-icon.install {
        background: rgba(67, 233, 123, 0.2);
        color: #43e97b;
    }
    
    .pm-log-item-icon.uninstall {
        background: rgba(244, 63, 94, 0.2);
        color: #F43F5E;
    }
    
    .pm-log-item-info {
        flex: 1;
    }
    
    .pm-log-item-title {
        font-weight: 600;
        font-size: 0.85em;
    }
    
    .pm-log-item-time {
        font-size: 0.75em;
        color: var(--text-muted);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .pm-massal-card-content {
            padding: 25px 20px;
        }
        
        .pm-massal-card-icon-wrapper {
            width: 60px;
            height: 60px;
        }
        
        .pm-massal-card-icon {
            font-size: 2em;
        }
        
        .pm-selective-actions .col-md-6 {
            text-align: center !important;
            margin-bottom: 10px;
        }
        
        .pm-selective-actions .text-end {
            text-align: center !important;
        }
        
        .pm-massal-btn {
            font-size: 0.85em;
        }
    }
</style>

{{-- ============================================================ --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================ --}}
<script>
    $(document).ready(function() {
        
        // ============================================================
        // UPDATE SELECTIVE COUNT
        // ============================================================
        window.updateSelectiveCount = function() {
            const selected = $('.selective-checkbox:checked').length;
            $('#selectedCount').text(selected);
            
            // Update checklist item styles
            $('.selective-checkbox').each(function() {
                const id = $(this).val();
                const item = $('#checklist-' + id);
                if ($(this).is(':checked')) {
                    item.addClass('active');
                } else {
                    item.removeClass('active');
                }
            });
        };
        
        // Initialize count
        updateSelectiveCount();
        
        // ============================================================
        // SELECT ALL
        // ============================================================
        window.selectAllProtects = function() {
            $('.selective-checkbox').prop('checked', true);
            updateSelectiveCount();
        };
        
        // ============================================================
        // DESELECT ALL
        // ============================================================
        window.deselectAllProtects = function() {
            $('.selective-checkbox').prop('checked', false);
            updateSelectiveCount();
        };
        
        // ============================================================
        // SELECTIVE INSTALL
        // ============================================================
        window.selectiveInstall = function() {
            const selected = [];
            $('.selective-checkbox:checked').each(function() {
                selected.push($(this).val());
            });
            
            if (selected.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Proteksi',
                    text: 'Pilih minimal satu proteksi untuk diinstall.',
                    background: '#1a1a2e',
                    color: '#fff'
                });
                return;
            }
            
            Swal.fire({
                title: 'Konfirmasi Selective Install',
                html: 'Anda akan <strong>mengaktifkan ' + selected.length + ' proteksi</strong>. Lanjutkan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Install!',
                cancelButtonText: 'Batal',
                background: '#1a1a2e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    executeSelectiveAction('install', selected);
                }
            });
        };
        
        // ============================================================
        // SELECTIVE UNINSTALL
        // ============================================================
        window.selectiveUninstall = function() {
            const selected = [];
            $('.selective-checkbox:checked').each(function() {
                selected.push($(this).val());
            });
            
            if (selected.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Proteksi',
                    text: 'Pilih minimal satu proteksi untuk di-uninstall.',
                    background: '#1a1a2e',
                    color: '#fff'
                });
                return;
            }
            
            Swal.fire({
                title: 'Konfirmasi Selective Uninstall',
                html: 'Anda akan <strong>menonaktifkan ' + selected.length + ' proteksi</strong>. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Uninstall!',
                cancelButtonText: 'Batal',
                background: '#1a1a2e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    executeSelectiveAction('uninstall', selected);
                }
            });
        };
        
        // ============================================================
        // EXECUTE SELECTIVE ACTION
        // ============================================================
        function executeSelectiveAction(action, selectedProtects) {
            // Show loading
            Swal.fire({
                title: '⏳ Memproses...',
                text: 'Sedang ' + (action === 'install' ? 'mengaktifkan' : 'menonaktifkan') + ' proteksi terpilih...',
                allowOutsideClick: false,
                showConfirmButton: false,
                background: '#1a1a2e',
                color: '#fff',
                didOpen: () => Swal.showLoading()
            });
            
            $.ajax({
                url: '/admin/protect-manager/bulk/' + action,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    protects: selectedProtects
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '✅ Berhasil!',
                            text: response.message,
                            timer: 2500,
                            showConfirmButton: false,
                            background: '#1a1a2e',
                            color: '#fff'
                        }).then(() => {
                            location.reload();
                        });
                        
                        // Add log
                        addMassalLog(action, selectedProtects.length);
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Gagal!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                        background: '#1a1a2e',
                        color: '#fff'
                    });
                }
            });
        }
        
        // ============================================================
        // ADD LOG ENTRY
        // ============================================================
        function addMassalLog(action, count) {
            const now = new Date();
            const timeStr = now.toLocaleString('id-ID');
            const actionText = action === 'install' ? 'Install' : 'Uninstall';
            const iconClass = action === 'install' ? 'install' : 'uninstall';
            const icon = action === 'install' ? '✅' : '🗑️';
            
            const logHtml = `
                <div class="pm-log-item animate-in">
                    <div class="pm-log-item-icon ${iconClass}">${icon}</div>
                    <div class="pm-log-item-info">
                        <div class="pm-log-item-title">${actionText} ${count} proteksi</div>
                        <div class="pm-log-item-time">${timeStr}</div>
                    </div>
                </div>
            `;
            
            // Remove empty state if exists
            $('.pm-log-empty').remove();
            
            // Prepend to log container
            $('#massalLogContainer').prepend(logHtml);
            
            // Keep only last 10 logs
            const logs = $('#massalLogContainer .pm-log-item');
            if (logs.length > 10) {
                logs.last().remove();
            }
            
            // Save to localStorage
            saveMassalLogs();
        }
        
        // ============================================================
        // SAVE LOGS TO LOCALSTORAGE
        // ============================================================
        function saveMassalLogs() {
            const logs = [];
            $('#massalLogContainer .pm-log-item').each(function() {
                logs.push({
                    title: $(this).find('.pm-log-item-title').text(),
                    time: $(this).find('.pm-log-item-time').text(),
                    icon: $(this).find('.pm-log-item-icon').text(),
                    type: $(this).find('.pm-log-item-icon').hasClass('install') ? 'install' : 'uninstall'
                });
            });
            
            try {
                localStorage.setItem('pmMassalLogs', JSON.stringify(logs));
            } catch(e) {}
        }
        
        // ============================================================
        // LOAD LOGS FROM LOCALSTORAGE
        // ============================================================
        function loadMassalLogs() {
            try {
                const saved = localStorage.getItem('pmMassalLogs');
                if (saved) {
                    const logs = JSON.parse(saved);
                    $('.pm-log-empty').remove();
                    
                    logs.forEach(log => {
                        const iconClass = log.type === 'install' ? 'install' : 'uninstall';
                        const logHtml = `
                            <div class="pm-log-item">
                                <div class="pm-log-item-icon ${iconClass}">${log.icon}</div>
                                <div class="pm-log-item-info">
                                    <div class="pm-log-item-title">${log.title}</div>
                                    <div class="pm-log-item-time">${log.time}</div>
                                </div>
                            </div>
                        `;
                        $('#massalLogContainer').prepend(logHtml);
                    });
                }
            } catch(e) {}
        }
        
        // Load logs on page load
        loadMassalLogs();
        
        // ============================================================
        // CONSOLE LOG
        // ============================================================
        console.log('📦 Akses Massal Tab loaded!');
        console.log('💡 Tersedia: Bulk Install, Bulk Uninstall, Selective Install/Uninstall');
    });
</script>