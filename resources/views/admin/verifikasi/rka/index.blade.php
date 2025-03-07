@extends('layouts.admin')

@section('title', 'Verifikasi RKA')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h2 class="page-title mb-2">Verifikasi RKA</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Verifikasi RKA
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table RKA -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tableRka">
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
                            @foreach($rka as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->opd->nama_opd }}</td>
                                <td>{{ $item->urusan->nama_urusan }}</td>
                                <td>{{ $item->bidangUrusan->nama_bidang_urusan }}</td>
                                <td>{{ $item->program->nama_program }}</td>
                                <td>{{ $item->kegiatan->nama_kegiatan }}</td>
                                <td>{{ $item->subKegiatan->nama_sub_kegiatan }}</td>
                                <td>{!! formatStatus($item->status) !!}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" onclick="showDetail({{ $item->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($item->status == 'submitted')
                                    <button type="button" class="btn btn-sm btn-success" onclick="approve({{ $item->id }})">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="reject({{ $item->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail RKA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Detail content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tableRka').DataTable();

    // Show Detail
    window.showDetail = function(id) {
        $.get("{{ url('admin/verifikasi/rka') }}/" + id, function(response) {
            $('#modalDetail .modal-body').html(response);
            $('#modalDetail').modal('show');
        });
    }

    // Approve RKA
    window.approve = function(id) {
        if(confirm('Apakah Anda yakin ingin menyetujui RKA ini?')) {
            $.ajax({
                url: "{{ url('admin/verifikasi/rka/approve') }}/" + id,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        }
    }

    // Reject RKA
    window.reject = function(id) {
        if(confirm('Apakah Anda yakin ingin menolak RKA ini?')) {
            $.ajax({
                url: "{{ url('admin/verifikasi/rka/reject') }}/" + id,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        }
    }
});

function formatStatus(status) {
    switch(status) {
        case 'submitted':
            return '<span class="badge bg-warning">Menunggu Verifikasi</span>';
        case 'approved':
            return '<span class="badge bg-success">Disetujui</span>';
        case 'rejected':
            return '<span class="badge bg-danger">Ditolak</span>';
        default:
            return '<span class="badge bg-secondary">Draft</span>';
    }
}
</script>
@endpush

@push('styles')
<style>
/* Style untuk header section */
.page-title-box {
    padding: 1.5rem 0;
    margin-bottom: 1.5rem;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 500;
    color: var(--text-dark);
    margin: 0;
}

.page-breadcrumb .breadcrumb {
    padding: 0;
    margin: 0;
    background: transparent;
}

.page-breadcrumb .breadcrumb-item {
    font-size: 0.875rem;
}

.page-breadcrumb .breadcrumb-item a {
    color: var(--primary-color);
}

.page-breadcrumb .breadcrumb-item.active {
    color: var(--secondary-color);
}

.page-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: var(--secondary-color);
}
</style>
@endpush 