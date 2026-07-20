{{-- 
╔══════════════════════════════════════════════════════════════╗
║     🛡️ PROTECT MANAGER v2.0 - CANVA EDITION                ║
║     👑 KALL XTREME X untuk MULIA                           ║
║     📁 File: resources/views/admin/protect-partials/       ║
║              branding.blade.php                             ║
║     📌 THE LAST FILE - GRAND FINALE                        ║
╚══════════════════════════════════════════════════════════════╝
--}}

<div class="pm-branding-container">
    
    {{-- ============================================================ --}}
    {{-- LIVE PREVIEW TOGGLE --}}
    {{-- ============================================================ --}}
    <div class="pm-branding-preview-toggle animate-in delay-1">
        <div class="pm-header" style="border-radius: 20px; padding: 20px 25px; margin-bottom: 25px;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 style="font-weight: 700; margin: 0;">
                        <i class="fas fa-eye me-2" style="color: #FFD93D;"></i>
                        Live Preview Mode
                    </h6>
                    <small style="color: var(--text-muted);">Preview real-time dari semua elemen branding</small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span style="color: var(--text-muted); font-size: 0.8em;">Preview:</span>
                    <div class="pm-preview-mode-buttons">
                        <button class="pm-preview-mode-btn active" data-mode="all" onclick="switchPreviewMode('all')">
                            <i class="fas fa-th-large"></i> Semua
                        </button>
                        <button class="pm-preview-mode-btn" data-mode="footer" onclick="switchPreviewMode('footer')">
                            <i class="fas fa-window-maximize"></i> Footer
                        </button>
                        <button class="pm-preview-mode-btn" data-mode="badge" onclick="switchPreviewMode('badge')">
                            <i class="fas fa-shield-alt"></i> Badge
                        </button>
                        <button class="pm-preview-mode-btn" data-mode="banner" onclick="switchPreviewMode('banner')">
                            <i class="fas fa-flag"></i> Banner
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- PREVIEW SECTIONS --}}
    {{-- ============================================================ --}}
    
    {{-- Preview: Footer Panel --}}
    <div class="pm-branding-preview-section animate-in delay-2" id="previewSectionFooter">
        <div class="pm-header" style="border-radius: 20px; padding: 25px; margin-bottom: 20px;">
            <div class="pm-preview-section-header">
                <div class="pm-preview-section-icon" style="background: rgba(139, 92, 246, 0.15); color: #A78BFA;">
                    <i class="fas fa-window-maximize"></i>
                </div>
                <div>
                    <h6 class="pm-preview-section-title">Footer Panel</h6>
                    <p class="pm-preview-section-desc">Tampilan footer di bagian bawah panel</p>
                </div>
                <span class="pm-preview-badge">Live</span>
            </div>
            
            {{-- Footer Preview --}}
            <div class="pm-footer-preview">
                <div class="pm-footer-preview-bar"></div>
                <div class="pm-footer-preview-content">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-md-start text-center mb-2 mb-md-0">
                            <span class="pm-footer-preview-brand" id="previewFooterBrand">{{ $settings->brand_name ?? 'ProtectKal' }}</span>
                            <span class="pm-footer-preview-year">© {{ date('Y') }}</span>
                        </div>
                        <div class="col-md-4 text-center mb-2 mb-md-0">
                            <span class="pm-footer-preview-powered">
                                Powered by <strong class="pm-gradient-text" id="previewFooterPowered">KALL XTREME X</strong>
                            </span>
                        </div>
                        <div class="col-md-4 text-md-end text-center">
                            <span class="pm-footer-preview-made">
                                Dibuat untuk <strong id="previewFooterMade">Mulia</strong> 👑
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Footer Settings --}}
            <div class="pm-preview-settings mt-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="pm-mini-label">Nama Brand</label>
                        <input type="text" class="form-control pm-input pm-input-sm" 
                               id="inputBrandName" 
                               value="{{ $settings->brand_name ?? 'ProtectKal' }}"
                               oninput="updateFooterPreview()"
                               placeholder="Nama brand">
                    </div>
                    <div class="col-md-4">
                        <label class="pm-mini-label">Powered By</label>
                        <input type="text" class="form-control pm-input pm-input-sm" 
                               id="inputPoweredBy" 
                               value="KALL XTREME X"
                               oninput="updateFooterPreview()"
                               placeholder="Powered by">
                    </div>
                    <div class="col-md-4">
                        <label class="pm-mini-label">Dibuat Untuk</label>
                        <input type="text" class="form-control pm-input pm-input-sm" 
                               id="inputMadeFor" 
                               value="Mulia"
                               oninput="updateFooterPreview()"
                               placeholder="Nama">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Preview: Badge Proteksi --}}
    <div class="pm-branding-preview-section animate-in delay-3" id="previewSectionBadge">
        <div class="pm-header" style="border-radius: 20px; padding: 25px; margin-bottom: 20px;">
            <div class="pm-preview-section-header">
                <div class="pm-preview-section-icon" style="background: rgba(236, 72, 153, 0.15); color: #EC4899;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <h6 class="pm-preview-section-title">Badge Proteksi</h6>
                    <p class="pm-preview-section-desc">Badge yang muncul di panel saat proteksi aktif</p>
                </div>
                <span class="pm-preview-badge">Live</span>
            </div>
            
            {{-- Badge Preview --}}
            <div class="pm-badge-preview-area">
                <div class="pm-badge-preview-item">
                    <span class="pm-badge-preview-label">Small:</span>
                    <span class="pm-badge" style="background: var(--gradient-canva); font-size: 0.7em; padding: 6px 14px;" id="previewBadgeSmall">
                        {{ $settings->protection_text ?? '🛡️ Protected' }}
                    </span>
                </div>
                <div class="pm-badge-preview-item">
                    <span class="pm-badge-preview-label">Medium:</span>
                    <span class="pm-badge" style="background: var(--gradient-canva); font-size: 0.85em; padding: 10px 20px;" id="previewBadgeMedium">
                        {{ $settings->protection_text ?? '🛡️ Protected by ProtectKal' }}
                    </span>
                </div>
                <div class="pm-badge-preview-item">
                    <span class="pm-badge-preview-label">Large:</span>
                    <span class="pm-badge" style="background: var(--gradient-canva); font-size: 1em; padding: 14px 28px;" id="previewBadgeLarge">
                        {{ $settings->protection_text ?? '🛡️ Protected by ProtectKal' }}
                    </span>
                </div>
            </div>
            
            {{-- Badge Settings --}}
            <div class="pm-preview-settings mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <label class="pm-mini-label">Teks Badge</label>
                        <input type="text" class="form-control pm-input pm-input-sm" 
                               id="inputBadgeText" 
                               value="{{ $settings->protection_text ?? '🛡️ Protected by ProtectKal' }}"
                               oninput="updateBadgePreview()"
                               placeholder="Teks badge">
                    </div>
                    <div class="col-md-6">
                        <label class="pm-mini-label">Style Badge</label>
                        <select class="form-control pm-input pm-input-sm" id="inputBadgeStyle" onchange="updateBadgeStyle()">
                            <option value="gradient-canva">Canva Gradient (Default)</option>
                            <option value="gradient-1">Blue-Purple</option>
                            <option value="gradient-2">Pink-Rose</option>
                            <option value="gradient-4">Green-Teal</option>
                            <option value="solid-purple">Solid Purple</option>
                            <option value="solid-pink">Solid Pink</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Preview: Welcome Banner --}}
    <div class="pm-branding-preview-section animate-in delay-4" id="previewSectionBanner">
        <div class="pm-header" style="border-radius: 20px; padding: 25px; margin-bottom: 20px;">
            <div class="pm-preview-section-header">
                <div class="pm-preview-section-icon" style="background: rgba(67, 233, 123, 0.15); color: #43e97b;">
                    <i class="fas fa-flag"></i>
                </div>
                <div>
                    <h6 class="pm-preview-section-title">Welcome Banner</h6>
                    <p class="pm-preview-section-desc">Banner yang muncul di dashboard client</p>
                </div>
                <span class="pm-preview-badge">Live</span>
            </div>
            
            {{-- Banner Preview --}}
            <div class="pm-banner-preview-wrapper" id="bannerPreviewWrapper">
                <div class="pm-banner-preview-container" style="background: var(--gradient-canva);">
                    <div class="pm-banner-preview-inner">
                        <h4 class="pm-banner-preview-title" id="previewBannerTitle">
                            {{ $settings->welcome_title ?? 'Selamat Datang!' }}
                        </h4>
                        <p class="pm-banner-preview-message" id="previewBannerMessage">
                            {{ $settings->welcome_message ?? 'Selamat datang di panel hosting kami! Hubungi admin jika ada kendala.' }}
                        </p>
                        <div class="pm-banner-preview-buttons">
                            <button class="pm-banner-preview-btn">Dashboard</button>
                            <button class="pm-banner-preview-btn outline">Hubungi Admin</button>
                        </div>
                    </div>
                    <div class="pm-banner-preview-decoration">
                        <div class="pm-banner-circle circle-1"></div>
                        <div class="pm-banner-circle circle-2"></div>
                        <div class="pm-banner-circle circle-3"></div>
                    </div>
                </div>
            </div>
            
            {{-- Banner Settings --}}
            <div class="pm-preview-settings mt-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="pm-mini-label">Judul Banner</label>
                        <input type="text" class="form-control pm-input pm-input-sm" 
                               id="inputBannerTitle" 
                               value="{{ $settings->welcome_title ?? 'Selamat Datang!' }}"
                               oninput="updateBannerPreview()"
                               placeholder="Judul banner">
                    </div>
                    <div class="col-md-6">
                        <label class="pm-mini-label">Tampilkan Banner</label>
                        <div class="pm-toggle-container mt-2">
                            <div class="form-check form-switch pm-switch">
                                <input class="form-check-input" type="checkbox" 
                                       id="inputShowBanner" 
                                       {{ $settings->show_banner ? 'checked' : '' }}
                                       onchange="toggleBannerPreview(this.checked)">
                            </div>
                            <label class="pm-toggle-label" for="inputShowBanner" id="showBannerLabel">
                                {{ $settings->show_banner ? '✅ Aktif' : '❌ Nonaktif' }}
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="pm-mini-label">Pesan Banner</label>
                        <textarea class="form-control pm-input pm-input-sm" 
                                  id="inputBannerMessage" 
                                  rows="3"
                                  oninput="updateBannerPreview()"
                                  placeholder="Pesan selamat datang...">{{ $settings->welcome_message ?? '' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="pm-mini-label">Warna Banner</label>
                        <select class="form-control pm-input pm-input-sm" id="inputBannerStyle" onchange="updateBannerStyle()">
                            <option value="gradient-canva">Canva (Default)</option>
                            <option value="gradient-1">Blue-Purple</option>
                            <option value="gradient-2">Pink-Rose</option>
                            <option value="gradient-4">Green-Teal</option>
                            <option value="gradient-5">Coral-Yellow</option>
                            <option value="solid-dark">Solid Dark</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="pm-mini-label">Animasi Banner</label>
                        <select class="form-control pm-input pm-input-sm" id="inputBannerAnimation">
                            <option value="fade">Fade In</option>
                            <option value="slide">Slide Down</option>
                            <option value="scale">Scale In</option>
                            <option value="none">Tanpa Animasi</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Preview: Kombinasi Title Bar --}}
    <div class="pm-branding-preview-section animate-in delay-5" id="previewSectionTitle">
        <div class="pm-header" style="border-radius: 20px; padding: 25px; margin-bottom: 20px;">
            <div class="pm-preview-section-header">
                <div class="pm-preview-section-icon" style="background: rgba(255, 217, 61, 0.15); color: #FFD93D;">
                    <i class="fas fa-window-maximize"></i>
                </div>
                <div>
                    <h6 class="pm-preview-section-title">Title Bar Browser</h6>
                    <p class="pm-preview-section-desc">Preview judul yang muncul di tab browser</p>
                </div>
                <span class="pm-preview-badge">Live</span>
            </div>
            
            {{-- Browser Tab Simulation --}}
            <div class="pm-browser-preview">
                <div class="pm-browser-bar">
                    <div class="pm-browser-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="pm-browser-url">
                        <i class="fas fa-lock"></i> panel-anda.com/admin/protect-manager
                    </div>
                </div>
                <div class="pm-browser-tab">
                    <div class="pm-browser-tab-icon">🛡️</div>
                    <div class="pm-browser-tab-title" id="previewTitleBar">
                        {{ $settings->panel_title ?? 'Pterodactyl Panel - Protected by ProtectKal' }}
                    </div>
                    <div class="pm-browser-tab-close">×</div>
                </div>
            </div>
            
            {{-- Title Settings --}}
            <div class="pm-preview-settings mt-3">
                <div class="row">
                    <div class="col-md-8">
                        <label class="pm-mini-label">Judul Browser (Title Tag)</label>
                        <input type="text" class="form-control pm-input pm-input-sm" 
                               id="inputPanelTitle" 
                               value="{{ $settings->panel_title ?? 'Pterodactyl Panel' }}"
                               oninput="updateTitlePreview()"
                               placeholder="Judul di tab browser">
                    </div>
                    <div class="col-md-4">
                        <label class="pm-mini-label">Update Real Title</label>
                        <button class="pm-btn-sm pm-btn-success w-100 mt-2" onclick="applyTitleToBrowser()">
                            <i class="fas fa-check me-1"></i> Terapkan ke Browser
                        </button>
                    </div>
                </div>
                <small class="pm-help-text mt-2">
                    <i class="fas fa-info-circle me-1"></i>
                    Judul ini akan muncul di <strong>tab browser</strong> dan <strong>history</strong>
                </small>
            </div>
        </div>
    </div>
    
    {{-- ============================================================ --}}
    {{-- EXPORT & APPLY BUTTONS --}}
    {{-- ============================================================ --}}
    <div class="pm-branding-actions animate-in delay-6">
        <div class="pm-header" style="border-radius: 20px; padding: 25px; margin-bottom: 0;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 style="font-weight: 700; margin: 0;">
                        <i class="fas fa-magic me-2" style="color: #A78BFA;"></i>
                        Aksi Branding
                    </h6>
                </div>
                <div class="col-md-6 text-end">
                    <button class="pm-btn-outline me-2" onclick="resetBrandingPreview()">
                        <i class="fas fa-undo me-2"></i> Reset Preview
                    </button>
                    <button class="pm-btn" onclick="applyAllBranding()">
                        <i class="fas fa-check-double me-2"></i> Terapkan Semua
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ============================================================ --}}
{{-- INLINE STYLES --}}
{{-- ============================================================ --}}
<style>
    /* Preview Section */
    .pm-preview-section-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .pm-preview-section-icon {
        width: 45px;
        height: 45px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2em;
        flex-shrink: 0;
    }
    
    .pm-preview-section-title {
        font-weight: 700;
        margin-bottom: 2px;
    }
    
    .pm-preview-section-desc {
        color: var(--text-muted);
        font-size: 0.8em;
        margin-bottom: 0;
    }
    
    .pm-preview-badge {
        background: rgba(67, 233, 123, 0.15);
        color: #43e97b;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.7em;
        font-weight: 700;
        letter-spacing: 1px;
        margin-left: auto;
        animation: pm-dot-pulse 2s infinite;
    }
    
    /* Preview Mode Buttons */
    .pm-preview-mode-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    
    .pm-preview-mode-btn {
        padding: 8px 16px;
        border-radius: 50px;
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        color: var(--text-muted);
        cursor: pointer;
        font-size: 0.8em;
        font-weight: 600;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    
    .pm-preview-mode-btn:hover {
        border-color: var(--glass-border-hover);
        color: white;
    }
    
    .pm-preview-mode-btn.active {
        background: var(--gradient-canva);
        border-color: transparent;
        color: white;
    }
    
    /* Mini Label */
    .pm-mini-label {
        color: var(--text-muted);
        font-size: 0.75em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
        display: block;
    }
    
    .pm-input-sm {
        padding: 10px 16px !important;
        font-size: 0.85em !important;
    }
    
    /* Footer Preview */
    .pm-footer-preview {
        background: #1e293b;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .pm-footer-preview-bar {
        height: 3px;
        background: var(--gradient-canva);
    }
    
    .pm-footer-preview-content {
        padding: 20px 25px;
    }
    
    .pm-footer-preview-brand {
        font-weight: 700;
        color: white;
    }
    
    .pm-footer-preview-year {
        color: rgba(255,255,255,0.5);
        margin-left: 8px;
        font-size: 0.85em;
    }
    
    .pm-footer-preview-powered {
        color: rgba(255,255,255,0.5);
        font-size: 0.85em;
    }
    
    .pm-footer-preview-made {
        color: rgba(255,255,255,0.5);
        font-size: 0.85em;
    }
    
    /* Badge Preview Area */
    .pm-badge-preview-area {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: center;
        padding: 15px;
        background: rgba(255,255,255,0.02);
        border-radius: 15px;
    }
    
    .pm-badge-preview-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .pm-badge-preview-label {
        color: var(--text-muted);
        font-size: 0.75em;
        font-weight: 600;
        min-width: 60px;
    }
    
    /* Banner Preview */
    .pm-banner-preview-wrapper {
        border-radius: 20px;
        overflow: hidden;
    }
    
    .pm-banner-preview-container {
        position: relative;
        padding: 40px;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.5s ease;
    }
    
    .pm-banner-preview-inner {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .pm-banner-preview-title {
        font-weight: 800;
        font-size: 1.8em;
        margin-bottom: 10px;
    }
    
    .pm-banner-preview-message {
        opacity: 0.95;
        font-size: 1em;
        margin-bottom: 20px;
    }
    
    .pm-banner-preview-buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
    }
    
    .pm-banner-preview-btn {
        padding: 10px 24px;
        border-radius: 50px;
        background: white;
        color: #1a1a2e;
        border: none;
        font-weight: 700;
        font-size: 0.85em;
        cursor: default;
    }
    
    .pm-banner-preview-btn.outline {
        background: transparent;
        border: 2px solid rgba(255,255,255,0.5);
        color: white;
    }
    
    .pm-banner-preview-decoration {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }
    
    .pm-banner-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
    }
    
    .pm-banner-circle.circle-1 {
        width: 150px;
        height: 150px;
        top: -50px;
        right: -30px;
    }
    
    .pm-banner-circle.circle-2 {
        width: 80px;
        height: 80px;
        bottom: 20px;
        left: 10%;
    }
    
    .pm-banner-circle.circle-3 {
        width: 50px;
        height: 50px;
        top: 30%;
        right: 20%;
    }
    
    /* Browser Preview */
    .pm-browser-preview {
        background: #2d2d3f;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .pm-browser-bar {
        background: #1e1e2e;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .pm-browser-dots {
        display: flex;
        gap: 6px;
    }
    
    .pm-browser-dots span {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ff5f57;
    }
    
    .pm-browser-dots span:nth-child(2) {
        background: #ffbd2e;
    }
    
    .pm-browser-dots span:nth-child(3) {
        background: #28ca41;
    }
    
    .pm-browser-url {
        background: #1e1e2e;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75em;
        color: rgba(255,255,255,0.6);
        flex: 1;
    }
    
    .pm-browser-url i {
        margin-right: 6px;
        color: #28ca41;
        font-size: 0.7em;
    }
    
    .pm-browser-tab {
        background: #1e1e2e;
        margin: 10px 15px;
        padding: 10px 15px;
        border-radius: 10px 10px 0 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        max-width: 60%;
    }
    
    .pm-browser-tab-icon {
        font-size: 0.9em;
    }
    
    .pm-browser-tab-title {
        font-size: 0.8em;
        color: white;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .pm-browser-tab-close {
        color: rgba(255,255,255,0.4);
        cursor: default;
        font-size: 1em;
    }
    
    /* Preview Settings */
    .pm-preview-settings {
        padding: 15px;
        background: rgba(255,255,255,0.02);
        border-radius: 12px;
        border: 1px solid var(--glass-border);
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
    }
    
    /* Help Text */
    .pm-help-text {
        color: var(--text-muted);
        font-size: 0.75em;
        display: block;
    }
    
    /* Branding Actions */
    .pm-branding-actions .pm-btn,
    .pm-branding-actions .pm-btn-outline {
        font-size: 0.9em;
    }
    
    /* Section Hide/Show */
    .pm-branding-preview-section.hidden {
        display: none;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .pm-badge-preview-area {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .pm-banner-preview-container {
            padding: 25px;
        }
        
        .pm-banner-preview-title {
            font-size: 1.3em;
        }
        
        .pm-footer-preview-content .row {
            flex-direction: column;
            text-align: center !important;
        }
        
        .pm-footer-preview-content .col-md-4 {
            width: 100%;
            text-align: center !important;
            margin-bottom: 5px;
        }
        
        .pm-preview-mode-buttons {
            margin-top: 10px;
        }
        
        .pm-branding-actions .col-md-6 {
            text-align: center !important;
            margin-bottom: 10px;
        }
        
        .pm-branding-actions .text-end {
            text-align: center !important;
        }
    }
    
    @media (max-width: 480px) {
        .pm-preview-mode-btn {
            padding: 6px 10px;
            font-size: 0.7em;
        }
    }
</style>

{{-- ============================================================ --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================ --}}
<script>
    $(document).ready(function() {
        
        // ============================================================
        // PREVIEW MODE SWITCHER
        // ============================================================
        window.switchPreviewMode = function(mode) {
            // Update button states
            $('.pm-preview-mode-btn').removeClass('active');
            $('.pm-preview-mode-btn[data-mode="' + mode + '"]').addClass('active');
            
            // Show/hide sections
            if (mode === 'all') {
                $('#previewSectionFooter, #previewSectionBadge, #previewSectionBanner, #previewSectionTitle').removeClass('hidden').fadeIn(300);
            } else if (mode === 'footer') {
                $('#previewSectionBadge, #previewSectionBanner, #previewSectionTitle').addClass('hidden').hide();
                $('#previewSectionFooter').removeClass('hidden').fadeIn(300);
            } else if (mode === 'badge') {
                $('#previewSectionFooter, #previewSectionBanner, #previewSectionTitle').addClass('hidden').hide();
                $('#previewSectionBadge').removeClass('hidden').fadeIn(300);
            } else if (mode === 'banner') {
                $('#previewSectionFooter, #previewSectionBadge, #previewSectionTitle').addClass('hidden').hide();
                $('#previewSectionBanner').removeClass('hidden').fadeIn(300);
            }
        };
        
        // ============================================================
        // FOOTER PREVIEW UPDATE
        // ============================================================
        window.updateFooterPreview = function() {
            const brandName = $('#inputBrandName').val() || 'ProtectKal';
            const poweredBy = $('#inputPoweredBy').val() || 'KALL XTREME X';
            const madeFor = $('#inputMadeFor').val() || 'Mulia';
            
            $('#previewFooterBrand').text(brandName);
            $('#previewFooterPowered').text(poweredBy);
            $('#previewFooterMade').text(madeFor);
        };
        
        // ============================================================
        // BADGE PREVIEW UPDATE
        // ============================================================
        window.updateBadgePreview = function() {
            const text = $('#inputBadgeText').val() || '🛡️ Protected';
            $('#previewBadgeSmall, #previewBadgeMedium, #previewBadgeLarge').text(text);
        };
        
        window.updateBadgeStyle = function() {
            const style = $('#inputBadgeStyle').val();
            let bgColor;
            
            switch(style) {
                case 'gradient-1': bgColor = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'; break;
                case 'gradient-2': bgColor = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'; break;
                case 'gradient-4': bgColor = 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'; break;
                case 'solid-purple': bgColor = '#8B5CF6'; break;
                case 'solid-pink': bgColor = '#EC4899'; break;
                default: bgColor = 'var(--gradient-canva)';
            }
            
            $('#previewBadgeSmall, #previewBadgeMedium, #previewBadgeLarge').css('background', bgColor);
        };
        
        // ============================================================
        // BANNER PREVIEW UPDATE
        // ============================================================
        window.updateBannerPreview = function() {
            const title = $('#inputBannerTitle').val() || 'Selamat Datang!';
            const message = $('#inputBannerMessage').val() || '';
            
            $('#previewBannerTitle').text(title);
            $('#previewBannerMessage').text(message);
        };
        
        window.toggleBannerPreview = function(show) {
            if (show) {
                $('#bannerPreviewWrapper').slideDown(300);
                $('#showBannerLabel').text('✅ Aktif');
            } else {
                $('#bannerPreviewWrapper').slideUp(300);
                $('#showBannerLabel').text('❌ Nonaktif');
            }
        };
        
        window.updateBannerStyle = function() {
            const style = $('#inputBannerStyle').val();
            let bgColor;
            
            switch(style) {
                case 'gradient-1': bgColor = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'; break;
                case 'gradient-2': bgColor = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'; break;
                case 'gradient-4': bgColor = 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'; break;
                case 'gradient-5': bgColor = 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)'; break;
                case 'solid-dark': bgColor = '#1e293b'; break;
                default: bgColor = 'var(--gradient-canva)';
            }
            
            $('.pm-banner-preview-container').css('background', bgColor);
        };
        
        // ============================================================
        // TITLE PREVIEW UPDATE
        // ============================================================
        window.updateTitlePreview = function() {
            const title = $('#inputPanelTitle').val() || 'Pterodactyl Panel';
            $('#previewTitleBar').text(title);
        };
        
        window.applyTitleToBrowser = function() {
            const title = $('#inputPanelTitle').val() || 'Pterodactyl Panel';
            document.title = title;
            
            Swal.fire({
                icon: 'success',
                title: '✅ Title Updated!',
                text: 'Judul browser berhasil diperbarui ke: ' + title,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#1a1a2e',
                color: '#fff'
            });
        };
        
        // ============================================================
        // RESET PREVIEW
        // ============================================================
        window.resetBrandingPreview = function() {
            // Reset footer
            $('#inputBrandName').val('ProtectKal');
            $('#inputPoweredBy').val('KALL XTREME X');
            $('#inputMadeFor').val('Mulia');
            updateFooterPreview();
            
            // Reset badge
            $('#inputBadgeText').val('🛡️ Protected by ProtectKal');
            $('#inputBadgeStyle').val('gradient-canva');
            updateBadgePreview();
            updateBadgeStyle();
            
            // Reset banner
            $('#inputBannerTitle').val('Selamat Datang!');
            $('#inputBannerMessage').val('Selamat datang di panel hosting kami! Hubungi admin jika ada kendala.');
            $('#inputShowBanner').prop('checked', true);
            $('#inputBannerStyle').val('gradient-canva');
            toggleBannerPreview(true);
            updateBannerPreview();
            updateBannerStyle();
            
            // Reset title
            $('#inputPanelTitle').val('Pterodactyl Panel');
            updateTitlePreview();
            
            Swal.fire({
                icon: 'success',
                title: '✅ Preview Direset!',
                text: 'Semua preview dikembalikan ke default.',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#1a1a2e',
                color: '#fff'
            });
        };
        
        // ============================================================
        // APPLY ALL BRANDING
        // ============================================================
        window.applyAllBranding = function() {
            // Kumpulkan semua nilai
            const brandingData = {
                brand_name: $('#inputBrandName').val(),
                panel_title: $('#inputPanelTitle').val(),
                protection_text: $('#inputBadgeText').val(),
                welcome_title: $('#inputBannerTitle').val(),
                welcome_message: $('#inputBannerMessage').val(),
                show_banner: $('#inputShowBanner').is(':checked') ? 1 : 0,
                _token: '{{ csrf_token() }}'
            };
            
            // Kirim ke server
            $.ajax({
                url: '{{ route("admin.protect-manager.config.save") }}',
                type: 'POST',
                data: brandingData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '✅ Branding Diterapkan!',
                            text: 'Semua pengaturan branding telah disimpan.',
                            timer: 3000,
                            showConfirmButton: false,
                            background: '#1a1a2e',
                            color: '#fff'
                        });
                        
                        // Update real title
                        document.title = brandingData.panel_title || 'Pterodactyl Panel';
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Gagal!',
                        text: xhr.responseJSON?.message || 'Gagal menyimpan branding',
                        background: '#1a1a2e',
                        color: '#fff'
                    });
                }
            });
        };
        
        // ============================================================
        // INITIAL STATE
        // ============================================================
        if (!$('#inputShowBanner').is(':checked')) {
            $('#bannerPreviewWrapper').hide();
            $('#showBannerLabel').text('❌ Nonaktif');
        }
        
        // ============================================================
        // CONSOLE LOG
        // ============================================================
        console.log('🎨 Branding Preview Tab loaded!');
        console.log('💡 Mode preview: All, Footer, Badge, Banner');
        console.log('👑 THE LAST FILE - GRAND FINALE!');
    });
</script>