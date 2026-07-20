{{-- 
╔══════════════════════════════════════════════════════════════╗
║     🛡️ PROTECT MANAGER v2.0 - CANVA EDITION                ║
║     KALL XTREME X untuk MULIA                              ║
║     File: resources/views/admin/protect-manager.blade.php  ║
╚══════════════════════════════════════════════════════════════╝
--}}

@extends('layouts.admin')

@section('title', $settings->panel_title ?? '🛡️ Protect Manager v2.0')

@push('styles')
    <link rel="stylesheet" href="{{ asset('resources/scripts/protect-manager.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Override panel background untuk dark mode */
        body {
            background: #0f0f1a !important;
        }
        .content-wrapper {
            background: transparent !important;
        }
        .gap-3 {
            gap: 1rem;
        }
        .text-end {
            text-align: right;
        }
    </style>
@endpush

@section('content')
<div class="protect-manager-v2">
    
    {{-- ============================================================ --}}
    {{-- ANIMATED BACKGROUND ORBS --}}
    {{-- ============================================================ --}}
    <div class="pm-bg-animation">
        <div class="pm-orb pm-orb-1"></div>
        <div class="pm-orb pm-orb-2"></div>
        <div class="pm-orb pm-orb-3"></div>
        <div class="pm-orb pm-orb-4"></div>
    </div>

    {{-- ============================================================ --}}
    {{-- HEADER SECTION --}}
    {{-- ============================================================ --}}
    <div class="pm-header animate-in">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="pm-logo-icon">
                        <i class="fas fa-shield-haltered"></i>
                    </div>
                    <div>
                        <h1 class="pm-gradient-text mb-0">Protect Manager</h1>
                        <span class="pm-version-badge">v2.0 • Canva Edition</span>
                    </div>
                </div>
                <p class="pm-subtitle mb-0 mt-2">
                    Dikelola oleh <strong>{{ Auth::user()->name }}</strong> 
                    <span class="pm-admin-badge">ID: {{ Auth::id() }}</span>
                    @if(Auth::id() === 1)
                        <span class="pm-root-badge">👑 Root Admin</span>
                    @endif
                </p>
            </div>
            <div class="col-md-5 text-end">
                <div class="pm-status-container">
                    <span class="pm-status-badge" id="statusBadge">
                        <span class="pm-status-dot"></span>
                        <span id="statusText">⚡ <span id="activeCount">{{ $activeProtects ?? 0 }}</span>/14 Aktif</span>
                    </span>
                    <div class="pm-status-bar mt-2">
                        <div class="pm-status-fill" id="statusFill" style="width: {{ (($activeProtects ?? 0) / 14) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- STATS CARDS --}}
    {{-- ============================================================ --}}
    <div class="pm-stats-grid">
        <div class="pm-stat-card animate-in delay-1">
            <div class="pm-stat-icon-wrapper" style="background: rgba(67, 233, 123, 0.15);">
                <div class="pm-stat-icon" style="color: #43e97b;">✅</div>
            </div>
            <div class="pm-stat-value" id="activeProtects">{{ $activeProtects ?? 0 }}</div>
            <div class="pm-stat-label">Proteksi Aktif</div>
            <div class="pm-stat-trend up">● Aktif</div>
        </div>
        
        <div class="pm-stat-card animate-in delay-2">
            <div class="pm-stat-icon-wrapper" style="background: rgba(244, 63, 94, 0.15);">
                <div class="pm-stat-icon" style="color: #F43F5E;">⛔</div>
            </div>
            <div class="pm-stat-value" id="inactiveProtects">{{ $inactiveProtects ?? 14 }}</div>
            <div class="pm-stat-label">Proteksi Nonaktif</div>
            <div class="pm-stat-trend down">● Nonaktif</div>
        </div>
        
        <div class="pm-stat-card animate-in delay-3">
            <div class="pm-stat-icon-wrapper" style="background: rgba(69, 183, 209, 0.15);">
                <div class="pm-stat-icon" style="color: #45B7D1;">👤</div>
            </div>
            <div class="pm-stat-value">ID: {{ Auth::id() }}</div>
            <div class="pm-stat-label">Admin ID</div>
            <div class="pm-stat-trend">{{ Auth::user()->name }}</div>
        </div>
        
        <div class="pm-stat-card animate-in delay-4">
            <div class="pm-stat-icon-wrapper" style="background: rgba(139, 92, 246, 0.15);">
                <div class="pm-stat-icon" style="color: #8B5CF6;">👑</div>
            </div>
            <div class="pm-stat-value">{{ Auth::id() == 1 ? 'Root' : 'Sub' }}</div>
            <div class="pm-stat-label">Level Admin</div>
            <div class="pm-stat-trend">{{ Auth::id() == 1 ? 'Full Access' : 'Limited' }}</div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TABS NAVIGATION --}}
    {{-- ============================================================ --}}
    <div class="pm-tabs">
        <div class="pm-tab active" data-tab="protections">
            <i class="fas fa-shield-alt"></i> 14 Proteksi
            <span class="pm-tab-count" id="tabActiveCount">{{ $activeProtects ?? 0 }}</span>
        </div>
        <div class="pm-tab" data-tab="konfigurasi">
            <i class="fas fa-cogs"></i> Konfigurasi
        </div>
        <div class="pm-tab" data-tab="massal">
            <i class="fas fa-cubes"></i> Akses Massal
        </div>
        <div class="pm-tab" data-tab="branding">
            <i class="fas fa-palette"></i> Branding
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB CONTENT --}}
    {{-- ============================================================ --}}
    <div id="pmTabContent">
        
        {{-- ============================================================ --}}
        {{-- TAB 1: 14 PROTEKSI --}}
        {{-- ============================================================ --}}
        <div id="tab-protections">
            
            {{-- Search & Filter --}}
            <div class="pm-filter-bar mb-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="pm-search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchProtect" class="pm-search-input" placeholder="Cari proteksi...">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="pm-btn-sm pm-btn-success me-2" onclick="ProtectManager.bulkInstall()" {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                            <i class="fas fa-check-double"></i> Aktifkan Semua
                        </button>
                        <button class="pm-btn-sm pm-btn-danger" onclick="ProtectManager.bulkUninstall()" {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                            <i class="fas fa-times-circle"></i> Nonaktifkan Semua
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Protect Cards Grid --}}
            <div class="pm-protect-grid" id="protectCards">
                @php
                $protectsList = [
                    [
                        'id' => 'protect1', 
                        'icon' => '🗑️', 
                        'name' => 'Anti Delete Server', 
                        'desc' => 'Mencegah penghapusan server oleh admin/sub-admin lain selain Root Admin (ID 1).',
                        'category' => 'Server'
                    ],
                    [
                        'id' => 'protect2', 
                        'icon' => '👤', 
                        'name' => 'Anti Hapus/Ubah User', 
                        'desc' => 'Melindungi data user dari tindakan penghapusan maupun modifikasi oleh admin lain.',
                        'category' => 'User'
                    ],
                    [
                        'id' => 'protect3', 
                        'icon' => '📍', 
                        'name' => 'Anti Akses Location', 
                        'desc' => 'Memblokir akses menu Location di admin panel untuk semua admin selain Root Admin.',
                        'category' => 'Panel'
                    ],
                    [
                        'id' => 'protect4', 
                        'icon' => '🖥️', 
                        'name' => 'Anti Akses Nodes', 
                        'desc' => 'Memblokir akses menu Nodes di admin panel untuk admin selain Root Admin.',
                        'category' => 'Panel'
                    ],
                    [
                        'id' => 'protect5', 
                        'icon' => '🎨', 
                        'name' => 'Nests + Branding + Welcome Banner', 
                        'desc' => 'Sembunyikan Nests, tambah branding footer & welcome banner di dashboard client.',
                        'category' => 'Branding'
                    ],
                    [
                        'id' => 'protect6', 
                        'icon' => '⚙️', 
                        'name' => 'Anti Akses Settings', 
                        'desc' => 'Memblokir akses menu Settings (Pengaturan Utama Panel) untuk non-Root Admin.',
                        'category' => 'Panel'
                    ],
                    [
                        'id' => 'protect7', 
                        'icon' => '📁', 
                        'name' => 'Anti Akses Server File', 
                        'desc' => 'Proteksi file controller server dari akses tidak sah atau coba-coba mengintip file.',
                        'category' => 'Server'
                    ],
                    [
                        'id' => 'protect8', 
                        'icon' => '🎮', 
                        'name' => 'Anti Akses Server Controller', 
                        'desc' => 'Proteksi server controller utama agar admin lain tidak bisa kontrol server user lain.',
                        'category' => 'Server'
                    ],
                    [
                        'id' => 'protect9', 
                        'icon' => '🔄', 
                        'name' => 'Anti Modifikasi Server', 
                        'desc' => 'Mencegah perubahan detail server (owner, resource, dll) oleh admin lain.',
                        'category' => 'Server'
                    ],
                    [
                        'id' => 'protect10', 
                        'icon' => '🔗', 
                        'name' => 'Anti Tautan Server v1', 
                        'desc' => 'Mencegah perubahan tautan/link server di admin panel.',
                        'category' => 'Network'
                    ],
                    [
                        'id' => 'protect11', 
                        'icon' => '🔒', 
                        'name' => 'Anti Tautan Server v2', 
                        'desc' => 'Versi lanjutan proteksi tautan server dengan pengamanan link/URL lebih ketat.',
                        'category' => 'Network'
                    ],
                    [
                        'id' => 'protect12', 
                        'icon' => '🛡️', 
                        'name' => 'Konsolidasi Proteksi', 
                        'desc' => 'Gabungan proteksi menyeluruh: Nodes, Client API, App API, API Key, Locations.',
                        'category' => 'API'
                    ],
                    [
                        'id' => 'protect13', 
                        'icon' => '🔑', 
                        'name' => 'Proteksi Application API', 
                        'desc' => 'Sembunyikan menu Application API & blokir akses controller-nya.',
                        'category' => 'API'
                    ],
                    [
                        'id' => 'protect14', 
                        'icon' => '👑', 
                        'name' => 'Anti Create/Delete Admin', 
                        'desc' => 'Mengunci hak akses pembuatan & penghapusan admin. Blokir API, bot, panel.js.',
                        'category' => 'Admin'
                    ],
                ];
                @endphp

                @foreach($protectsList as $index => $protect)
                <div class="pm-protect-card animate-in delay-{{ ($index % 4) + 1 }} {{ $settings->{$protect['id']} ? 'active-protect' : '' }}" 
                     id="card-{{ $protect['id'] }}"
                     data-category="{{ $protect['category'] }}">
                    <div class="pm-protect-card-inner">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="pm-protect-icon-wrapper {{ $settings->{$protect['id']} ? 'active' : '' }}">
                                    <div class="pm-protect-icon">{{ $protect['icon'] }}</div>
                                </div>
                                <div class="pm-protect-info">
                                    <div class="pm-protect-name">
                                        {{ $protect['name'] }}
                                        <span class="pm-category-badge">{{ $protect['category'] }}</span>
                                    </div>
                                    <div class="pm-protect-desc">{{ $protect['desc'] }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="pm-badge pm-badge-status" style="background: {{ $settings->{$protect['id']} ? 'var(--gradient-4)' : 'rgba(255,255,255,0.1)' }}">
                                    <span class="pm-badge-dot {{ $settings->{$protect['id']} ? 'active' : '' }}"></span>
                                    {{ $settings->{$protect['id']} ? 'AKTIF' : 'NONAKTIF' }}
                                </span>
                                <div class="form-check form-switch mb-0 pm-switch">
                                    <input class="form-check-input toggle-protect" type="checkbox" 
                                           id="{{ $protect['id'] }}" 
                                           name="{{ $protect['id'] }}" 
                                           {{ $settings->{$protect['id']} ? 'checked' : '' }}
                                           {{ Auth::id() !== 1 ? 'disabled' : '' }}
                                           data-name="{{ $protect['name'] }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- No Results --}}
            <div id="noResults" class="pm-no-results" style="display: none;">
                <div class="pm-no-results-icon">🔍</div>
                <h5>Tidak ada proteksi ditemukan</h5>
                <p>Coba kata kunci lain</p>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TAB 2: KONFIGURASI --}}
        {{-- ============================================================ --}}
        <div id="tab-konfigurasi" style="display: none;">
            @include('admin.protect-partials.konfigurasi', ['settings' => $settings])
        </div>

        {{-- ============================================================ --}}
        {{-- TAB 3: AKSES MASSAL --}}
        {{-- ============================================================ --}}
        <div id="tab-massal" style="display: none;">
            @include('admin.protect-partials.massal', ['settings' => $settings, 'activeProtects' => $activeProtects ?? 0, 'inactiveProtects' => $inactiveProtects ?? 14])
        </div>

        {{-- ============================================================ --}}
        {{-- TAB 4: BRANDING --}}
        {{-- ============================================================ --}}
        <div id="tab-branding" style="display: none;">
            @include('admin.protect-partials.branding', ['settings' => $settings])
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================================ --}}
    <div class="pm-footer">
        <div class="row align-items-center">
            <div class="col-md-4 text-md-start text-center">
                <span class="pm-footer-brand" id="footerBrandName">{{ $settings->brand_name ?? 'ProtectKal' }}</span>
                <span class="pm-footer-copy">© {{ date('Y') }}</span>
            </div>
            <div class="col-md-4 text-center">
                <span class="pm-footer-powered">
                    Powered by <strong class="pm-gradient-text">KALL XTREME X</strong>
                </span>
            </div>
            <div class="col-md-4 text-md-end text-center">
                <span class="pm-footer-made">
                    Dibuat untuk <strong>Mulia</strong> 👑
                </span>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TOAST CONTAINER --}}
    {{-- ============================================================ --}}
    <div class="pm-toast-container" id="toastContainer"></div>

</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Protect Manager JS --}}
<script src="{{ asset('resources/scripts/protect-manager.js') }}"></script>

<script>
    $(document).ready(function() {
        
        // CSRF Token
        $.ajaxSetup({
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            }
        });

        // ============================================================
        // TOGGLE PROTECTION
        // ============================================================
        $('.toggle-protect').on('change', function() {
            var protect = $(this).attr('name');
            var status = $(this).is(':checked') ? 1 : 0;
            var protectName = $(this).data('name');
            var card = $('#card-' + protect);
            var switchEl = $(this);
            
            // Disable & loading
            switchEl.prop('disabled', true);
            card.addClass('pm-loading');
            
            $.ajax({
                url: '{{ route("admin.protect-manager.toggle") }}',
                type: 'POST',
                data: { 
                    protect: protect, 
                    status: status 
                },
                success: function(response) {
                    if (response.success) {
                        // Update card UI
                        if (status) {
                            card.addClass('active-protect');
                            card.find('.pm-protect-icon-wrapper').addClass('active');
                            card.find('.pm-badge-status')
                                .css('background', 'var(--gradient-4)')
                                .html('<span class="pm-badge-dot active"></span> AKTIF');
                        } else {
                            card.removeClass('active-protect');
                            card.find('.pm-protect-icon-wrapper').removeClass('active');
                            card.find('.pm-badge-status')
                                .css('background', 'rgba(255,255,255,0.1)')
                                .html('<span class="pm-badge-dot"></span> NONAKTIF');
                        }
                        
                        // Update stats
                        updateStats();
                        
                        // Show toast
                        showToast('success', '✅ ' + protectName + ' berhasil ' + (status ? 'diaktifkan' : 'dinonaktifkan') + '!');
                        
                        // Pulse animation
                        card.css('transform', 'scale(1.02)');
                        setTimeout(function() {
                            card.css('transform', 'scale(1)');
                        }, 300);
                    }
                },
                error: function(xhr) {
                    switchEl.prop('checked', !status);
                    showToast('error', '❌ Gagal! ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
                },
                complete: function() {
                    switchEl.prop('disabled', false);
                    card.removeClass('pm-loading');
                }
            });
        });

        // ============================================================
        // UPDATE STATISTICS
        // ============================================================
        function updateStats() {
            var active = $('.toggle-protect:checked').length;
            var total = 14;
            var inactive = total - active;
            var percentage = Math.round((active / total) * 100);
            
            // Animate numbers
            animateNumber($('#activeProtects'), active);
            animateNumber($('#inactiveProtects'), inactive);
            animateNumber($('#activeCount'), active);
            $('#tabActiveCount').text(active);
            
            // Update status badge
            var $badge = $('#statusBadge');
            var $statusText = $('#statusText');
            var $fill = $('#statusFill');
            
            $fill.css('width', percentage + '%');
            
            if (active === total) {
                $statusText.html('🛡️ FULL PROTECTION - ' + active + '/' + total);
                $badge.css('border-color', 'rgba(67, 233, 123, 0.5)');
                $fill.css('background', 'var(--gradient-4)');
            } else if (active > 0) {
                $statusText.html('⚠️ PARTIAL - ' + active + '/' + total);
                $badge.css('border-color', 'rgba(250, 112, 154, 0.5)');
                $fill.css('background', 'var(--gradient-5)');
            } else {
                $statusText.html('🔓 NO PROTECTION - 0/' + total);
                $badge.css('border-color', 'rgba(255,255,255,0.2)');
                $fill.css('background', 'rgba(255,255,255,0.2)');
            }
        }

        // ============================================================
        // ANIMATE NUMBER
        // ============================================================
        function animateNumber($element, newValue) {
            var currentValue = parseInt($element.text()) || 0;
            var duration = 500;
            var startTime = null;
            
            function animate(currentTime) {
                if (!startTime) startTime = currentTime;
                var elapsed = currentTime - startTime;
                var progress = Math.min(elapsed / duration, 1);
                var value = Math.floor(currentValue + (newValue - currentValue) * progress);
                
                $element.text(value);
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            }
            
            requestAnimationFrame(animate);
        }

        // ============================================================
        // SHOW TOAST
        // ============================================================
        function showToast(type, message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#1a1a2e',
                color: '#fff',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
            
            Toast.fire({
                icon: type,
                title: message
            });
        }

        // ============================================================
        // TAB NAVIGATION
        // ============================================================
        $('.pm-tab').on('click', function() {
            var tab = $(this).data('tab');
            
            $('.pm-tab').removeClass('active');
            $(this).addClass('active');
            
            $('#tab-protections, #tab-konfigurasi, #tab-massal, #tab-branding').fadeOut(200);
            $('#tab-' + tab).delay(200).fadeIn(300);
            
            // Save active tab
            localStorage.setItem('pmActiveTab', tab);
        });

        // Restore active tab
        var savedTab = localStorage.getItem('pmActiveTab');
        if (savedTab && savedTab !== 'protections') {
            $('.pm-tab[data-tab="' + savedTab + '"]').trigger('click');
        }

        // ============================================================
        // SEARCH FILTER
        // ============================================================
        $('#searchProtect').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            var found = false;
            
            $('.pm-protect-card').each(function() {
                var cardText = $(this).text().toLowerCase();
                var category = $(this).data('category').toLowerCase();
                
                if (cardText.includes(searchTerm) || category.includes(searchTerm)) {
                    $(this).show();
                    found = true;
                } else {
                    $(this).hide();
                }
            });
            
            if (found) {
                $('#noResults').hide();
                $('#protectCards').show();
            } else {
                $('#protectCards').hide();
                $('#noResults').show();
            }
        });

        // ============================================================
        // NON-ROOT ADMIN WARNING
        // ============================================================
        @if(Auth::id() !== 1)
            $('.toggle-protect').prop('disabled', true);
            $('.pm-btn-sm').prop('disabled', true);
            
            Swal.fire({
                icon: 'warning',
                title: '⚠️ Read-Only Mode',
                text: 'Anda bukan Root Admin (ID 1). Anda hanya dapat melihat, tidak dapat mengubah proteksi.',
                timer: 5000,
                showConfirmButton: true,
                confirmButtonText: 'Mengerti',
                background: '#1a1a2e',
                color: '#fff'
            });
        @endif

        // ============================================================
        // CONSOLE EASTER EGG
        // ============================================================
        console.log('%c🛡️ Protect Manager v2.0 %cCanva Edition %cloaded successfully!', 
                    'color: #8B5CF6; font-size: 1.2em; font-weight: bold;',
                    'color: #EC4899; font-size: 1.2em;',
                    'color: #fff;');
        console.log('%c👑 Powered by KALL XTREME X %c| %cDibuat untuk Mulia', 
                    'color: #F43F5E; font-weight: bold;',
                    'color: #fff;',
                    'color: #FFD93D; font-weight: bold;');
        console.log('%c💡 Tip: Ketik %cProtectManager.help() %cuntuk melihat semua perintah.', 
                    'color: #fff;',
                    'color: #4ECDC4; font-weight: bold;',
                    'color: #fff;');
    });
</script>
@endsection