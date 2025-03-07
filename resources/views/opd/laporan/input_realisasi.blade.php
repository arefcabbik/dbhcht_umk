@extends('layouts.opd')

@section('title', 'Input Realisasi')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Input Realisasi</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('opd.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('opd.realisasi.index') }}">Realisasi</a></li>
                                    <li class="breadcrumb-item active">Input Realisasi</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Realisasi -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Form Input Realisasi Anggaran
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('opd.realisasi.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Nama Program <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="program_id" class="form-select @error('program_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                                    @endforeach
                                </select>
                                @error('program_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Nama Kegiatan <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="kegiatan_id" class="form-select @error('kegiatan_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kegiatan --</option>
                                </select>
                                @error('kegiatan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Nama Sub Kegiatan <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="sub_kegiatan_id" class="form-select @error('sub_kegiatan_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Sub Kegiatan --</option>
                                </select>
                                @error('sub_kegiatan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Bulan Realisasi <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="bulan" class="form-select @error('bulan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Bulan --</option>
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
                                @error('bulan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Tahun Anggaran <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="tahun" class="form-select @error('tahun') is-invalid @enderror" required>
                                    <option value="">-- Pilih Tahun --</option>
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = 2020;
                                    @endphp
                                    @for($year = $currentYear; $year >= $startYear; $year--)
                                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Jumlah Realisasi Anggaran <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">Rp</span>
                                    <input type="number" name="realisasi_anggaran" 
                                           class="form-control @error('realisasi_anggaran') is-invalid @enderror" 
                                           placeholder="Masukkan jumlah realisasi anggaran" required>
                                </div>
                                @error('realisasi_anggaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Persentase Realisasi Fisik <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="number" name="realisasi_fisik" step="0.01" min="0" max="100"
                                           class="form-control @error('realisasi_fisik') is-invalid @enderror" 
                                           placeholder="Masukkan persentase realisasi fisik" required>
                                    <span class="input-group-text bg-primary text-white">%</span>
                                </div>
                                @error('realisasi_fisik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Masukkan angka antara 0 sampai 100</small>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Keterangan Tambahan</label>
                            <div class="col-sm-9">
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="3" placeholder="Masukkan keterangan tambahan jika ada"></textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Data
                                </button>
                                <a href="{{ route('opd.realisasi.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

    .text-primary {
        color: #1a237e !important;
    }

    .form-label {
        font-weight: 600;
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .input-group-text {
        border: 1px solid #ced4da;
    }

    .breadcrumb-item a {
        color: #1a237e;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Ketika program dipilih
    $('select[name="program_id"]').on('change', function() {
        var programId = $(this).val();
        if(programId) {
            $.ajax({
                url: '/opd/get-kegiatan/' + programId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('select[name="kegiatan_id"]').empty();
                    $('select[name="kegiatan_id"]').append('<option value="">-- Pilih Kegiatan --</option>');
                    $.each(data, function(key, value) {
                        $('select[name="kegiatan_id"]').append('<option value="'+ value.id +'">'+ value.nama_kegiatan +'</option>');
                    });
                }
            });
        } else {
            $('select[name="kegiatan_id"]').empty();
            $('select[name="kegiatan_id"]').append('<option value="">-- Pilih Kegiatan --</option>');
        }
    });

    // Ketika kegiatan dipilih
    $('select[name="kegiatan_id"]').on('change', function() {
        var kegiatanId = $(this).val();
        if(kegiatanId) {
            $.ajax({
                url: '/opd/get-sub-kegiatan/' + kegiatanId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('select[name="sub_kegiatan_id"]').empty();
                    $('select[name="sub_kegiatan_id"]').append('<option value="">-- Pilih Sub Kegiatan --</option>');
                    $.each(data, function(key, value) {
                        $('select[name="sub_kegiatan_id"]').append('<option value="'+ value.id +'">'+ value.nama_sub_kegiatan +'</option>');
                    });
                }
            });
        } else {
            $('select[name="sub_kegiatan_id"]').empty();
            $('select[name="sub_kegiatan_id"]').append('<option value="">-- Pilih Sub Kegiatan --</option>');
        }
    });
});
</script>
@endpush
@endsection
