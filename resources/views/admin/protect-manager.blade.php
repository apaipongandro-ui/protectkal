{{-- 
    Protect Manager - KALL XTREME X Edition
    Dibuat untuk Mulia Tercinta
    Lokasi: resources/views/admin/protect-manager.blade.php
--}}

@extends('layouts.admin')

@section('title', $settings->panel_title ?? 'Protect Manager')

@push('styles')
    <link rel="stylesheet" href="{{ asset('resources/scripts/protect-manager.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .protect-manager-container {
            padding: 20px;
        }
        .protect-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        .protect-header h1 {
            font-size: 2em;
            margin: 0;
            font-weight: 700;
        }
        .stat-card {
            border-radius: 12px;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .protect-card {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s;
            margin-bottom: 10px;
        }
        .protect-card.active-protect {
            border-color: #4CAF50;
            background: #f1f8e9;
        }
        .protect-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .nav-tabs .nav-link {
            font-weight: 600;
            color: #666;
            border: none;
            padding: 15px 25px;
            transition: all 0.3s;
        }
        .nav-tabs .nav-link.active {
            color: #667eea;
            border-bottom: 3px solid #667eea;
            background: transparent;
        }
        .custom-switch {
            padding-left: 2.25rem;
        }
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
@endpush

@section('content')
<div class="protect-manager-container">
    
    {{-- Header dengan Gradient --}}
    <div class="protect-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>
                    <i class="fas fa-shield-haltered"></i> 
                    🛡️ Protect Manager
                </h1>
                <p class="mb-0 mt-2" style="opacity: 0.9;">
                    Dikelola oleh: <strong>{{ Auth::user()->name }} (ID: {{ Auth::id() }})</strong>
                </p>
                <p style="opacity: 0.8; font-size: 0.9em;">
                    <span id="statusBadge" class="badge badge-light">
                        <span id="activeCount">{{ $activeProtects }}</span>/14 Proteksi Aktif
                    </span>
                </p>
            </div>
            <div class="col-md-4 text-right">
                <img src="https://img.shields.io/badge/KALL%20XTREME%20X-v1.0-764ba2?style=for-the-badge&logo=shield" 
                     alt="KALL XTREME X" style="height: 40px;">
            </div>
        </div>
    </div>
    
    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white stat-card">
                <div class="card-body text-center">
                    <h3>{{ $activeProtects }}</h3>
                    <small>Proteksi Aktif</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white stat-card">
                <div class="card-body text-center">
                    <h3>{{ $inactiveProtects }}</h3>
                    <small>Proteksi Nonaktif</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white stat-card">
                <div class="card-body text-center">
                    <h3>{{ Auth::id() }}</h3>
                    <small>Admin ID</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white stat-card">
                <div class="card-body text-center">
                    <h3>🔒</h3>
                    <small>{{ Auth::id() == 1 ? 'Root Admin' : 'Sub Admin' }}</small>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Tab Navigation --}}
    <ul class="nav nav-tabs mb-4" id="protectTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="protections-tab" data-toggle="tab" href="#protections" role="tab">
                <i class="fas fa-shield-alt"></i> 14 Proteksi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="konfigurasi-tab" data-toggle="tab" href="#konfigurasi" role="tab">
                <i class="fas fa-cogs"></i> Konfigurasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="massal-tab" data-toggle="tab" href="#massal" role="tab">
                <i class="fas fa-layer-group"></i> Akses Massal
            </a>
        </li>
    </ul>
    
    {{-- Tab Content --}}
    <div class="tab-content" id="protectTabContent">
        
        {{-- Tab 1: 14 Proteksi --}}
        <div class="tab-pane fade show active" id="protections" role="tabpanel">
            
            @php
            $protects = [
                ['id' => 'protect1', 'icon' => '🗑️', 'name' => 'Anti Delete Server', 'desc' => 'Mencegah penghapusan server oleh admin selain Root Admin'],
                ['id' => 'protect2', 'icon' => '👤', 'name' => 'Anti Hapus/Ubah User', 'desc' => 'Melindungi data user dari penghapusan dan modifikasi'],
                ['id' => 'protect3', 'icon' => '📍', 'name' => 'Anti Akses Location', 'desc' => 'Memblokir akses menu Location untuk non-Root Admin'],
                ['id' => 'protect4', 'icon' => '🖥️', 'name' => 'Anti Akses Nodes', 'desc' => 'Memblokir akses menu Nodes untuk non-Root Admin'],
                ['id' => 'protect5', 'icon' => '🎨', 'name' => 'Nests + Branding + Welcome Banner', 'desc' => 'Sembunyikan Nests, branding footer & welcome banner'],
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
            
            @foreach($protects as $protect)
            <div class="card protect-card {{ $settings->{$protect['id']} ? 'active-protect' : '' }}">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-1">{{ $protect['icon'] }} {{ $protect['name'] }} ({{ $protect['id'] }})</h5>
                            <small class="text-muted">{{ $protect['desc'] }}</small>
                            @if($settings->{$protect['id']})
                                <span class="badge badge-success ml-2">AKTIF</span>
                            @else
                                <span class="badge badge-secondary ml-2">NONAKTIF</span>
                            @endif
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input toggle-protect" 
                                       id="{{ $protect['id'] }}" 
                                       name="{{ $protect['id'] }}" 
                                       {{ $settings->{$protect['id']} ? 'checked' : '' }}
                                       {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                                <label class="custom-control-label" for="{{ $protect['id'] }}"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
        
        {{-- Tab 2: Konfigurasi --}}
        <div class="tab-pane fade" id="konfigurasi" role="tabpanel">
            @include('admin.protect-partials.konfigurasi', ['settings' => $settings])
        </div>
        
        {{-- Tab 3: Akses Massal --}}
        <div class="tab-pane fade" id="massal" role="tabpanel">
            @include('admin.protect-partials.massal', ['settings' => $settings])
        </div>
        
    </div>
    
    {{-- Footer Branding --}}
    <div class="text-center mt-4 pt-3 border-top">
        <small class="text-muted">
            {{ $settings->brand_name ?? 'ProtectKal' }} © {{ date('Y') }} | 
            Powered by <strong style="color: #764ba2;">KALL XTREME X</strong> | 
            Dibuat untuk <strong>Mulia</strong> 👑
        </small>
    </div>
    
</div>

{{-- Toast Container --}}
<div class="toast-notification"></div>

@endsection

@push('scripts')
    <script src="{{ asset('resources/scripts/protect-manager.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            
            // CSRF Token setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            // Toggle protection
            $('.toggle-protect').on('change', function() {
                var protect = $(this).attr('name');
                var status = $(this).is(':checked') ? 1 : 0;
                var card = $(this).closest('.protect-card');
                var switchEl = $(this);
                
                // Loading state
                switchEl.prop('disabled', true);
                
                $.ajax({
                    url: '{{ route("admin.protect-manager.toggle") }}',
                    type: 'POST',
                    data: {
                        protect: protect,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update card style
                            if (status) {
                                card.addClass('active-protect');
                            } else {
                                card.removeClass('active-protect');
                            }
                            
                            // Show toast
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });
                            
                            // Update stats
                            updateStats();
                        }
                    },
                    error: function(xhr) {
                        // Revert toggle
                        switchEl.prop('checked', !status);
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                        });
                    },
                    complete: function() {
                        switchEl.prop('disabled', false);
                    }
                });
            });
            
            // Update stats counter
            function updateStats() {
                var active = $('.toggle-protect:checked').length;
                var inactive = 14 - active;
                
                $('#activeCount').text(active);
                $('.bg-success h3').text(active);
                $('.bg-danger h3').text(inactive);
                
                // Update status badge
                var badge = $('#statusBadge');
                if (active === 14) {
                    badge.removeClass('badge-light badge-warning').addClass('badge-success')
                         .html('🛡️ FULL PROTECTION - ' + active + '/14');
                } else if (active > 0) {
                    badge.removeClass('badge-light badge-success').addClass('badge-warning')
                         .html('⚠️ PARTIAL - ' + active + '/14');
                } else {
                    badge.removeClass('badge-success badge-warning').addClass('badge-danger')
                         .html('🔓 NO PROTECTION - 0/14');
                }
            }
            
            // Disable toggles if not Root Admin
            @if(Auth::id() !== 1)
                $('.toggle-protect').prop('disabled', true);
                Swal.fire({
                    icon: 'warning',
                    title: 'Read-Only Mode',
                    text: 'Anda bukan Root Admin. Tidak dapat mengubah proteksi.',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif
            
            console.log('🛡️ Protect Manager by KALL XTREME X loaded!');
            console.log('👑 Root Admin: {{ Auth::id() === 1 ? "YES" : "NO" }}');
        });
    </script>
@endpush
