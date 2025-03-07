@extends('layouts.opd')

@section('title', 'Input RKP')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Input RKA</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('opd.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Input RKA</li>
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

    <!-- Form Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Input RKA</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('opd.rkp.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Program -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pilih RKP<span class="text-danger">*</span></label>
                                <select class="form-select @error('kode_program') is-invalid @enderror" name="kode_program" id="kodeProgram" required>
                                    <option value="">Pilih RKP</option>
                                </select>
                                @error('kode_program')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- SSH Search -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Cari SSH</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="sshSearch" placeholder="Masukkan kata kunci SSH...">
                                    <button class="btn btn-primary" type="button" id="searchSshBtn">
                                        <i class="fas fa-search me-2"></i>Cari
                                    </button>
                                </div>
                            </div>

                            <!-- SSH Table -->
                            <div class="col-12 mb-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="sshTable">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Spesifikasi</th>
                                                <th>Satuan</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- SSH data will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Selected SSH -->
                            <div class="col-12 mb-3">
                                <label class="form-label">SSH Terpilih</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="selectedSshTable">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Spesifikasi</th>
                                                <th>Satuan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Selected SSH items will be added here -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" class="text-end">Total Pagu Anggaran:</th>
                                                <th id="totalPaguAnggaran">Rp 0</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        <div class="text-end mt-3">
                            <button type="reset" class="btn btn-secondary me-2">
                                <i class="fas fa-times me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan RKP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- RKP Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar RKP</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="rkpTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program</th>
                                    <th>Kegiatan</th>
                                    <th>Indikator</th>
                                    <th>Target</th>
                                    <th>Satuan</th>
                                    <th>Pagu Anggaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rkp_data ?? [] as $index => $rkp)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $rkp->program->nama_program }}</td>
                                    <td>{{ $rkp->kegiatan->nama_kegiatan }}</td>
                                    <td>{{ $rkp->indikator }}</td>
                                    <td>{{ $rkp->target }}</td>
                                    <td>{{ $rkp->satuan }}</td>
                                    <td>Rp {{ number_format($rkp->pagu_anggaran, 0, ',', '.') }}</td>
                                    <td>
                                        @if($rkp->status == 'draft')
                                            <span class="badge bg-warning">Draft</span>
                                        @elseif($rkp->status == 'submitted')
                                            <span class="badge bg-info">Submitted</span>
                                        @elseif($rkp->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($rkp->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('opd.rkp.edit', $rkp->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('opd.rkp.destroy', $rkp->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data</td>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    .form-label {
        font-weight: 500;
    }
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
    }
    .card-header {
        background-color: #1a237e;  
        border-bottom: 1px solid #e9ecef;
    }
    .input-group-text {
        background-color: #e9ecef;
    }
    .btn i {
        font-size: 0.875rem;
    }
    .table th {
        background-color: #f8f9fa;
        vertical-align: middle;
    }
    .btn-group {
        gap: 5px;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.25em 0.5em;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#rkpTable').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    $('#sshTable').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    // Load Program
    $.get("{{ route('admin.master.program.list') }}", function(response) {
        try {
            const select = $('#kodeProgram');
            select.empty();
            select.append('<option value="">Pilih Program</option>');
            
            if (Array.isArray(response)) {
                response.forEach(function(item) {
                    select.append(`<option value="${item.kode}">${item.kode} - ${item.nama_program}</option>`);
                });
            } else {
                console.error('Data program bukan array:', response);
            }
        } catch (error) {
            console.error('Error loading program:', error);
        }
    }).fail(function(xhr, status, error) {
        console.error('Failed to load program:', error);
    });

    // Load Kegiatan when Program is selected
    $('#kodeProgram').on('change', function() {
        const kodeProgram = $(this).val();
        const kegiatanSelect = $('#kodeKegiatan');
        
        if (kodeProgram) {
            kegiatanSelect.prop('disabled', false);
            $.get("{{ route('admin.master.kegiatan.list') }}?kode_program=" + kodeProgram, function(response) {
                try {
                    kegiatanSelect.empty();
                    kegiatanSelect.append('<option value="">Pilih Kegiatan</option>');
                    
                    if (Array.isArray(response)) {
                        response.forEach(function(item) {
                            kegiatanSelect.append(`<option value="${item.kode}">${item.kode} - ${item.nama_kegiatan}</option>`);
                        });
                    } else {
                        console.error('Data kegiatan bukan array:', response);
                    }
                } catch (error) {
                    console.error('Error loading kegiatan:', error);
                }
            }).fail(function(xhr, status, error) {
                console.error('Failed to load kegiatan:', error);
            });
        } else {
            kegiatanSelect.prop('disabled', true);
            kegiatanSelect.empty();
            kegiatanSelect.append('<option value="">Pilih Kegiatan</option>');
        }
    });

    // SSH Search
    $('#searchSshBtn').on('click', function() {
        const keyword = $('#sshSearch').val();
        $.get("{{ route('opd.ssh.search') }}", { keyword: keyword }, function(response) {
            const table = $('#sshTable').DataTable();
            table.clear();
            
            if (Array.isArray(response)) {
                response.forEach(function(item) {
                    table.row.add([
                        item.kode,
                        item.nama,
                        item.spesifikasi,
                        item.satuan,
                        'Rp ' + new Intl.NumberFormat('id-ID').format(item.harga),
                        `<button type="button" class="btn btn-sm btn-primary pilih-ssh" data-ssh='${JSON.stringify(item)}'>
                            <i class="fas fa-plus"></i> Pilih
                        </button>`
                    ]).draw(false);
                });
            }
        }).fail(function(xhr, status, error) {
            console.error('Failed to search SSH:', error);
        });
    });

    // Handle SSH selection
    $(document).on('click', '.pilih-ssh', function() {
        const ssh = JSON.parse($(this).data('ssh'));
        const table = $('#selectedSshTable tbody');
        
        const row = `
            <tr data-ssh-id="${ssh.id}">
                <td>${ssh.kode}</td>
                <td>${ssh.nama}</td>
                <td>${ssh.spesifikasi}</td>
                <td>${ssh.satuan}</td>
                <td>Rp ${new Intl.NumberFormat('id-ID').format(ssh.harga)}</td>
                <td>
                    <input type="number" class="form-control form-control-sm ssh-quantity" value="1" min="1">
                </td>
                <td>Rp ${new Intl.NumberFormat('id-ID').format(ssh.harga)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger hapus-ssh">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        table.append(row);
        updateTotalPaguAnggaran();
    });

    // Handle SSH quantity change
    $(document).on('change', '.ssh-quantity', function() {
        const row = $(this).closest('tr');
        const harga = parseFloat(row.find('td:eq(4)').text().replace(/[^0-9.-]+/g, ''));
        const quantity = parseFloat($(this).val());
        const total = harga * quantity;
        row.find('td:eq(6)').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
        updateTotalPaguAnggaran();
    });

    // Handle SSH removal
    $(document).on('click', '.hapus-ssh', function() {
        $(this).closest('tr').remove();
        updateTotalPaguAnggaran();
    });

    // Update total pagu anggaran
    function updateTotalPaguAnggaran() {
        let total = 0;
        $('#selectedSshTable tbody tr').each(function() {
            const subtotal = parseFloat($(this).find('td:eq(6)').text().replace(/[^0-9.-]+/g, ''));
            total += subtotal;
        });
        $('#totalPaguAnggaran').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
        $('input[name="pagu_anggaran"]').val(total);
    }
});
</script>
@endpush 