{{-- 
    Branding Configuration Partial
    Protect Manager - KALL XTREME X
    Lokasi: resources/views/admin/protect-partials/branding.blade.php
--}}

<div class="card mb-4">
    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h5 class="mb-0">
            <i class="fas fa-paint-brush"></i> Branding & Identitas Panel
        </h5>
    </div>
    <div class="card-body">
        
        {{-- Preview Section --}}
        <div class="alert alert-info">
            <h6><i class="fas fa-eye"></i> Preview Langsung:</h6>
            <div id="brandingPreview" style="background: #f5f5f5; padding: 20px; border-radius: 8px; margin-top: 10px;">
                {{-- Footer Preview --}}
                <div style="background: #1e293b; color: white; padding: 15px; border-radius: 8px; text-align: center;">
                    <small>
                        <span id="previewBrandName">{{ $settings->brand_name ?? 'ProtectKal' }}</span> 
                        © {{ date('Y') }} | Powered by 
                        <strong style="color: #764ba2;" id="previewPoweredBy">KALL XTREME X</strong>
                    </small>
                </div>
                
                {{-- Title Bar Preview --}}
                <div style="background: #334155; color: white; padding: 10px; border-radius: 8px; margin-top: 10px; text-align: center;">
                    <small>🔖 Title Bar: <strong id="previewTitle">{{ $settings->panel_title ?? 'Pterodactyl Panel - Protected' }}</strong></small>
                </div>
                
                {{-- Badge Preview --}}
                <div style="text-align: center; margin-top: 10px;">
                    <span class="badge" style="background: #764ba2; font-size: 14px; padding: 10px;" id="previewBadge">
                        {{ $settings->protection_text ?? '🛡️ Protected by ProtectKal' }}
                    </span>
                </div>
                
                {{-- Welcome Banner Preview --}}
                @if($settings->show_banner)
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px; border-radius: 8px; margin-top: 10px;">
                    <strong id="previewBannerTitle">{{ $settings->welcome_title ?? 'Selamat Datang!' }}</strong>
                    <p class="mb-0" id="previewBannerMessage" style="opacity: 0.9;">
                        {{ $settings->welcome_message ?? 'Selamat datang di panel hosting kami!' }}
                    </p>
                </div>
                @endif
            </div>
        </div>
        
        <hr>
        
        {{-- Form Branding --}}
        <form id="brandingForm">
            @csrf
            
            <div class="row">
                {{-- Nama Brand --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="brand_name">
                            <i class="fas fa-tag"></i> Nama Brand
                        </label>
                        <input type="text" 
                               name="brand_name" 
                               id="brand_name" 
                               class="form-control form-control-lg" 
                               value="{{ $settings->brand_name ?? 'ProtectKal' }}"
                               placeholder="Masukkan nama brand Anda"
                               onkeyup="updatePreview()">
                        <small class="text-muted">
                            Nama brand yang akan tampil di <strong>footer panel</strong> dan <strong>credit</strong>
                        </small>
                    </div>
                </div>
                
                {{-- Judul Panel --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="panel_title">
                            <i class="fas fa-window-maximize"></i> Judul Panel (Title Bar)
                        </label>
                        <input type="text" 
                               name="panel_title" 
                               id="panel_title" 
                               class="form-control form-control-lg" 
                               value="{{ $settings->panel_title ?? 'Pterodactyl Panel' }}"
                               placeholder="Judul di tab browser"
                               onkeyup="updatePreview()">
                        <small class="text-muted">
                            Teks yang muncul di <strong>tab browser</strong> (tag &lt;title&gt;)
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                {{-- Teks Proteksi --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="protection_text">
                            <i class="fas fa-shield-alt"></i> Teks Proteksi (Badge)
                        </label>
                        <input type="text" 
                               name="protection_text" 
                               id="protection_text" 
                               class="form-control" 
                               value="{{ $settings->protection_text ?? '🛡️ Protected by ProtectKal' }}"
                               placeholder="Teks badge proteksi"
                               onkeyup="updatePreview()">
                        <small class="text-muted">
                            Teks yang muncul sebagai <strong>badge proteksi</strong> di panel
                        </small>
                    </div>
                </div>
                
                {{-- Label Brand --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="label_brand">
                            <i class="fas fa-label"></i> Label Brand
                        </label>
                        <input type="text" 
                               name="label_brand" 
                               id="label_brand" 
                               class="form-control" 
                               value="{{ $settings->label_brand ?? 'ProtectKal' }}"
                               placeholder="Label brand"
                               onkeyup="updatePreview()">
                        <small class="text-muted">
                            Label brand untuk <strong>identifikasi</strong> di berbagai tempat
                        </small>
                    </div>
                </div>
            </div>
            
            <hr>
            
            {{-- Custom Abort Message --}}
            <div class="form-group">
                <label for="abort_message">
                    <i class="fas fa-ban"></i> Custom Pesan Akses Ditolak
                </label>
                <textarea name="abort_message" 
                          id="abort_message" 
                          class="form-control" 
                          rows="4" 
                          placeholder="Pesan yang muncul saat admin lain mencoba akses menu terlarang...">{{ $settings->abort_message ?? '' }}</textarea>
                <small class="text-muted">
                    Kosongkan untuk menggunakan pesan default. Mendukung <strong>HTML</strong> dan <strong>emoji</strong>.
                </small>
                
                {{-- Preview Abort Message --}}
                <div class="mt-3">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="previewAbortMessage()">
                        <i class="fas fa-eye"></i> Preview Pesan Error
                    </button>
                </div>
            </div>
            
            <hr>
            
            {{-- Telegram Integration --}}
            <h6 class="text-primary mb-3">
                <i class="fab fa-telegram"></i> Integrasi Telegram
            </h6>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telegram_admin1">
                            <i class="fab fa-telegram"></i> Telegram Admin 1
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" 
                                   name="telegram_admin1" 
                                   id="telegram_admin1" 
                                   class="form-control" 
                                   value="{{ $settings->telegram_admin1 ?? '' }}"
                                   placeholder="username_admin1">
                        </div>
                        <small class="text-muted">Username Telegram admin utama (tanpa @)</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telegram_admin2">
                            <i class="fab fa-telegram"></i> Telegram Admin 2
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" 
                                   name="telegram_admin2" 
                                   id="telegram_admin2" 
                                   class="form-control" 
                                   value="{{ $settings->telegram_admin2 ?? '' }}"
                                   placeholder="username_admin2">
                        </div>
                        <small class="text-muted">Username Telegram admin cadangan (opsional)</small>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="telegram_bot_username">
                    <i class="fas fa-robot"></i> Username Bot Telegram
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">@</span>
                    </div>
                    <input type="text" 
                           name="telegram_bot_username" 
                           id="telegram_bot_username" 
                           class="form-control" 
                           value="{{ $settings->telegram_bot_username ?? '' }}"
                           placeholder="nama_bot_anda">
                </div>
                <small class="text-muted">Username bot Telegram untuk notifikasi otomatis (opsional)</small>
            </div>
            
            <hr>
            
            {{-- Welcome Banner Settings --}}
            <h6 class="text-primary mb-3">
                <i class="fas fa-flag"></i> Welcome Banner (Client Dashboard)
            </h6>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="welcome_title">
                            <i class="fas fa-heading"></i> Judul Banner
                        </label>
                        <input type="text" 
                               name="welcome_title" 
                               id="welcome_title" 
                               class="form-control" 
                               value="{{ $settings->welcome_title ?? 'Selamat Datang!' }}"
                               placeholder="Judul welcome banner"
                               onkeyup="updatePreview()">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="show_banner">
                            <i class="fas fa-toggle-on"></i> Tampilkan Banner
                        </label>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" 
                                   class="custom-control-input" 
                                   id="show_banner" 
                                   name="show_banner" 
                                   value="1"
                                   {{ $settings->show_banner ? 'checked' : '' }}
                                   onchange="updatePreview()">
                            <label class="custom-control-label" for="show_banner">
                                <span id="showBannerLabel">{{ $settings->show_banner ? '✅ Aktif' : '❌ Nonaktif' }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="welcome_message">
                    <i class="fas fa-comment-dots"></i> Pesan Banner
                </label>
                <textarea name="welcome_message" 
                          id="welcome_message" 
                          class="form-control" 
                          rows="4" 
                          placeholder="Pesan selamat datang untuk client...&#10;&#10;Tips: Gunakan @username untuk mention Telegram"
                          onkeyup="updatePreview()">{{ $settings->welcome_message ?? '' }}</textarea>
                <small class="text-muted">
                    Mendukung <strong>@username Telegram</strong> dan <strong>HTML basic</strong>
                </small>
            </div>
            
            {{-- Tombol Simpan --}}
            <div class="text-right mt-4">
                <button type="button" id="saveBranding" class="btn btn-lg" 
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="fas fa-save"></i> Simpan Pengaturan Branding
                </button>
            </div>
            
        </form>
        
    </div>
</div>

{{-- JavaScript untuk Live Preview dan Save --}}
<script>
    // Update live preview
    function updatePreview() {
        // Brand name
        var brandName = $('#brand_name').val() || 'ProtectKal';
        $('#previewBrandName').text(brandName);
        
        // Panel title
        var panelTitle = $('#panel_title').val() || 'Pterodactyl Panel';
        $('#previewTitle').text(panelTitle);
        document.title = panelTitle; // Update real title
        
        // Protection text
        var protectionText = $('#protection_text').val() || '🛡️ Protected by ProtectKal';
        $('#previewBadge').text(protectionText);
        
        // Welcome banner
        var welcomeTitle = $('#welcome_title').val() || 'Selamat Datang!';
        var welcomeMessage = $('#welcome_message').val() || '';
        $('#previewBannerTitle').text(welcomeTitle);
        $('#previewBannerMessage').text(welcomeMessage);
        
        // Show/hide banner preview
        if ($('#show_banner').is(':checked')) {
            $('#previewBannerTitle').parent().show();
        } else {
            $('#previewBannerTitle').parent().hide();
        }
    }
    
    // Toggle show banner label
    $('#show_banner').on('change', function() {
        if ($(this).is(':checked')) {
            $('#showBannerLabel').text('✅ Aktif');
        } else {
            $('#showBannerLabel').text('❌ Nonaktif');
        }
        updatePreview();
    });
    
    // Preview abort message
    function previewAbortMessage() {
        var message = $('#abort_message').val() || '🛡️ Akses ditolak oleh ProtectKal! Hubungi Root Admin.';
        
        Swal.fire({
            icon: 'error',
            title: 'Preview Pesan Akses Ditolak',
            html: '<div style="padding: 20px; background: #fff3f3; border-radius: 8px;">' + message + '</div>',
            confirmButtonText: 'Tutup'
        });
    }
    
    // Save branding settings
    $('#saveBranding').on('click', function(e) {
        e.preventDefault();
        
        var btn = $(this);
        var originalHtml = btn.html();
        
        // Loading state
        btn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        btn.prop('disabled', true);
        
        // Collect form data
        var formData = {
            _token: '{{ csrf_token() }}',
            brand_name: $('#brand_name').val(),
            panel_title: $('#panel_title').val(),
            protection_text: $('#protection_text').val(),
            label_brand: $('#label_brand').val(),
            abort_message: $('#abort_message').val(),
            telegram_admin1: $('#telegram_admin1').val(),
            telegram_admin2: $('#telegram_admin2').val(),
            telegram_bot_username: $('#telegram_bot_username').val(),
            welcome_title: $('#welcome_title').val(),
            welcome_message: $('#welcome_message').val(),
            show_banner: $('#show_banner').is(':checked') ? 1 : 0
        };
        
        // Send AJAX
        $.ajax({
            url: '{{ route("admin.protect-manager.config.save") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Branding Tersimpan!',
                        text: 'Semua pengaturan branding telah diperbarui',
                        timer: 2500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    
                    // Update title bar
                    document.title = $('#panel_title').val();
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan!',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan',
                });
            },
            complete: function() {
                btn.html(originalHtml);
                btn.prop('disabled', false);
            }
        });
    });
    
    // Initialize preview on page load
    $(document).ready(function() {
        updatePreview();
    });
</script>

<style>
    /* Styling tambahan untuk branding partial */
    #brandingPreview {
        transition: all 0.3s ease;
    }
    
    #brandingPreview:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .input-group-text {
        background: #f8f9fa;
        font-weight: bold;
    }
    
    #saveBranding {
        transition: all 0.3s ease;
    }
    
    #saveBranding:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }
</style>
