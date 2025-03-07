@extends('opd.layouts.app')

@section('title', 'Riwayat Perubahan RKP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Perubahan RKP</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program</th>
                                    <th>Kegiatan</th>
                                    <th>Indikator</th>
                                    <th>Target</th>
                                    <th>Satuan</th>
                                    <th>Pagu Anggaran</th>
                                    <th>Tanggal Perubahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->program->nama_program }}</td>
                                    <td>{{ $item->kegiatan->nama_kegiatan }}</td>
                                    <td>{{ $item->indikator }}</td>
                                    <td>{{ $item->target }}</td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>Rp {{ number_format($item->pagu_anggaran, 0, ',', '.') }}</td>
                                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data perubahan</td>
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

@push('scripts')
<script>
$(document).ready(function() {
    $('.table').DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>
@endpush 