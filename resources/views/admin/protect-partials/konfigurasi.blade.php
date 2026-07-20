{{-- 
╔══════════════════════════════════════════════════════════════╗
║     🛡️ PROTECT MANAGER v2.0 - CANVA EDITION                ║
║     👑 KALL XTREME X untuk MULIA                           ║
║     📁 File: resources/views/admin/protect-partials/       ║
║              konfigurasi.blade.php                          ║
╚══════════════════════════════════════════════════════════════╝
--}}

<div class="pm-config-container">
    
    {{-- ============================================================ --}}
    {{-- KONFIGURASI HEADER --}}
    {{-- ============================================================ --}}
    <div class="pm-header" style="border-radius: 25px; padding: 30px; margin-bottom: 0;">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 style="font-weight: 700; margin-bottom: 5px;">
                    <i class="fas fa-cogs me-2" style="color: #A78BFA;"></i> 
                    Konfigurasi Protect Manager
                </h5>
                <p style="color: var(--text-muted); font-size: 0.85em; margin-bottom: 0;">
                    Atur semua pengaturan branding, integrasi, dan pesan kustom
                </p>
            </div>
            <div>
                <span class="pm-badge" style="background: var(--gradient-canva); font-size: 0.8em; padding: 10px 20px;">
                    <i class="fas fa-sync-alt me-1"></i> Auto-Save: <span id="autoSaveStatus">Ready</span>
                </span>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- CONFIGURATION FORM --}}
        {{-- ============================================================ --}}
        <form id="configForm" autocomplete="off">
            @csrf
            
            {{-- ============================================================ --}}
            {{-- SECTION 1: BRAND IDENTITY --}}
            {{-- ============================================================ --}}
            <div class="pm-config-section">
                <div class="pm-section-header">
                    <div class="pm-section-icon" style="background: rgba(139, 92, 246, 0.15); color: #A78BFA;">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <div>
                        <h6 class="pm-section-title">Identitas Brand (Branding)</h6>
                        <p class="pm-section-desc">Nama brand, judul panel, dan teks yang muncul di seluruh panel</p>
                    </div>
                </div>
                
                <div class="row g-3">
                    {{-- Nama Brand --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label" for="brand_name">
                                <i class="fas fa-tag me-1"></i> Nama Brand
                            </label>
                            <input type="text" 
                                   name="brand_name" 
                                   id="brand_name" 
                                   class="form-control pm-input" 
                                   value="{{ $settings->brand_name ?? 'ProtectKal' }}" 
                                   placeholder="Masukkan nama brand Anda"
                                   maxlength="50"
                                   data-preview="brand">
                            <small class="pm-help-text">
                                Nama brand yang tampil di <strong>footer panel</strong> dan <strong>credit</strong>
                            </small>
                        </div>
                    </div>
                    
                    {{-- Judul Panel --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label" for="panel_title">
                                <i class="fas fa-window-maximize me-1"></i> Judul Panel (Title Bar)
                            </label>
                            <input type="text" 
                                   name="panel_title" 
                                   id="panel_title" 
                                   class="form-control pm-input" 
                                   value="{{ $settings->panel_title ?? 'Pterodactyl Panel' }}" 
                                   placeholder="Judul di tab browser"
                                   maxlength="100"
                                   data-preview="title">
                            <small class="pm-help-text">
                                Teks yang muncul di <strong>tab browser</strong> (tag &lt;title&gt;)
                            </small>
                        </div>
                    </div>
                    
                    {{-- Teks Proteksi --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label" for="protection_text">
                                <i class="fas fa-shield-alt me-1"></i> Teks Proteksi (Badge)
                            </label>
                            <input type="text" 
                                   name="protection_text" 
                                   id="protection_text" 
                                   class="form-control pm-input" 
                                   value="{{ $settings->protection_text ?? '🛡️ Protected by ProtectKal' }}" 
                                   placeholder="Teks badge proteksi"
                                   maxlength="100"
                                   data-preview="badge">
                            <small class="pm-help-text">
                                Teks yang muncul sebagai <strong>badge proteksi</strong> di panel
                            </small>
                        </div>
                    </div>
                    
                    {{-- Label Brand --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label" for="label_brand">
                                <i class="fas fa-trademark me-1"></i> Label Brand
                            </label>
                            <input type="text" 
                                   name="label_brand" 
                                   id="label_brand" 
                                   class="form-control pm-input" 
                                   value="{{ $settings->label_brand ?? 'ProtectKal' }}" 
                                   placeholder="Label brand"
                                   maxlength="50"
                                   data-preview="label">
                            <small class="pm-help-text">
                                Label brand untuk <strong>identifikasi</strong> di berbagai tempat
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- ============================================================ --}}
            {{-- SECTION 2: TELEGRAM INTEGRATION --}}
            {{-- ============================================================ --}}
            <div class="pm-config-section">
                <div class="pm-section-header">
                    <div class="pm-section-icon" style="background: rgba(69, 183, 209, 0.15); color: #45B7D1;">
                        <i class="fab fa-telegram"></i>
                    </div>
                    <div>
                        <h6 class="pm-section-title">Integrasi Telegram</h6>
                        <p class="pm-section-desc">Hubungkan dengan Telegram untuk notifikasi dan kontak admin</p>
                    </div>
                </div>
                
                <div class="row g-3">
                    {{-- Telegram Admin 1 --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label" for="telegram_admin1">
                                <i class="fab fa-telegram me-1"></i> Telegram Admin 1
                            </label>
                            <div class="input-group">
                                <span class="input-group-text pm-input-group-text">@</span>
                                <input type="text" 
                                       name="telegram_admin1" 
                                       id="telegram_admin1" 
                                       class="form-control pm-input" 
                                       value="{{ $settings->telegram_admin1 ?? '' }}" 
                                       placeholder="username_admin1"
                                       maxlength="50">
                            </div>
                            <small class="pm-help-text">
                                Username Telegram admin <strong>utama</strong> (tanpa @)
                            </small>
                        </div>
                    </div>
                    
                    {{-- Telegram Admin 2 --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label" for="telegram_admin2">
                                <i class="fab fa-telegram me-1"></i> Telegram Admin 2
                            </label>
                            <div class="input-group">
                                <span class="input-group-text pm-input-group-text">@</span>
                                <input type="text" 
                                       name="telegram_admin2" 
                                       id="telegram_admin2" 
                                       class="form-control pm-input" 
                                       value="{{ $settings->telegram_admin2 ?? '' }}" 
                                       placeholder="username_admin2"
                                       maxlength="50">
                            </div>
                            <small class="pm-help-text">
                                Username Telegram admin <strong>cadangan</strong> (opsional)
                            </small>
                        </div>
                    </div>
                    
                    {{-- Bot Username --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label" for="telegram_bot_username">
                                <i class="fas fa-robot me-1"></i> Username Bot Telegram
                            </label>
                            <div class="input-group">
                                <span class="input-group-text pm-input-group-text">@</span>
                                <input type="text" 
                                       name="telegram_bot_username" 
                                       id="telegram_bot_username" 
                                       class="form-control pm-input" 
                                       value="{{ $settings->telegram_bot_username ?? '' }}" 
                                       placeholder="nama_bot_anda"
                                       maxlength="50">
                            </div>
                            <small class="pm-help-text">
                                Username bot Telegram untuk <strong>notifikasi otomatis</strong> (opsional)
                            </small>
                        </div>
                    </div>
                    
                    {{-- Test Telegram Button --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label">&nbsp;</label>
                            <button type="button" class="pm-btn-outline w-100" id="testTelegramBtn" onclick="testTelegram()">
                                <i class="fab fa-telegram me-2"></i> Test Koneksi Telegram
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- ============================================================ --}}
            {{-- SECTION 3: WELCOME BANNER --}}
            {{-- ============================================================ --}}
            <div class="pm-config-section">
                <div class="pm-section-header">
                    <div class="pm-section-icon" style="background: rgba(67, 233, 123, 0.15); color: #43e97b;">
                        <i class="fas fa-flag"></i>
                    </div>
                    <div>
                        <h6 class="pm-section-title">Welcome Banner (Client Dashboard)</h6>
                        <p class="pm-section-desc">Banner selamat datang yang muncul di dashboard client</p>
                    </div>
                </div>
                
                <div class="row g-3">
                    {{-- Judul Banner --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label" for="welcome_title">
                                <i class="fas fa-heading me-1"></i> Judul Banner
                            </label>
                            <input type="text" 
                                   name="welcome_title" 
                                   id="welcome_title" 
                                   class="form-control pm-input" 
                                   value="{{ $settings->welcome_title ?? 'Selamat Datang!' }}" 
                                   placeholder="Judul welcome banner"
                                   maxlength="100"
                                   data-preview="bannerTitle">
                            <small class="pm-help-text">
                                Judul besar yang muncul di <strong>bagian atas banner</strong>
                            </small>
                        </div>
                    </div>
                    
                    {{-- Toggle Banner --}}
                    <div class="col-md-6">
                        <div class="pm-form-group">
                            <label class="pm-label" for="show_banner">
                                <i class="fas fa-toggle-on me-1"></i> Tampilkan Banner
                            </label>
                            <div class="pm-toggle-container mt-2">
                                <div class="form-check form-switch pm-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="show_banner" 
                                           id="show_banner" 
                                           value="1" 
                                           {{ $settings->show_banner ? 'checked' : '' }}
                                           onchange="toggleBannerPreview(this.checked)">
                                </div>
                                <label class="pm-toggle-label" for="show_banner" id="showBannerLabel">
                                    {{ $settings->show_banner ? '✅ Banner Aktif' : '❌ Banner Nonaktif' }}
                                </label>
                            </div>
                            <small class="pm-help-text">
                                Aktifkan/nonaktifkan welcome banner di <strong>dashboard client</strong>
                            </small>
                        </div>
                    </div>
                    
                    {{-- Pesan Banner --}}
                    <div class="col-12">
                        <div class="pm-form-group">
                            <label class="pm-label" for="welcome_message">
                                <i class="fas fa-comment-dots me-1"></i> Pesan Banner
                            </label>
                            <textarea name="welcome_message" 
                                      id="welcome_message" 
                                      class="form-control pm-input" 
                                      rows="5" 
                                      placeholder="Tulis pesan selamat datang untuk client...&#10;&#10;Tips: Gunakan @username untuk mention Telegram"
                                      maxlength="500"
                                      data-preview="bannerMessage">{{ $settings->welcome_message ?? '' }}</textarea>
                            <small class="pm-help-text">
                                <span id="charCount">0</span>/500 karakter | 
                                Mendukung <strong>@username Telegram</strong> dan <strong>HTML basic</strong>
                            </small>
                        </div>
                    </div>
                    
                    {{-- Preview Banner --}}
                    <div class="col-12">
                        <div class="pm-banner-preview" id="bannerPreview" style="{{ !$settings->show_banner ? 'display: none;' : '' }}">
                            <div class="pm-banner-preview-header">
                                <i class="fas fa-eye me-1"></i> Preview Banner
                            </div>
                            <div class="pm-banner-preview-content">
                                <h5 id="previewBannerTitle">{{ $settings->welcome_title ?? 'Selamat Datang!' }}</h5>
                                <p id="previewBannerMessage">{{ $settings->welcome_message ?? 'Selamat datang di panel hosting kami!' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- ============================================================ --}}
            {{-- SECTION 4: CUSTOM ABORT MESSAGE --}}
            {{-- ============================================================ --}}
            <div class="pm-config-section">
                <div class="pm-section-header">
                    <div class="pm-section-icon" style="background: rgba(244, 63, 94, 0.15); color: #F43F5E;">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div>
                        <h6 class="pm-section-title">Custom Pesan Akses Ditolak</h6>
                        <p class="pm-section-desc">Pesan yang muncul saat admin lain mencoba mengakses menu terlarang</p>
                    </div>
                </div>
                
                <div class="row g-3">
                    {{-- Abort Message --}}
                    <div class="col-12">
                        <div class="pm-form-group">
                            <label class="pm-label" for="abort_message">
                                <i class="fas fa-exclamation-triangle me-1"></i> Pesan Error (Abort Message)
                            </label>
                            <textarea name="abort_message" 
                                      id="abort_message" 
                                      class="form-control pm-input" 
                                      rows="4" 
                                      placeholder="Pesan yang muncul saat admin lain mencoba akses menu terlarang..."
                                      maxlength="300">{{ $settings->abort_message ?? '' }}</textarea>
                            <small class="pm-help-text">
                                <span id="abortCharCount">0</span>/300 karakter | 
                                Kosongkan untuk menggunakan <strong>pesan default</strong>
                            </small>
                        </div>
                    </div>
                    
                    {{-- Preview Abort --}}
                    <div class="col-12">
                        <button type="button" class="pm-btn-outline" onclick="previewAbortMessage()">
                            <i class="fas fa-eye me-2"></i> Preview Pesan Error
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- ============================================================ --}}
            {{-- ACTION BUTTONS --}}
            {{-- ============================================================ --}}
            <div class="pm-config-actions">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <button type="button" class="pm-btn-outline me-2" onclick="resetConfig()">
                            <i class="fas fa-undo me-2"></i> Reset ke Default
                        </button>
                        <button type="button" class="pm-btn-outline" onclick="exportConfig()">
                            <i class="fas fa-download me-2"></i> Export Config
                        </button>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="button" id="saveConfigBtn" class="pm-btn">
                            <i class="fas fa-save me-2"></i> Simpan Konfigurasi
                        </button>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
    
    {{-- ============================================================ --}}
    {{-- SAVE STATUS INDICATOR --}}
    {{-- ============================================================ --}}
    <div class="pm-save-indicator" id="saveIndicator" style="display: none;">
        <div class="pm-save-indicator-content">
            <i class="fas fa-check-circle"></i> Konfigurasi berhasil disimpan!
        </div>
    </div>

</div>

{{-- ============================================================ --}}
{{-- INLINE STYLES --}}
{{-- ============================================================ --}}
<style>
    /* Config Sections */
    .pm-config-section {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }
    
    .pm-config-section:hover {
        border-color: var(--glass-border-hover);
    }
    
    .pm-section-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--glass-border);
    }
    
    .pm-section-icon {
        width: 45px;
        height: 45px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2em;
        flex-shrink: 0;
    }
    
    .pm-section-title {
        font-weight: 700;
        margin-bottom: 2px;
        font-size: 1em;
    }
    
    .pm-section-desc {
        color: var(--text-muted);
        font-size: 0.8em;
        margin-bottom: 0;
    }
    
    /* Form Groups */
    .pm-form-group {
        margin-bottom: 5px;
    }
    
    .pm-label {
        color: var(--text-secondary);
        font-size: 0.85em;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }
    
    .pm-help-text {
        color: var(--text-muted);
        font-size: 0.75em;
        margin-top: 6px;
        display: block;
    }
    
    .pm-input-group-text {
        background: var(--glass-bg) !important;
        border: 1px solid var(--glass-border) !important;
        color: var(--text-secondary) !important;
        font-weight: 600;
    }
    
    /* Toggle Container */
    .pm-toggle-container {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .pm-toggle-label {
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.9em;
        cursor: pointer;
    }
    
    /* Banner Preview */
    .pm-banner-preview {
        background: var(--gradient-canva);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
    }
    
    .pm-banner-preview-header {
        background: rgba(0,0,0,0.2);
        padding: 10px 20px;
        font-size: 0.8em;
        color: rgba(255,255,255,0.8);
    }
    
    .pm-banner-preview-content {
        padding: 25px;
        text-align: center;
    }
    
    .pm-banner-preview-content h5 {
        font-weight: 800;
        margin-bottom: 10px;
    }
    
    .pm-banner-preview-content p {
        opacity: 0.95;
        margin-bottom: 0;
    }
    
    /* Config Actions */
    .pm-config-actions {
        padding-top: 20px;
        border-top: 1px solid var(--glass-border);
        margin-top: 10px;
    }
    
    /* Save Indicator */
    .pm-save-indicator {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999;
        animation: pm-slideUp 0.4s ease;
    }
    
    .pm-save-indicator-content {
        background: var(--gradient-4);
        color: #1a1a2e;
        padding: 15px 25px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9em;
        box-shadow: 0 10px 30px rgba(67, 233, 123, 0.4);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    @keyframes pm-slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .pm-config-actions .col-md-6 {
            text-align: center !important;
            margin-bottom: 10px;
        }
        
        .pm-config-actions .text-end {
            text-align: center !important;
        }
        
        .pm-section-header {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

{{-- ============================================================ --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================ --}}
<script>
    $(document).ready(function() {
        
        // ============================================================
        // CHARACTER COUNTERS
        // ============================================================
        function updateCharCounts() {
            const welcomeMsg = $('#welcome_message').val() || '';
            const abortMsg = $('#abort_message').val() || '';
            
            $('#charCount').text(welcomeMsg.length);
            $('#abortCharCount').text(abortMsg.length);
            
            // Warn if near limit
            if (welcomeMsg.length > 450) {
                $('#charCount').css('color', '#FFD93D');
            } else {
                $('#charCount').css('color', '');
            }
            
            if (abortMsg.length > 250) {
                $('#abortCharCount').css('color', '#FFD93D');
            } else {
                $('#abortCharCount').css('color', '');
            }
        }
        
        $('#welcome_message, #abort_message').on('input', updateCharCounts);
        updateCharCounts(); // Initial count
        
        // ============================================================
        // LIVE PREVIEW UPDATES
        // ============================================================
        $('[data-preview]').on('input', function() {
            const previewType = $(this).data('preview');
            const value = $(this).val();
            
            switch(previewType) {
                case 'brand':
                    $('#previewBrand, #footerBrandName').text(value || 'ProtectKal');
                    break;
                case 'title':
                    document.title = value || 'Pterodactyl Panel';
                    break;
                case 'badge':
                    $('#previewBadge').text(value || '🛡️ Protected by ProtectKal');
                    break;
                case 'bannerTitle':
                    $('#previewBannerTitle').text(value || 'Selamat Datang!');
                    break;
                case 'bannerMessage':
                    $('#previewBannerMessage').text(value || 'Selamat datang di panel hosting kami!');
                    break;
            }
        });
        
        // ============================================================
        // TOGGLE BANNER PREVIEW
        // ============================================================
        window.toggleBannerPreview = function(show) {
            if (show) {
                $('#bannerPreview').slideDown(300);
                $('#showBannerLabel').text('✅ Banner Aktif');
            } else {
                $('#bannerPreview').slideUp(300);
                $('#showBannerLabel').text('❌ Banner Nonaktif');
            }
        };
        
        // ============================================================
        // PREVIEW ABORT MESSAGE
        // ============================================================
        window.previewAbortMessage = function() {
            const message = $('#abort_message').val() || '🛡️ Akses ditolak oleh ProtectKal! Hubungi Root Admin.';
            
            Swal.fire({
                icon: 'error',
                title: 'Preview Pesan Akses Ditolak',
                html: '<div style="background: rgba(244,63,94,0.1); padding: 20px; border-radius: 15px; border: 1px solid rgba(244,63,94,0.3); margin-top: 15px;">' + 
                      message + 
                      '</div>',
                confirmButtonText: 'Tutup',
                background: '#1a1a2e',
                color: '#fff',
                confirmButtonColor: '#8B5CF6'
            });
        };
        
        // ============================================================
        // TEST TELEGRAM
        // ============================================================
        window.testTelegram = function() {
            const admin1 = $('#telegram_admin1').val();
            const admin2 = $('#telegram_admin2').val();
            const bot = $('#telegram_bot_username').val();
            
            if (!admin1 && !admin2 && !bot) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Kosong',
                    text: 'Isi minimal satu username Telegram terlebih dahulu.',
                    background: '#1a1a2e',
                    color: '#fff'
                });
                return;
            }
            
            Swal.fire({
                title: '🔍 Test Koneksi Telegram',
                html: `
                    <p>Memeriksa username Telegram...</p>
                    <div style="background: var(--glass-bg); border-radius: 10px; padding: 15px; margin-top: 10px;">
                        ${admin1 ? '<p>✅ @' + admin1 + ' - Username valid</p>' : ''}
                        ${admin2 ? '<p>✅ @' + admin2 + ' - Username valid</p>' : ''}
                        ${bot ? '<p>✅ @' + bot + ' - Username valid</p>' : ''}
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.85em; margin-top: 10px;">
                        ⚠️ Ini hanya pengecekan format. Pastikan bot sudah di-configure di server.
                    </p>
                `,
                icon: 'info',
                background: '#1a1a2e',
                color: '#fff',
                confirmButtonColor: '#8B5CF6'
            });
        };
        
        // ============================================================
        // RESET CONFIG
        // ============================================================
        window.resetConfig = function() {
            Swal.fire({
                title: 'Reset Konfigurasi?',
                text: 'Semua pengaturan akan dikembalikan ke default. Lanjutkan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal',
                background: '#1a1a2e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#brand_name').val('ProtectKal');
                    $('#panel_title').val('Pterodactyl Panel');
                    $('#protection_text').val('🛡️ Protected by ProtectKal');
                    $('#label_brand').val('ProtectKal');
                    $('#telegram_admin1').val('');
                    $('#telegram_admin2').val('');
                    $('#telegram_bot_username').val('');
                    $('#welcome_title').val('Selamat Datang!');
                    $('#welcome_message').val('Selamat datang di panel hosting kami! Hubungi admin untuk bantuan.');
                    $('#abort_message').val('');
                    $('#show_banner').prop('checked', true);
                    toggleBannerPreview(true);
                    updateCharCounts();
                    
                    // Trigger preview updates
                    $('[data-preview]').trigger('input');
                    
                    Swal.fire({
                        icon: 'success',
                        title: '✅ Direset!',
                        text: 'Konfigurasi dikembalikan ke default. Jangan lupa simpan!',
                        timer: 2500,
                        showConfirmButton: false,
                        background: '#1a1a2e',
                        color: '#fff'
                    });
                }
            });
        };
        
        // ============================================================
        // EXPORT CONFIG
        // ============================================================
        window.exportConfig = function() {
            const config = {
                brand_name: $('#brand_name').val(),
                panel_title: $('#panel_title').val(),
                protection_text: $('#protection_text').val(),
                label_brand: $('#label_brand').val(),
                telegram_admin1: $('#telegram_admin1').val(),
                telegram_admin2: $('#telegram_admin2').val(),
                telegram_bot_username: $('#telegram_bot_username').val(),
                welcome_title: $('#welcome_title').val(),
                welcome_message: $('#welcome_message').val(),
                show_banner: $('#show_banner').is(':checked'),
                abort_message: $('#abort_message').val()
            };
            
            const jsonStr = JSON.stringify(config, null, 2);
            const blob = new Blob([jsonStr], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'protectkal-config-' + new Date().toISOString().slice(0,10) + '.json';
            a.click();
            URL.revokeObjectURL(url);
            
            Swal.fire({
                icon: 'success',
                title: '✅ Diexport!',
                text: 'File konfigurasi telah didownload.',
                timer: 2000,
                showConfirmButton: false,
                background: '#1a1a2e',
                color: '#fff'
            });
        };
        
        // ============================================================
        // SAVE CONFIGURATION
        // ============================================================
        $('#saveConfigBtn').on('click', function(e) {
            e.preventDefault();
            
            var btn = $(this);
            var originalHtml = btn.html();
            
            // Loading state
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...');
            btn.prop('disabled', true);
            $('#autoSaveStatus').text('Saving...');
            
            $.ajax({
                url: '{{ route("admin.protect-manager.config.save") }}',
                type: 'POST',
                data: $('#configForm').serialize(),
                success: function(response) {
                    if (response.success) {
                        // Show success indicator
                        $('#saveIndicator').fadeIn(300).delay(2500).fadeOut(300);
                        $('#autoSaveStatus').text('✅ Saved');
                        
                        // Update preview
                        const brandName = $('#brand_name').val() || 'ProtectKal';
                        const protectionText = $('#protection_text').val() || '🛡️ Protected';
                        $('#previewBrand, #footerBrandName').text(brandName);
                        $('#previewBadge').text(protectionText);
                        document.title = $('#panel_title').val() || 'Pterodactyl Panel';
                        
                        // Toast
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            background: '#1a1a2e',
                            color: '#fff'
                        });
                        Toast.fire({
                            icon: 'success',
                            title: '✅ Konfigurasi Tersimpan!'
                        });
                        
                        // Log
                        console.log('✅ Konfigurasi berhasil disimpan:', new Date().toLocaleTimeString());
                    }
                },
                error: function(xhr) {
                    $('#autoSaveStatus').text('❌ Failed');
                    
                    let errorMsg = 'Terjadi kesalahan server';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Gagal Menyimpan!',
                        text: errorMsg,
                        background: '#1a1a2e',
                        color: '#fff'
                    });
                },
                complete: function() {
                    btn.html(originalHtml);
                    btn.prop('disabled', false);
                    
                    setTimeout(() => {
                        $('#autoSaveStatus').text('Ready');
                    }, 2000);
                }
            });
        });
        
        // ============================================================
        // AUTO-SAVE (Optional - uncomment to enable)
        // ============================================================
        /*
        let autoSaveTimeout;
        $('#configForm input, #configForm textarea').on('input', function() {
            clearTimeout(autoSaveTimeout);
            $('#autoSaveStatus').text('⏳ Pending...');
            
            autoSaveTimeout = setTimeout(() => {
                $('#saveConfigBtn').trigger('click');
            }, 3000);
        });
        */
        
        // ============================================================
        // KEYBOARD SHORTCUT: Ctrl+S to save
        // ============================================================
        $(document).on('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                $('#saveConfigBtn').trigger('click');
            }
        });
        
        console.log('⚙️ Konfigurasi Tab loaded!');
    });
</script>