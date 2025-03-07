@extends('layouts.opd')

@section('title', 'Rekap RKP dan RKA')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Rekap RKP dan RKA</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('opd.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Rekap RKP dan RKA</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{ route('opd.rkp.input') }}" class="btn btn-primary me-2">
                                <i class="fas fa-plus me-2"></i>Tambah RKP
                            </a>
                            <a href="{{ route('opd.rka.manual') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah RKA
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table RKP Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Data RKP
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="table-rkp">
                            <thead>
                                <tr class="bg-light">
                                    <th class="text-center" style="width: 50px">No</th>
                                    <th>Urusan</th>
                                    <th>Bidang Urusan</th>
                                    <th>Program</th>
                                    <th>Kegiatan</th>
                                    <th>Indikator</th>
                                    <th class="text-center">Target</th>
                                    <th>Satuan</th>
                                    <th class="text-end">Pagu Anggaran</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data RKP will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table RKA Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Data RKA
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="table-rka">
                            <thead>
                                <tr class="bg-light">
                                    <th class="text-center" style="width: 50px">No</th>
                                    <th>Urusan</th>
                                    <th>Bidang Urusan</th>
                                    <th>Program</th>
                                    <th>Kegiatan</th>
                                    <th>Sub Kegiatan</th>
                                    <th>Indikator</th>
                                    <th class="text-center">Target</th>
                                    <th>Satuan</th>
                                    <th class="text-end">Pagu Anggaran</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data RKA will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header {
        background-color: #1a237e !important;
    }

    .btn-primary {
        background-color: #1a237e;
        border-color: #1a237e;
    }

    .btn-primary:hover {
        background-color: #283593;
        border-color: #283593;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        vertical-align: middle;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        padding: 6px 12px;
        font-weight: 500;
        border-radius: 20px;
    }
    
    .badge-draft {
        background-color: #1a237e;
        color: #fff;
    }
    
    .badge-verifikasi {
        background-color: #283593;
        color: #fff;
    }
    
    .badge-revisi {
        background-color: #dc3545;
        color: #fff;
    }
    
    .badge-selesai {
        background-color: #28a745;
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 30px;
        color: #666;
    }

    .breadcrumb-item a {
        color: #1a237e;
    }

    .breadcrumb-item.active {
        color: #283593;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Load RKP Data
    function loadRkpData() {
        $.get("{{ route('opd.rkp.data') }}", function(response) {
            const tbody = $('#table-rkp tbody');
            tbody.empty();
            
            if (response.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="11" class="empty-state">
                            Tidak Ada Data
                        </td>
                    </tr>
                `);
                return;
            }

            response.forEach((item, index) => {
                tbody.append(`
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${item.urusan.nama_urusan}</td>
                        <td>${item.bidang_urusan.nama_bidang_urusan}</td>
                        <td>${item.program.nama_program}</td>
                        <td>${item.kegiatan.nama_kegiatan}</td>
                        <td>${item.indikator}</td>
                        <td class="text-center">${item.target}</td>
                        <td>${item.satuan}</td>
                        <td class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(item.pagu_anggaran)}</td>
                        <td class="text-center">
                            <span class="badge badge-${item.status}">${formatStatus(item.status)}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ url('opd/rkp/edit') }}/${item.id}" class="btn btn-sm btn-warning me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRkp(${item.id})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        });
    }

    // Load RKA Data
    function loadRkaData() {
        $.get("{{ route('opd.rka.data') }}", function(response) {
            const tbody = $('#table-rka tbody');
            tbody.empty();
            
            if (response.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="12" class="empty-state">
                            Tidak Ada Data
                        </td>
                    </tr>
                `);
                return;
            }

            response.forEach((item, index) => {
                tbody.append(`
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${item.urusan.nama_urusan}</td>
                        <td>${item.bidang_urusan.nama_bidang_urusan}</td>
                        <td>${item.program.nama_program}</td>
                        <td>${item.kegiatan.nama_kegiatan}</td>
                        <td>${item.sub_kegiatan}</td>
                        <td>${item.indikator}</td>
                        <td class="text-center">${item.target}</td>
                        <td>${item.satuan}</td>
                        <td class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(item.pagu_anggaran)}</td>
                        <td class="text-center">
                            <span class="badge badge-${item.status}">${formatStatus(item.status)}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ url('opd/rka/edit') }}/${item.id}" class="btn btn-sm btn-warning me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRka(${item.id})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        });
    }

    // Initial load for both tables
    loadRkpData();
    loadRkaData();

    // Format Status
    function formatStatus(status) {
        const statusMap = {
            'draft': 'Draft',
            'verifikasi': 'Verifikasi',
            'revisi': 'Revisi',
            'selesai': 'Selesai'
        };
        return statusMap[status] || status;
    }

    // Delete RKP
    window.deleteRkp = function(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data RKP ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('opd/rkp') }}/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', 'Data RKP berhasil dihapus', 'success');
                        loadRkpData();
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data', 'error');
                    }
                });
            }
        });
    }

    // Delete RKA
    window.deleteRka = function(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data RKA ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('opd/rka') }}/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', 'Data RKA berhasil dihapus', 'success');
                        loadRkaData();
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data', 'error');
                    }
                });
            }
        });
    }
});
</script>
@endpush