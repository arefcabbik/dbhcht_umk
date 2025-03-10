@extends('layouts.admin')

@section('title', 'Master Data DBHCHT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Master Data DBHCHT</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-usd fa-3x mb-3 text-primary"></i>
                                    <h5 class="card-title">Dana DBHCHT</h5>
                                    <p class="card-text">Kelola data Dana DBHCHT</p>
                                    <a href="{{ route('admin.master.dana-master') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right"></i> Kelola Data
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border">
                                <div class="card-body text-center">
                                    <i class="fas fa-table fa-3x mb-3 text-primary"></i>
                                    <h5 class="card-title">RKP</h5>
                                    <p class="card-text">Kelola Master RKP</p>
                                    <a href="{{ route('admin.master.urusan') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right"></i> Kelola Data
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <!-- Kesejahteraan Masyarakat -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                                    <h5 class="card-title">Kesejahteraan Masyarakat</h5>
                                    <p class="card-text">Kelola data program kesejahteraan masyarakat</p>
                                    <a href="{{ route('admin.master.kesra') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right"></i> Kelola Data
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Penegakan Hukum -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-gavel fa-3x mb-3 text-success"></i>
                                    <h5 class="card-title">Penegakan Hukum</h5>
                                    <p class="card-text">Kelola data program penegakan hukum</p>
                                    <a href="{{ route('admin.master.hukum') }}" class="btn btn-success">
                                        <i class="fas fa-arrow-right"></i> Kelola Data
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Kesehatan -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-heartbeat fa-3x mb-3 text-danger"></i>
                                    <h5 class="card-title">Kesehatan</h5>
                                    <p class="card-text">Kelola data program kesehatan</p>
                                    <a href="{{ route('admin.master.kesehatan') }}" class="btn btn-danger">
                                        <i class="fas fa-arrow-right"></i> Kelola Data
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Data DBHCHT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="dataForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
                    </div>
                    <div class="form-group">
                        <label for="bidang_urusan">Bidang Urusan</label>
                        <input type="text" class="form-control" id="bidang_urusan" name="bidang_urusan" required>
                    </div>
                    <div class="form-group">
                        <label for="program">Program</label>
                        <textarea class="form-control" id="program" name="program" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kegiatan">Kegiatan</label>
                        <textarea class="form-control" id="kegiatan" name="kegiatan" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="sub_kegiatan">Sub Kegiatan</label>
                        <textarea class="form-control" id="sub_kegiatan" name="sub_kegiatan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
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

    .nav-tabs .nav-link {
        color: #495057;
    }

    .nav-tabs .nav-link.active {
        color: #007bff;
        font-weight: bold;
    }

    .btn-action {
        margin: 0 2px;
    }

    .table-responsive {
        min-height: 400px;
    }

    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize simple DataTables without server-side processing
        $('#kesraTable, #industriTable, #lingkunganTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        // Handle tab changes
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            // Adjust DataTables columns when showing tab
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        });
    });

    function createData() {
        $('#formModal').modal('show');
        $('#formModalLabel').text('Tambah Data DBHCHT');
        $('#dataForm')[0].reset();
    }

    // Prevent form submission for now
    $('#dataForm').on('submit', function(e) {
        e.preventDefault();
        alert('Fungsi simpan akan diimplementasikan setelah database siap');
        $('#formModal').modal('hide');
    });
</script>
@endpush