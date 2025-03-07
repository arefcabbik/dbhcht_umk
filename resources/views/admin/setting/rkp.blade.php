@extends('layouts.admin')

@section('title', 'Setting RKP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Setting Periode RKP</h3>
                </div>
                <div class="card-body">
                    <form id="formPeriodeRKP">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun">Tahun Anggaran</label>
                                    <input type="number" class="form-control" id="tahun" name="tahun" required min="2024" max="2030" value="{{ date('Y') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Setting Perubahan RKP</h3>
                </div>
                <div class="card-body">
                    <form id="formPerubahanRKP">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="periode_id">Periode RKP</label>
                                    <select class="form-control" id="periode_id" name="periode_id" required>
                                        <option value="">Pilih Periode RKP</option>
                                        <!-- Options will be loaded via AJAX -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status_perubahan">Status Perubahan</label>
                                    <select class="form-control" id="status_perubahan" name="status_perubahan" required>
                                        <option value="1">Buka Perubahan</option>
                                        <option value="0">Tutup Perubahan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai_perubahan">Tanggal Mulai Perubahan</label>
                                    <input type="date" class="form-control" id="tanggal_mulai_perubahan" name="tanggal_mulai_perubahan" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_selesai_perubahan">Tanggal Selesai Perubahan</label>
                                    <input type="date" class="form-control" id="tanggal_selesai_perubahan" name="tanggal_selesai_perubahan" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Periode RKP</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tablePeriode">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Status Perubahan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
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
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const tablePeriode = $('#tablePeriode').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.setting.rkp.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'tahun', name: 'tahun'},
            {data: 'tanggal_mulai', name: 'tanggal_mulai'},
            {data: 'tanggal_selesai', name: 'tanggal_selesai'},
            {data: 'status', name: 'status'},
            {data: 'status_perubahan', name: 'status_perubahan'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Load Periode RKP Options
    function loadPeriodeOptions() {
        $.get("{{ route('admin.setting.rkp.list') }}", function(data) {
            const select = $('#periode_id');
            select.empty();
            select.append('<option value="">Pilih Periode RKP</option>');
            data.forEach(function(periode) {
                select.append(`<option value="${periode.id}">Tahun Anggaran ${periode.tahun}</option>`);
            });
        });
    }

    // Load periode options on page load
    loadPeriodeOptions();

    // Handle Periode RKP Form Submit
    $('#formPeriodeRKP').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.setting.rkp.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Data periode RKP berhasil disimpan');
                tablePeriode.ajax.reload();
                loadPeriodeOptions();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });

    // Handle Perubahan RKP Form Submit
    $('#formPerubahanRKP').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.setting.rkp.perubahan.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Setting perubahan RKP berhasil disimpan');
                tablePeriode.ajax.reload();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });

    // Handle Edit Periode
    window.editPeriode = function(id) {
        $.get("{{ url('admin/setting/rkp') }}/" + id, function(data) {
            $('#tahun').val(data.tahun);
            $('#status').val(data.status);
            $('#tanggal_mulai').val(data.tanggal_mulai);
            $('#tanggal_selesai').val(data.tanggal_selesai);
            // Change form action to update
            $('#formPeriodeRKP').attr('action', "{{ url('admin/setting/rkp') }}/" + id);
        });
    }

    // Handle Delete Periode
    window.deletePeriode = function(id) {
        if (confirm('Apakah Anda yakin ingin menghapus periode ini?')) {
            $.ajax({
                url: "{{ url('admin/setting/rkp') }}/" + id,
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    tablePeriode.ajax.reload();
                    alert('Periode RKP berhasil dihapus');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    }
});
</script>
@endpush 