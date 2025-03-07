@extends('layouts.admin')

@section('title', 'Verifikasi RKP')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Verifikasi RKP</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Verifikasi RKP</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.verifikasi.rkp') }}" method="GET" class="row g-3">
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
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="verifikasi" {{ request('status') == 'verifikasi' ? 'selected' : '' }}>Proses Verifikasi</option>
                        <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- RKP List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>OPD</th>
                            <th>Kode</th>
                            <th>Sub Kegiatan</th>
                            <th>Target Kinerja</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rkp as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->pd->nama_dinas }}</td>
                            <td>{{ $item->kode_sub_kegiatan }}</td>
                            <td>{{ $item->sub_kegiatan }}</td>
                            <td>{{ $item->target_kinerja }}</td>
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
                                <button class="btn btn-sm btn-success" onclick="verifikasiRkp({{ $item->id }})">
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
                                        <h5 class="modal-title">Detail RKP</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Realisasi Kegiatan</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Bulan</th>
                                                        <th>Nama Kegiatan</th>
                                                        <th>Tempat</th>
                                                        <th>Peserta</th>
                                                        <th>Dokumentasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($item->realisasi as $realisasi)
                                                    <tr>
                                                        <td>{{ $realisasi->bulan }}</td>
                                                        <td>{{ $realisasi->nama_kegiatan }}</td>
                                                        <td>{{ $realisasi->tempat }}</td>
                                                        <td>{{ $realisasi->peserta }}</td>
                                                        <td>
                                                            <a href="{{ Storage::url($realisasi->dokumentasi) }}" target="_blank">
                                                                Lihat
                                                            </a>
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

                        <!-- Revisi Modal -->
                        <div class="modal fade" id="revisiModal{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Revisi RKP</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.verifikasi.rkp.revisi', $item->id) }}" method="POST">
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
                            <td colspan="7" class="text-center">Tidak ada data RKP</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function verifikasiRkp(id) {
    if (confirm('Apakah Anda yakin ingin memverifikasi RKP ini?')) {
        fetch(`/admin/verifikasi/rkp/${id}/approve`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection
