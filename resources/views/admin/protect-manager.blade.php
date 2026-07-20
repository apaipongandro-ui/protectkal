{{-- Protect Manager v2.0 - Canva Edition --}}
{{-- KALL XTREME X untuk Mulia --}}

@extends('layouts.admin')

@section('title', $settings->panel_title ?? 'Protect Manager v2.0')

@push('styles')
    <link rel="stylesheet" href="{{ asset('resources/scripts/protect-manager.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<div class="protect-manager-v2">
    
    {{-- Animated Background --}}
    <div class="pm-bg-animation">
        <div class="pm-orb pm-orb-1"></div>
        <div class="pm-orb pm-orb-2"></div>
        <div class="pm-orb pm-orb-3"></div>
    </div>

    {{-- Header --}}
    <div class="pm-header animate-in">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="pm-gradient-text">🛡️ Protect Manager</h1>
                <p class="pm-subtitle">Dikelola oleh <strong>{{ Auth::user()->name }} (ID: {{ Auth::id() }})</strong></p>
            </div>
            <div class="col-md-4 text-end">
                <span class="pm-status-badge" id="statusBadge">
                    ⚡ <span id="activeCount">{{ $activeProtects ?? 0 }}</span>/14 Aktif
                </span>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="pm-stats-grid">
        <div class="pm-stat-card animate-in delay-1">
            <div class="pm-stat-icon">✅</div>
            <div class="pm-stat-value" id="activeProtects">{{ $activeProtects ?? 0 }}</div>
            <div class="pm-stat-label">Proteksi Aktif</div>
        </div>
        <div class="pm-stat-card animate-in delay-2">
            <div class="pm-stat-icon">⛔</div>
            <div class="pm-stat-value" id="inactiveProtects">{{ $inactiveProtects ?? 14 }}</div>
            <div class="pm-stat-label">Proteksi Nonaktif</div>
        </div>
        <div class="pm-stat-card animate-in delay-3">
            <div class="pm-stat-icon">👤</div>
            <div class="pm-stat-value">ID: {{ Auth::id() }}</div>
            <div class="pm-stat-label">Admin ID</div>
        </div>
        <div class="pm-stat-card animate-in delay-4">
            <div class="pm-stat-icon">👑</div>
            <div class="pm-stat-value">{{ Auth::id() == 1 ? 'Root' : 'Sub' }}</div>
            <div class="pm-stat-label">Level Admin</div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="pm-tabs">
        <div class="pm-tab active" data-tab="protections">🛡️ 14 Proteksi</div>
        <div class="pm-tab" data-tab="konfigurasi">⚙️ Konfigurasi</div>
        <div class="pm-tab" data-tab="massal">📦 Akses Massal</div>
        <div class="pm-tab" data-tab="branding">🎨 Branding</div>
    </div>

    {{-- Tab Content --}}
    <div id="pmTabContent">
        
        {{-- Proteksi Tab --}}
        <div id="tab-protections">
            <div class="pm-protect-grid" id="protectCards">
                @php
                $protectsList = [
                    ['id' => 'protect1', 'icon' => '🗑️', 'name' => 'Anti Delete Server', 'desc' => 'Mencegah penghapusan server oleh admin selain Root Admin'],
                    ['id' => 'protect2', 'icon' => '👤', 'name' => 'Anti Hapus/Ubah User', 'desc' => 'Melindungi data user dari penghapusan & modifikasi'],
                    ['id' => 'protect3', 'icon' => '📍', 'name' => 'Anti Akses Location', 'desc' => 'Memblokir akses menu Location untuk non-Root Admin'],
                    ['id' => 'protect4', 'icon' => '🖥️', 'name' => 'Anti Akses Nodes', 'desc' => 'Memblokir akses menu Nodes untuk non-Root Admin'],
                    ['id' => 'protect5', 'icon' => '🎨', 'name' => 'Nests + Branding + Banner', 'desc' => 'Sembunyikan Nests, branding footer & welcome banner'],
                    ['id' => 'protect6', 'icon' => '⚙️', 'name' => 'Anti Akses Settings', 'desc' => 'Memblokir akses menu Settings untuk non-Root Admin'],
                    ['id' => 'protect7', 'icon' => '📁', 'name' => 'Anti Akses Server File', 'desc' => 'Proteksi file controller server dari akses tidak sah'],
                    ['id' => 'protect8', 'icon' => '🎮', 'name' => 'Anti Akses Server Controller', 'desc' => 'Proteksi server controller dari admin lain'],
                    ['id' => 'protect9', 'icon' => '🔄', 'name' => 'Anti Modifikasi Server', 'desc' => 'Mencegah perubahan detail server oleh admin lain'],
                    ['id' => 'protect10', 'icon' => '🔗', 'name' => 'Anti Tautan Server v1', 'desc' => 'Mencegah perubahan tautan/link server'],
                    ['id' => 'protect11', 'icon' => '🔒', 'name' => 'Anti Tautan Server v2', 'desc' => 'Versi lanjutan proteksi tautan server'],
                    ['id' => 'protect12', 'icon' => '🛡️', 'name' => 'Konsolidasi Proteksi', 'desc' => 'Gabungan proteksi Nodes, API, Key, Locations'],
                    ['id' => 'protect13', 'icon' => '🔑', 'name' => 'Proteksi Application API', 'desc' => 'Menyembunyikan & memblokir Application API'],
                    ['id' => 'protect14', 'icon' => '👑', 'name' => 'Anti Create/Delete Admin', 'desc' => 'Mengunci hak pembuatan & penghapusan admin'],
                ];
                @endphp

                @foreach($protectsList as $index => $protect)
                <div class="pm-protect-card animate-in delay-{{ ($index % 4) + 1 }} {{ $settings->{$protect['id']} ? 'active-protect' : '' }}" id="card-{{ $protect['id'] }}">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="pm-protect-icon">{{ $protect['icon'] }}</div>
                            <div>
                                <div class="pm-protect-name">{{ $protect['name'] }}</div>
                                <div class="pm-protect-desc">{{ $protect['desc'] }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="pm-badge" style="background: {{ $settings->{$protect['id']} ? 'var(--gradient-4)' : 'rgba(255,255,255,0.1)' }}">
                                {{ $settings->{$protect['id']} ? 'AKTIF' : 'NONAKTIF' }}
                            </span>
                            <div class="form-check form-switch mb-0 pm-switch">
                                <input class="form-check-input toggle-protect" type="checkbox" 
                                       id="{{ $protect['id'] }}" 
                                       name="{{ $protect['id'] }}" 
                                       {{ $settings->{$protect['id']} ? 'checked' : '' }}
                                       {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Konfigurasi Tab --}}
        <div id="tab-konfigurasi" style="display: none;">
            @include('admin.protect-partials.konfigurasi', ['settings' => $settings])
        </div>

        {{-- Massal Tab --}}
        <div id="tab-massal" style="display: none;">
            @include('admin.protect-partials.massal', ['settings' => $settings])
        </div>

        {{-- Branding Tab --}}
        <div id="tab-branding" style="display: none;">
            @include('admin.protect-partials.branding', ['settings' => $settings])
        </div>
    </div>

    {{-- Footer --}}
    <div class="pm-footer">
        <span id="footerBrandName">{{ $settings->brand_name ?? 'ProtectKal' }}</span> © {{ date('Y') }} | 
        Powered by <strong class="pm-gradient-text">KALL XTREME X</strong> | 
        Dibuat untuk <strong>Mulia</strong> 👑
    </div>

</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Protect Manager JS --}}
<script src="{{ asset('resources/scripts/protect-manager.js') }}"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        // Toggle protection
        $('.toggle-protect').on('change', function() {
            var protect = $(this).attr('name');
            var status = $(this).is(':checked') ? 1 : 0;
            var card = $('#card-' + protect);
            var switchEl = $(this);
            
            switchEl.prop('disabled', true);
            
            $.ajax({
                url: '{{ route("admin.protect-manager.toggle") }}',
                type: 'POST',
                data: { protect: protect, status: status },
                success: function(response) {
                    if (response.success) {
                        if (status) {
                            card.addClass('active-protect');
                            card.find('.pm-badge').css('background', 'var(--gradient-4)').text('AKTIF');
                        } else {
                            card.removeClass('active-protect');
                            card.find('.pm-badge').css('background', 'rgba(255,255,255,0.1)').text('NONAKTIF');
                        }
                        updateStats();
                        
                        const Toast = Swal.mixin({
                            toast: true, position: 'top-end', showConfirmButton: false,
                            timer: 2000, timerProgressBar: true,
                            background: '#1a1a2e', color: '#fff'
                        });
                        Toast.fire({ icon: 'success', title: response.message });
                    }
                },
                error: function(xhr) {
                    switchEl.prop('checked', !status);
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: xhr.responseJSON?.message || 'Terjadi kesalahan', background: '#1a1a2e', color: '#fff' });
                },
                complete: function() {
                    switchEl.prop('disabled', false);
                }
            });
        });

        // Update stats
        function updateStats() {
            var active = $('.toggle-protect:checked').length;
            var inactive = 14 - active;
            $('#activeProtects').text(active);
            $('#inactiveProtects').text(inactive);
            $('#activeCount').text(active);
            
            var badge = $('#statusBadge');
            if (active === 14) {
                badge.html('🛡️ FULL PROTECTION - 14/14');
                badge.css('background', 'var(--gradient-4)');
            } else if (active > 0) {
                badge.html('⚠️ PARTIAL - ' + active + '/14');
                badge.css('background', 'var(--gradient-5)');
            } else {
                badge.html('🔓 NO PROTECTION - 0/14');
                badge.css('background', 'rgba(255,255,255,0.1)');
            }
        }

        // Tab navigation
        $('.pm-tab').on('click', function() {
            var tab = $(this).data('tab');
            $('.pm-tab').removeClass('active');
            $(this).addClass('active');
            $('#tab-protections, #tab-konfigurasi, #tab-massal, #tab-branding').hide();
            $('#tab-' + tab).show();
        });

        @if(Auth::id() !== 1)
            $('.toggle-protect').prop('disabled', true);
            Swal.fire({
                icon: 'warning', title: 'Read-Only Mode',
                text: 'Anda bukan Root Admin. Tidak dapat mengubah proteksi.',
                timer: 3000, showConfirmButton: false,
                toast: true, position: 'top-end',
                background: '#1a1a2e', color: '#fff'
            });
        @endif

        console.log('🛡️ Protect Manager v2.0 - Canva Edition loaded!');
        console.log('👑 KALL XTREME X untuk Mulia');
    });
</script>
@endsection