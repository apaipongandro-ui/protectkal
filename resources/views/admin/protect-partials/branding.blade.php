{{-- Branding Preview - Canva Edition --}}

<div class="pm-header" style="border-radius: 25px; padding: 30px; margin-bottom: 0;">
    <h5 style="font-weight: 700; margin-bottom: 25px;">🎨 Preview Branding</h5>
    
    <p style="color: var(--text-secondary); font-weight: 600; margin-bottom: 10px;">Footer Panel:</p>
    <div style="background: var(--bg-secondary); border-radius: 20px; padding: 25px; text-align: center; margin-bottom: 30px; border: 1px solid var(--glass-border);">
        <span style="color: var(--text-secondary);">
            <span id="previewBrand">{{ $settings->brand_name ?? 'ProtectKal' }}</span> © {{ date('Y') }} | 
            Powered by <strong class="pm-gradient-text">KALL XTREME X</strong>
        </span>
    </div>
    
    <p style="color: var(--text-secondary); font-weight: 600; margin-bottom: 10px;">Badge Proteksi:</p>
    <div style="text-align: center; margin-bottom: 30px;">
        <span class="pm-badge" style="background: var(--gradient-canva); font-size: 1em; padding: 14px 28px;" id="previewBadge">
            {{ $settings->protection_text ?? '🛡️ Protected by ProtectKal' }}
        </span>
    </div>
    
    <p style="color: var(--text-secondary); font-weight: 600; margin-bottom: 10px;">Welcome Banner:</p>
    <div style="background: var(--gradient-canva); border-radius: 25px; padding: 30px; text-align: center; box-shadow: 0 15px 35px rgba(139, 92, 246, 0.3);">
        <h4 style="font-weight: 800; margin-bottom: 10px;" id="previewBannerTitle">
            {{ $settings->welcome_title ?? 'Selamat Datang!' }}
        </h4>
        <p class="mb-0" style="opacity: 0.95; font-size: 1.05em;" id="previewBannerMessage">
            {{ $settings->welcome_message ?? 'Selamat datang di panel hosting kami!' }}
        </p>
    </div>
</div>