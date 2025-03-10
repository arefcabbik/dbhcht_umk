@extends('layouts.admin')

@section('title', 'Master Data - Kesejahteraan Masyarakat')

@section('content')
<div class="container-fluid">
    <!-- Navigation Buttons -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('admin.master.index') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{$title}}</h5>
                    <div class="card-tools">

                    </div>
                </div>
                <div class="card-body">
                    <!-- panggil view nav_tab -->
                     @include('admin.master.nav_tab_dana')

                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <x-button.primary label="Tambah Dana" url="{{ route('admin.master.dana-master.tambah') }}">Tambah data</x-button.primary>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" id="danaTable">
                                    <thead class="bg-primary text-white">
                                        <tr class="text-center">
                                            <th width="5%">No</th>
                                            <th width="10%">Aksi</th>
                                            <th width="7%">Tahun</th>
                                            <th width="">Dana</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $dana)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center d-flex gap-1">
                                                <x-button.success type="button"><i class="fas fa-eye"></i></x-button.success>
                                                <x-button.warning type="button"><i class="fas fa-pencil"></i></x-button.warning>
                                                <x-button.danger type="button"><i class="fas fa-trash"></i></x-button.danger>
                                            </td>
                                            <td class="text-center">{{ $dana->tahun }}</td>
                                            <td>{{ $dana->nominal }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <h2 class="mb-3">Profile</h2>
                            <p class="lead">This is the profile tab content.</p>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <h2 class="mb-3">Contact</h2>
                            <p class="lead">This is the contact tab content.</p>
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

    #bidangUrusanSection,
    #programSection,
    #programIndikatorSection {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    @if(session('success'))
    Swal.fire({
        title: "Berhasil!",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonText: false
    });
    @endif

    $(document).ready(function() {
        $('#kesraTable').DataTable({
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
        $('#selectedUrusanName').text('Kesehatan Masyarakat');

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
        $('#selectedBidangUrusanName').text('Pelayanan Kesehatan');

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
        $('#selectedProgramName').text('Program Pelayanan Kesehatan Dasar');

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
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            alert('Fungsi hapus urusan akan diimplementasikan');
        }
    }

    function deleteBidangUrusan(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            alert('Fungsi hapus bidang urusan akan diimplementasikan');
        }
    }

    function deleteProgram(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            alert('Fungsi hapus program akan diimplementasikan');
        }
    }

    function deleteProgramIndikator(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            alert('Fungsi hapus indikator program akan diimplementasikan');
        }
    }
</script>
@endpush