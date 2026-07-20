{{-- Akses Massal Tab - Protect Manager --}}

<div class="card">
    <div class="card-header bg-warning">
        <h5 class="mb-0"><i class="fas fa-layer-group"></i> Akses Massal (Bulk Install/Uninstall)</h5>
    </div>
    <div class="card-body">
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Info:</strong> Fitur ini memungkinkan Anda mengaktifkan atau menonaktifkan semua 14 proteksi sekaligus. 
            Gunakan dengan hati-hati!
        </div>
        
        <div class="row">
            {{-- Bulk Install --}}
            <div class="col-md-6">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-check-circle"></i> Bulk Install (Aktifkan Semua)</h6>
                    </div>
                    <div class="card-body text-center">
                        <p>Klik tombol di bawah untuk <strong>mengaktifkan</strong> semua 14 proteksi sekaligus.</p>
                        
                        <button type="button" class="btn btn-success btn-lg bulk-install-btn" 
                                {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                            <i class="fas fa-shield-alt"></i> INSTALL SEMUA PROTEKSI
                        </button>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                Status saat ini: 
                                <strong>{{ $activeProtects ?? 0 }}</strong>/14 proteksi aktif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Bulk Uninstall --}}
            <div class="col-md-6">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0"><i class="fas fa-times-circle"></i> Bulk Uninstall (Nonaktifkan Semua)</h6>
                    </div>
                    <div class="card-body text-center">
                        <p>Klik tombol di bawah untuk <strong>menonaktifkan</strong> semua 14 proteksi sekaligus.</p>
                        
                        <button type="button" class="btn btn-danger btn-lg bulk-uninstall-btn"
                                {{ Auth::id() !== 1 ? 'disabled' : '' }}>
                            <i class="fas fa-unlock"></i> UNINSTALL SEMUA PROTEKSI
                        </button>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                Status saat ini: 
                                <strong>{{ $inactiveProtects ?? 0 }}</strong>/14 proteksi nonaktif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>
        
        {{-- Custom Bulk Selection --}}
        <h6 class="mb-3"><i class="fas fa-check-square"></i> Pilih Proteksi yang Ingin Diatur</h6>
        
        <div class="row">
            @php
            $protectsList = [
                ['id' => 'protect1', 'name' => 'Anti Delete Server'],
                ['id' => 'protect2', 'name' => 'Anti Hapus/Ubah User'],
                ['id' => 'protect3', 'name' => 'Anti Akses Location'],
                ['id' => 'protect4', 'name' => 'Anti Akses Nodes'],
                ['id' => 'protect5', 'name' => 'Nests + Branding + Banner'],
                ['id' => 'protect6', 'name' => 'Anti Akses Settings'],
                ['id' => 'protect7', 'name' => 'Anti Akses Server File'],
                ['id' => 'protect8', 'name' => 'Anti Akses Server Controller'],
                ['id' => 'protect9', 'name' => 'Anti Modifikasi Server'],
                ['id' => 'protect10', 'name' => 'Anti Tautan Server v1'],
                ['id' => 'protect11', 'name' => 'Anti Tautan Server v2'],
                ['id' => 'protect12', 'name' => 'Konsolidasi Proteksi'],
                ['id' => 'protect13', 'name' => 'Proteksi Application API'],
                ['id' => 'protect14', 'name' => 'Anti Create/Delete Admin'],
            ];
            @endphp
            
            @foreach($protectsList as $protect)
            <div class="col-md-6">
                <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input bulk-checkbox" 
                           id="bulk_{{ $protect['id'] }}" 
                           value="{{ $protect['id'] }}"
                           {{ $settings->{$protect['id']} ? 'checked' : '' }}>
                    <label class="custom-control-label" for="bulk_{{ $protect['id'] }}">
                        {{ $protect['name'] }}
                        @if($settings->{$protect['id']})
                            <span class="badge badge-success">AKTIF</span>
                        @else
                            <span class="badge badge-secondary">NONAKTIF</span>
                        @endif
                    </label>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <button type="button" class="btn btn-success mr-2 bulk-action-btn" data-action="install">
                <i class="fas fa-check"></i> Install Terpilih
            </button>
            <button type="button" class="btn btn-danger bulk-action-btn" data-action="uninstall">
                <i class="fas fa-times"></i> Uninstall Terpilih
            </button>
        </div>
        
    </div>
</div>

<script>
    $(document).ready(function() {
        
        // Bulk Install All
        $('.bulk-install-btn').on('click', function() {
            Swal.fire({
                title: 'Konfirmasi Bulk Install',
                text: 'Anda akan mengaktifkan SEMUA 14 proteksi. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Install Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.protect-manager.bulk.install") }}',
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            Swal.fire('Sukses!', response.message, 'success')
                                .then(() => location.reload());
                        }
                    });
                }
            });
        });
        
        // Bulk Uninstall All
        $('.bulk-uninstall-btn').on('click', function() {
            Swal.fire({
                title: 'Konfirmasi Bulk Uninstall',
                text: 'Anda akan menonaktifkan SEMUA 14 proteksi. Lanjutkan?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Ya, Uninstall Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.protect-manager.bulk.uninstall") }}',
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            Swal.fire('Sukses!', response.message, 'success')
                                .then(() => location.reload());
                        }
                    });
                }
            });
        });
        
        // Bulk Action Selected
        $('.bulk-action-btn').on('click', function() {
            var action = $(this).data('action');
            var selected = [];
            
            $('.bulk-checkbox:checked').each(function() {
                selected.push($(this).val());
            });
            
            if (selected.length === 0) {
                Swal.fire('Peringatan!', 'Pilih minimal satu proteksi!', 'warning');
                return;
            }
            
            var url = action === 'install' 
                ? '{{ route("admin.protect-manager.bulk.install") }}' 
                : '{{ route("admin.protect-manager.bulk.uninstall") }}';
            
            var actionText = action === 'install' ? 'mengaktifkan' : 'menonaktifkan';
            
            Swal.fire({
                title: 'Konfirmasi',
                text: `Anda akan ${actionText} ${selected.length} proteksi. Lanjutkan?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: { 
                            _token: '{{ csrf_token() }}',
                            protects: selected 
                        },
                        success: function(response) {
                            Swal.fire('Sukses!', response.message, 'success')
                                .then(() => location.reload());
                        }
                    });
                }
            });
        });
        
    });
</script>
