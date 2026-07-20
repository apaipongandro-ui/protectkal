{{-- Konfigurasi Tab - Protect Manager --}}

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-cogs"></i> Konfigurasi Protect Manager</h5>
    </div>
    <div class="card-body">
        <form id="configForm">
            @csrf
            
            <h6 class="text-primary mb-3">
                <i class="fas fa-paint-brush"></i> Identitas Brand (Branding)
            </h6>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Brand</label>
                        <input type="text" name="brand_name" class="form-control" 
                               value="{{ $settings->brand_name ?? 'ProtectKal' }}"
                               placeholder="Masukkan nama brand">
                        <small class="text-muted">Nama brand yang tampil di footer panel</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Judul Panel (Title Bar)</label>
                        <input type="text" name="panel_title" class="form-control" 
                               value="{{ $settings->panel_title ?? 'Pterodactyl Panel' }}"
                               placeholder="Judul di tab browser">
                        <small class="text-muted">Tag &lt;title&gt; pada browser</small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Teks Proteksi (Badge)</label>
                        <input type="text" name="protection_text" class="form-control" 
                               value="{{ $settings->protection_text ?? '🛡️ Protected by ProtectKal' }}"
                               placeholder="Teks badge proteksi">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Label Brand</label>
                        <input type="text" name="label_brand" class="form-control" 
                               value="{{ $settings->label_brand ?? 'ProtectKal' }}"
                               placeholder="Label brand">
                    </div>
                </div>
            </div>
            
            <hr>
            
            <h6 class="text-primary mb-3">
                <i class="fas fa-paper-plane"></i> Kontak & Bot Integrasi (Telegram)
            </h6>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telegram Admin 1 (@username)</label>
                        <input type="text" name="telegram_admin1" class="form-control" 
                               value="{{ $settings->telegram_admin1 ?? '' }}"
                               placeholder="@admin1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telegram Admin 2 (@username)</label>
                        <input type="text" name="telegram_admin2" class="form-control" 
                               value="{{ $settings->telegram_admin2 ?? '' }}"
                               placeholder="@admin2">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username Bot Telegram</label>
                        <input type="text" name="telegram_bot_username" class="form-control" 
                               value="{{ $settings->telegram_bot_username ?? '' }}"
                               placeholder="@BotName">
                    </div>
                </div>
            </div>
            
            <hr>
            
            <h6 class="text-primary mb-3">
                <i class="fas fa-flag"></i> Welcome Banner (Client Dashboard)
            </h6>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Judul Banner</label>
                        <input type="text" name="welcome_title" class="form-control" 
                               value="{{ $settings->welcome_title ?? 'Selamat Datang!' }}"
                               placeholder="Judul welcome banner">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tampilkan Banner</label>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" 
                                   id="show_banner" name="show_banner" 
                                   {{ $settings->show_banner ? 'checked' : '' }}>
                            <label class="custom-control-label" for="show_banner">
                                {{ $settings->show_banner ? 'Aktif' : 'Nonaktif' }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Pesan Banner</label>
                <textarea name="welcome_message" class="form-control" rows="4" 
                          placeholder="Pesan selamat datang untuk client...">{{ $settings->welcome_message ?? '' }}</textarea>
                <small class="text-muted">Mendukung @username Telegram</small>
            </div>
            
            <hr>
            
            <h6 class="text-primary mb-3">
                <i class="fas fa-ban"></i> Custom Pesan Akses Ditolak
            </h6>
            
            <div class="form-group">
                <label>Pesan Abort/Akses Ditolak</label>
                <textarea name="abort_message" class="form-control" rows="3" 
                          placeholder="Pesan yang muncul saat admin lain mencoba akses menu terlarang...">{{ $settings->abort_message ?? '' }}</textarea>
                <small class="text-muted">Kosongkan untuk menggunakan pesan default</small>
            </div>
            
            <div class="text-right">
                <button type="button" id="saveConfig" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Simpan Konfigurasi
                </button>
            </div>
            
        </form>
    </div>
</div>

<script>
    $('#show_banner').on('change', function() {
        var label = $(this).siblings('label');
        label.text($(this).is(':checked') ? 'Aktif' : 'Nonaktif');
    });
    
    $('#saveConfig').on('click', function(e) {
        e.preventDefault();
        
        var btn = $(this);
        var originalText = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        btn.prop('disabled', true);
        
        var formData = $('#configForm').serialize();
        
        $.ajax({
            url: '{{ route("admin.protect-manager.config.save") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Konfigurasi Tersimpan!',
                        text: 'Semua pengaturan telah diperbarui',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Gagal menyimpan konfigurasi'
                });
            },
            complete: function() {
                btn.html(originalText);
                btn.prop('disabled', false);
            }
        });
    });
</script>
