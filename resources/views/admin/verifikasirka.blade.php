@extends('layouts.admin')

@section('title', 'Verifikasi RKA')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid p-0">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Verifikasi RKA</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Verifikasi RKA</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filter Data</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.verifikasi.rka') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">OPD</label>
                                <select class="form-select" name="pd_id">
                                    <option value="">Semua OPD</option>
                                    @foreach($pd as $item)
                                        <option value="{{ $item->id }}" {{ request('pd_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_dinas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="verifikasi" {{ request('status') == 'verifikasi' ? 'selected' : '' }}>Proses Verifikasi</option>
                                    <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block w-100">
                                    <i class="fas fa-filter me-2"></i>Filter Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- RKA List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Daftar RKA</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table-rka">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>OPD</th>
                                        <th>Urusan</th>
                                        <th>Bidang Urusan</th>
                                        <th>Program</th>
                                        <th>Kegiatan</th>
                                        <th>Sub Kegiatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rka as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->pd->nama_dinas }}</td>
                                        <td>{{ $item->urusan->nama_urusan }}</td>
                                        <td>{{ $item->bidangUrusan->nama_bidang_urusan }}</td>
                                        <td>{{ $item->program->nama_program }}</td>
                                        <td>{{ $item->kegiatan->nama_kegiatan }}</td>
                                        <td>{{ $item->subKegiatan->nama_sub_kegiatan }}</td>
                                        <td>
                                            <span class="badge {{ 
                                                $item->status === 'draft' ? 'bg-secondary' :
                                                ($item->status === 'verifikasi' ? 'bg-primary' :
                                                ($item->status === 'revisi' ? 'bg-warning' : 'bg-success'))
                                            }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success" onclick="verifikasiRka({{ $item->id }})">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#revisiModal{{ $item->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Detail Modal -->
                                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail RKA</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <h6>Informasi Umum</h6>
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th width="30%">OPD</th>
                                                                <td>{{ $item->pd->nama_dinas }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Urusan</th>
                                                                <td>{{ $item->urusan->nama_urusan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Bidang Urusan</th>
                                                                <td>{{ $item->bidangUrusan->nama_bidang_urusan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Program</th>
                                                                <td>{{ $item->program->nama_program }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Kegiatan</th>
                                                                <td>{{ $item->kegiatan->nama_kegiatan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Sub Kegiatan</th>
                                                                <td>{{ $item->subKegiatan->nama_sub_kegiatan }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Revisi Modal -->
                                    <div class="modal fade" id="revisiModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Revisi RKA</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.verifikasi.rka.revisi', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Catatan Revisi</label>
                                                            <textarea class="form-control" name="catatan_revisi" rows="4" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Kirim Revisi</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data RKA</td>
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
</div>

@push('styles')
<style>
/* Custom styles untuk menghindari tumpang tindih */
.container-fluid {
    padding-top: 20px;
}

.card {
    margin-bottom: 20px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.table th {
    background-color: #f8f9fa;
}

/* Style untuk modal */
.modal-content {
    border: none;
    border-radius: 0.5rem;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

/* Style untuk button */
.btn {
    border-radius: 0.25rem;
}

/* Style untuk form controls */
.form-control, .form-select {
    border-radius: 0.25rem;
}

/* Style untuk badges */
.badge {
    padding: 0.5em 0.75em;
    border-radius: 0.25rem;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable with responsive feature
    $('#table-rka').DataTable({
        responsive: true,
        pageLength: 10,
        ordering: true,
        scrollX: true, // Enable horizontal scrolling
        fixedHeader: true, // Keep header visible when scrolling
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        initComplete: function() {
            // Adjust column widths after table is loaded
            $(window).trigger('resize');
        }
    });

    // Handle window resize
    $(window).resize(function() {
        $('#table-rka').DataTable().columns.adjust();
    });
});

function verifikasiRka(id) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin memverifikasi RKA ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Verifikasi',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/verifikasi/rka/${id}/approve`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    Swal.fire('Berhasil!', 'RKA berhasil diverifikasi', 'success')
                        .then(() => location.reload());
                }
            });
        }
    });
}
</script>
@endpush
@endsection 