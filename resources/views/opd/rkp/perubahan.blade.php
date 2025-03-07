@extends('layouts.opd')

@section('title', 'Perubahan RKP')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Perubahan RKP</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('opd.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Perubahan RKP</li>
                                </ol>
                            </nav>
                        </div>
                        {{-- <div>
                            <a href="{{ route('opd.rkp.perubahan.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Perubahan
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Perubahan RKP -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat Perubahan RKP
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="table-perubahan">
                            <thead>
                                <tr class="bg-light">
                                    <th class="text-center" style="width: 50px">No</th>
                                    <th>Tanggal Perubahan</th>
                                    <th>Urusan</th>
                                    <th>Program</th>
                                    <th>Kegiatan</th>
                                    <th>Indikator</th>
                                    <th class="text-center">Target Awal</th>
                                    <th class="text-center">Target Perubahan</th>
                                    <th>Satuan</th>
                                    <th class="text-end">Pagu Awal</th>
                                    <th class="text-end">Pagu Perubahan</th>
                                    <th>Alasan Perubahan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here -->
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
    // Load Perubahan Data
    function loadPerubahanData() {
        $.get("{{ route('opd.rkp.perubahan.history') }}", function(response) {
            const tbody = $('#table-perubahan tbody');
            tbody.empty();
            
            if (response.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="14" class="empty-state">
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
                        <td>${item.tanggal_perubahan}</td>
                        <td>${item.urusan.nama_urusan}</td>
                        <td>${item.program.nama_program}</td>
                        <td>${item.kegiatan.nama_kegiatan}</td>
                        <td>${item.indikator}</td>
                        <td class="text-center">${item.target_awal}</td>
                        <td class="text-center">${item.target_perubahan}</td>
                        <td>${item.satuan}</td>
                        <td class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(item.pagu_awal)}</td>
                        <td class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(item.pagu_perubahan)}</td>
                        <td>${item.alasan_perubahan}</td>
                        <td class="text-center">
                            <span class="badge badge-${item.status}">${formatStatus(item.status)}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ url('opd/rkp/perubahan/edit') }}/${item.id}" class="btn btn-sm btn-warning me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deletePerubahan(${item.id})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        });
    }

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

    // Delete Perubahan
    window.deletePerubahan = function(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data perubahan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('opd/rkp/perubahan') }}/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', 'Data perubahan berhasil dihapus', 'success');
                        loadPerubahanData();
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data', 'error');
                    }
                });
            }
        });
    }

    // Initial load
    loadPerubahanData();
});
</script>
@endpush 