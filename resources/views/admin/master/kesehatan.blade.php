@extends('layouts.admin')

@section('title', 'Master Data - Kesehatan')

@section('content')
<div class="container-fluid">
    <!-- Navigation Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('admin.master.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Kesehatan</h3>
                    <div class="card-tools">
                        
                    </div>
                </div>
                <div class="card-body">
                    <!-- Tabel Urusan -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="kesehatanTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Urusan</th>
                                    <th>Aktif</th>
                                    <th width="150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>3</td>
                                    <td>Kesehatan</td>
                                    <td>Ya</td>
                                    <td>
                                        <button class="btn btn-sm btn-info btn-action" onclick="editData(1)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success btn-action" onclick="viewBidangUrusan(1)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteData(1)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Bidang Urusan Section -->
                    <div id="bidangUrusanSection" class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Bidang Urusan - <span id="selectedUrusanName">Kesehatan</span></h4>
                            <button class="btn btn-primary btn-sm" onclick="createBidangUrusan()">
                                <i class="fas fa-plus"></i> Tambah Bidang Urusan
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="bidangUrusanTable">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Kode Urusan</th>
                                        <th>Nama Bidang Urusan</th>
                                        <th>Aktif</th>
                                        <th width="150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>3.1</td>
                                        <td>3</td>
                                        <td>Pelayanan Kesehatan Masyarakat</td>
                                        <td>Ya</td>
                                        <td>
                                            <button class="btn btn-sm btn-info btn-action" onclick="editBidangUrusan(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success btn-action" onclick="viewProgram(1)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-action" onclick="deleteBidangUrusan(1)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Program Section -->
                    <div id="programSection" class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Program - <span id="selectedBidangUrusanName">Pelayanan Kesehatan Masyarakat</span></h4>
                            <button class="btn btn-primary btn-sm" onclick="createProgram()">
                                <i class="fas fa-plus"></i> Tambah Program
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="programTable">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th>Kode Program</th>
                                        <th>Kode Urusan</th>
                                        <th>Kode Bidang Urusan</th>
                                        <th>ID Periode</th>
                                        <th>Nama Program</th>
                                        <th>Aktif</th>
                                        <th width="150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>3.1.1</td>
                                        <td>3</td>
                                        <td>3.1</td>
                                        <td>2024</td>
                                        <td>Program Pencegahan Dampak Rokok</td>
                                        <td>Ya</td>
                                        <td>
                                            <button class="btn btn-sm btn-info btn-action" onclick="editProgram(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success btn-action" onclick="viewProgramIndikator(1)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-action" onclick="deleteProgram(1)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Program Indikator Section -->
                    <div id="programIndikatorSection" class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Indikator Program - <span id="selectedProgramName">Program Pencegahan Dampak Rokok</span></h4>
                            <button class="btn btn-primary btn-sm" onclick="createProgramIndikator()">
                                <i class="fas fa-plus"></i> Tambah Indikator
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="programIndikatorTable">
                                <thead class="bg-warning text-white">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Kode Urusan</th>
                                        <th>Kode Bidang Urusan</th>
                                        <th>Kode Program</th>
                                        <th>ID Periode</th>
                                        <th>Indikator</th>
                                        <th>Aktif</th>
                                        <th width="150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>3.1.1.1</td>
                                        <td>3</td>
                                        <td>3.1</td>
                                        <td>3.1.1</td>
                                        <td>2024</td>
                                        <td>Persentase penurunan dampak kesehatan akibat rokok</td>
                                        <td>Ya</td>
                                        <td>
                                            <button class="btn btn-sm btn-info btn-action" onclick="editProgramIndikator(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-action" onclick="deleteProgramIndikator(1)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .table thead th {
        vertical-align: middle;
        text-align: center;
    }
    .btn-action {
        margin: 0 2px;
    }
    .table td {
        vertical-align: middle;
    }
    #bidangUrusanSection, #programSection, #programIndikatorSection {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#kesehatanTable').DataTable({
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });

    function viewBidangUrusan(urusanId) {
        $('#bidangUrusanSection').show();
        $('#programSection').hide();
        $('#programIndikatorSection').hide();
        $('#selectedUrusanName').text('Kesehatan');
        
        // Initialize DataTable for bidangUrusanTable
        if (!$.fn.DataTable.isDataTable('#bidangUrusanTable')) {
            $('#bidangUrusanTable').DataTable({
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        }
    }

    function viewProgram(bidangUrusanId) {
        $('#programSection').show();
        $('#programIndikatorSection').hide();
        $('#selectedBidangUrusanName').text('Pelayanan Kesehatan Masyarakat');
        
        // Initialize DataTable for programTable
        if (!$.fn.DataTable.isDataTable('#programTable')) {
            $('#programTable').DataTable({
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        }
    }

    function viewProgramIndikator(programId) {
        $('#programIndikatorSection').show();
        $('#selectedProgramName').text('Program Pencegahan Dampak Rokok');
        
        // Initialize DataTable for programIndikatorTable
        if (!$.fn.DataTable.isDataTable('#programIndikatorTable')) {
            $('#programIndikatorTable').DataTable({
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        }
    }

    // Fungsi untuk menambah data
    function createData() {
        alert('Fungsi tambah urusan akan diimplementasikan');
    }

    function createBidangUrusan() {
        alert('Fungsi tambah bidang urusan akan diimplementasikan');
    }

    function createProgram() {
        alert('Fungsi tambah program akan diimplementasikan');
    }

    function createProgramIndikator() {
        alert('Fungsi tambah indikator program akan diimplementasikan');
    }

    // Fungsi untuk edit data
    function editData(id) {
        alert('Fungsi edit urusan akan diimplementasikan');
    }

    function editBidangUrusan(id) {
        alert('Fungsi edit bidang urusan akan diimplementasikan');
    }

    function editProgram(id) {
        alert('Fungsi edit program akan diimplementasikan');
    }

    function editProgramIndikator(id) {
        alert('Fungsi edit indikator program akan diimplementasikan');
    }

    // Fungsi untuk hapus data
    function deleteData(id) {
        if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            alert('Fungsi hapus urusan akan diimplementasikan');
        }
    }

    function deleteBidangUrusan(id) {
        if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            alert('Fungsi hapus bidang urusan akan diimplementasikan');
        }
    }

    function deleteProgram(id) {
        if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            alert('Fungsi hapus program akan diimplementasikan');
        }
    }

    function deleteProgramIndikator(id) {
        if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            alert('Fungsi hapus indikator program akan diimplementasikan');
        }
    }
</script>
@endpush 