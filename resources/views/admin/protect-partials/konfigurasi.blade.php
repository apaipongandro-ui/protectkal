{{-- Konfigurasi Tab - Canva Edition --}}

<div class="pm-header" style="border-radius: 25px; padding: 30px; margin-bottom: 0;">
    <h5 style="font-weight: 700; margin-bottom: 25px;">⚙️ Konfigurasi Protect Manager</h5>
    
    <form id="configForm">
        @csrf
        
        <h6 style="color: #A78BFA; margin-bottom: 20px; font-weight: 700;">
            <i class="fas fa-paint-brush me-2"></i> Identitas Brand
        </h6>
        
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Nama Brand</label>
                <input type="text" name="brand_name" class="form-control pm-input" value="{{ $settings->brand_name ?? 'ProtectKal' }}" placeholder="Nama brand">
            </div>
            <div class="col-md-6">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Judul Panel</label>
                <input type="text" name="panel_title" class="form-control pm-input" value="{{ $settings->panel_title ?? 'Pterodactyl Panel' }}" placeholder="Judul di tab browser">
            </div>
            <div class="col-md-6">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Teks Proteksi (Badge)</label>
                <input type="text" name="protection_text" class="form-control pm-input" value="{{ $settings->protection_text ?? '🛡️ Protected by ProtectKal' }}" placeholder="Teks badge">
            </div>
            <div class="col-md-6">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Label Brand</label>
                <input type="text" name="label_brand" class="form-control pm-input" value="{{ $settings->label_brand ?? 'ProtectKal' }}" placeholder="Label brand">
            </div>
        </div>
        
        <hr style="border-color: var(--glass-border);">
        
        <h6 style="color: #A78BFA; margin-bottom: 20px; font-weight: 700;">
            <i class="fab fa-telegram me-2"></i> Integrasi Telegram
        </h6>
        
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Telegram Admin 1</label>
                <input type="text" name="telegram_admin1" class="form-control pm-input" value="{{ $settings->telegram_admin1 ?? '' }}" placeholder="@admin1">
            </div>
            <div class="col-md-6">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Telegram Admin 2</label>
                <input type="text" name="telegram_admin2" class="form-control pm-input" value="{{ $settings->telegram_admin2 ?? '' }}" placeholder="@admin2">
            </div>
            <div class="col-md-6">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Username Bot Telegram</label>
                <input type="text" name="telegram_bot_username" class="form-control pm-input" value="{{ $settings->telegram_bot_username ?? '' }}" placeholder="@botname">
            </div>
        </div>
        
        <hr style="border-color: var(--glass-border);">
        
        <h6 style="color: #A78BFA; margin-bottom: 20px; font-weight: 700;">
            <i class="fas fa-flag me-2"></i> Welcome Banner
        </h6>
        
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Judul Banner</label>
                <input type="text" name="welcome_title" class="form-control pm-input" value="{{ $settings->welcome_title ?? 'Selamat Datang!' }}" placeholder="Judul welcome banner">
            </div>
            <div class="col-md-6">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Tampilkan Banner</label>
                <div class="form-check form-switch pm-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="show_banner" value="1" {{ $settings->show_banner ? 'checked' : '' }}>
                    <label class="form-check-label" style="color: var(--text-secondary);">{{ $settings->show_banner ? 'Aktif' : 'Nonaktif' }}</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label" style="color: var(--text-secondary); font-size: 0.85em; font-weight: 600;">Pesan Banner</label>
                <textarea name="welcome_message" class="form-control pm-input" rows="4" placeholder="Pesan selamat datang...">{{ $settings->welcome_message ?? '' }}</textarea>
            </div>
        </div>
        
        <hr style="border-color: var(--glass-border);">
        
        <h6 style="color: #A78BFA; margin-bottom: 20px; font-weight: 700;">
            <i class="fas fa-ban me-2"></i> Custom Pesan Akses Ditolak
        </h6>
        
        <div class="mb-4">
            <textarea name="abort_message" class="form-control pm-input" rows="3" placeholder="Pesan saat admin lain mencoba akses...">{{ $settings->abort_message ?? '' }}</textarea>
        </div>
        
        <div class="text-end">
            <button type="button" id="saveConfigBtn" class="pm-btn">
                <i class="fas fa-save me-2"></i> Simpan Konfigurasi
            </button>
        </div>
    </form>
</div>

<script>
    $('#saveConfigBtn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var originalHtml = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        btn.prop('disabled', true);
        
        $.ajax({
            url: '{{ route("admin.protect-manager.config.save") }}',
            type: 'POST',
            data: $('#configForm').serialize(),
            success: function(response) {
                if (response.success) {
                    const Toast = Swal.mixin({
                        toast: true, position: 'top-end', showConfirmButton: false,
                        timer: 2500, timerProgressBar: true,
                        background: '#1a1a2e', color: '#fff'
                    });
                    Toast.fire({ icon: 'success', title: '✅ Konfigurasi Tersimpan!' });
                }
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal!', text: xhr.responseJSON?.message || 'Terjadi kesalahan', background: '#1a1a2e', color: '#fff' });
            },
            complete: function() {
                btn.html(originalHtml);
                btn.prop('disabled', false);
            }
        });
    });
</script>