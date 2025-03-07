@extends('layouts.opd')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Laporan Bulanan</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('opd.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Laporan Bulanan</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLaporan">
                                <i class="fas fa-plus me-2"></i>Tambah Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tahun</label>
                            <select class="form-select" name="tahun" id="tahun">
                                @php
                                    $currentYear = date('Y');
                                    $startYear = 2020;
                                @endphp
                                @for($year = $currentYear; $year >= $startYear; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Bulan</label>
                            <select class="form-select" name="bulan" id="bulan">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2"></i>Data Laporan Bulanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="tableLaporan">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px">No</th>
                                    <th>Kegiatan</th>
                                    <th>Target</th>
                                    <th>Realisasi</th>
                                    <th>Capaian</th>
                                    <th>Anggaran</th>
                                    <th>Realisasi Anggaran</th>
                                    <th>Capaian Anggaran</th>
                                    <th>Keterangan</th>
                                    <th style="width: 100px">Aksi</th>
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

<!-- Modal Tambah/Edit Laporan -->
<div class="modal fade" id="modalLaporan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Form Laporan Bulanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formLaporan">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kegiatan</label>
                        <select class="form-select" name="kegiatan_id" required>
                            <option value="">Pilih Kegiatan</option>
                            <!-- Options will be loaded here -->
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Target</label>
                            <input type="number" class="form-control" name="target" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Realisasi</label>
                            <input type="number" class="form-control" name="realisasi" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Anggaran</label>
                            <input type="number" class="form-control" name="anggaran" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Realisasi Anggaran</label>
                            <input type="number" class="form-control" name="realisasi_anggaran" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
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
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#tableLaporan').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('opd.laporan.data') }}",
            data: function(d) {
                d.tahun = $('#tahun').val();
                d.bulan = $('#bulan').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'kegiatan', name: 'kegiatan'},
            {data: 'target', name: 'target'},
            {data: 'realisasi', name: 'realisasi'},
            {
                data: 'capaian',
                render: function(data) {
                    return data + '%';
                }
            },
            {
                data: 'anggaran',
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {
                data: 'realisasi_anggaran',
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {
                data: 'capaian_anggaran',
                render: function(data) {
                    return data + '%';
                }
            },
            {data: 'keterangan', name: 'keterangan'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Filter Form Submit
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // Load Kegiatan Options
    function loadKegiatan() {
        $.get("{{ route('opd.laporan.kegiatan') }}", function(response) {
            const select = $('select[name="kegiatan_id"]');
            select.empty().append('<option value="">Pilih Kegiatan</option>');
            response.forEach(function(item) {
                select.append(`<option value="${item.id}">${item.nama_kegiatan}</option>`);
            });
        });
    }

    // Handle Kegiatan Change
    $('select[name="kegiatan_id"]').on('change', function() {
        const id = $(this).val();
        if (id) {
            $.get(`{{ url('opd/laporan/kegiatan') }}/${id}`, function(response) {
                $('input[name="target"]').val(response.target);
                $('input[name="anggaran"]').val(response.anggaran);
            });
        }
    });

    // Form Submit
    $('#formLaporan').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            url: "{{ route('opd.laporan.store') }}",
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#modalLaporan').modal('hide');
                table.ajax.reload();
                Swal.fire('Berhasil', 'Data laporan berhasil disimpan', 'success');
            },
            error: function(xhr) {
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        });
    });

    // Initial Load
    loadKegiatan();
});
</script>
@endpush 