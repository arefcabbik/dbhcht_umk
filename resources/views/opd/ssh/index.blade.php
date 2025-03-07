@extends('layouts.opd')

@section('title', 'Data SSH')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Data SSH</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('opd.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Data SSH</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Search Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Daftar SSH</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari SSH...">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="sshTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-center" style="width: 50px">No</th>
                                    <th>Kode Kelompok Barang</th>
                                    <th>Uraian Kelompok Barang</th>
                                    <th>ID Standar Harga</th>
                                    <th>Kode Barang</th>
                                    <th>Uraian Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th>Kode Rekening</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(DB::table('ssh')->get() as $index => $ssh)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $ssh->kode_kelompok_barang }}</td>
                                    <td>{{ $ssh->uraian_kelompok_barang }}</td>
                                    <td>{{ $ssh->id_standar_harga }}</td>
                                    <td>{{ $ssh->kode_barang }}</td>
                                    <td>{{ $ssh->uraian_barang }}</td>
                                    <td>{{ $ssh->spesifikasi ?? '-' }}</td>
                                    <td>{{ $ssh->satuan }}</td>
                                    <td class="text-right">
                                        Rp {{ number_format($ssh->harga_satuan, 2, ',', '.') }}
                                    </td>
                                    <td>{{ $ssh->kode_rekening ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
    }
    .card-header {
        background-color: #1a237e !important;
        border-bottom: 1px solid #e9ecef;
    }
    .table thead th {
        vertical-align: middle;
        text-align: center;
        background-color: #1a237e;
        color: white;
    }
    .table td {
        vertical-align: middle;
    }
    .table td:nth-child(9) {
        text-align: right;
    }
    .btn-primary {
        background-color: #1a237e;
        border-color: #1a237e;
    }
    .btn-primary:hover {
        background-color: #151b60;
        border-color: #151b60;
    }
    .breadcrumb-item a {
        color: #1a237e;
    }
    .input-group .btn {
        padding: 0.375rem 1rem;
    }
    .input-group .btn i {
        margin-right: 5px;
    }
    /* Styling untuk DataTables */
    .dataTables_length select {
        min-width: 70px;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        border-radius: 0.25rem;
    }
    .dataTables_filter {
        display: none; /* Sembunyikan search default karena kita menggunakan custom search */
    }
    .dataTables_info {
        padding-top: 0.5rem !important;
    }
    .pagination {
        margin: 0;
    }
    .page-link {
        padding: 0.375rem 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#sshTable').DataTable({
            processing: true,
            serverSide: false,
            paging: true,
            pageLength: 50, // Menampilkan 50 data per halaman
            lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "Semua"]], // Opsi jumlah data per halaman
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                search: "Pencarian:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            drawCallback: function(settings) {
                $('.dataTables_paginate > .pagination').addClass('pagination-sm');
            }
        });

        // Custom search dengan delay
        var searchTimer;
        $('#searchInput').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                table.search($('#searchInput').val()).draw();
            }, 500); // Delay 500ms setelah selesai mengetik
        });

        // Styling DataTables
        $('#sshTable_wrapper .row:first').addClass('mb-3');
        $('#sshTable_wrapper .row:last').addClass('mt-3');
    });
</script>
@endpush 