@extends('layouts.opd')

@section('title', 'Input RKA')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Input RKP</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('opd.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Input RKP</li>
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
                    <h5 class="card-title mb-0">Form Input RKP</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('opd.rka.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Urusan -->
            
                            </div>

                            <!-- Bidang Urusan -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bidang Urusan <span class="text-danger">*</span></label>
                                <select class="form-select @error('kode_bidang_urusan') is-invalid @enderror" name="kode_bidang_urusan" id="kodeBidangUrusan" >
                                    <option value="">Pilih Bidang Urusan</option>
                                </select>
                                @error('kode_bidang_urusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Program -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Program <span class="text-danger">*</span></label>
                                <select class="form-select @error('kode_program') is-invalid @enderror" name="kode_program" id="kodeProgram" >
                                    <option value="">Pilih Program</option>
                                </select>
                                @error('kode_program')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kegiatan -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kegiatan <span class="text-danger">*</span></label>
                                <select class="form-select @error('kode_kegiatan') is-invalid @enderror" name="kode_kegiatan" id="kodeKegiatan" >
                                    <option value="">Pilih Kegiatan</option>
                                </select>
                                @error('kode_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sub Kegiatan -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Sub Kegiatan <span class="text-danger">*</span></label>
                                <select class="form-select @error('kode_sub_kegiatan') is-invalid @enderror" name="kode_sub_kegiatan" id="kodeSubKegiatan" >
                                    <option value="">Pilih Sub Kegiatan</option>
                                </select>
                                @error('kode_sub_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Indikator -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Indikator Kegiatan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('indikator') is-invalid @enderror" name="indikator" rows="3" required>{{ old('indikator') }}</textarea>
                                @error('indikator')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Target dan Satuan -->
                            <div class="col-md-6 mb-3">
                            </div>

                        
                        </div>

                        <div class="text-end mt-3">
                            <a href="{{ route('opd.dashboard') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan RKA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Table RKA -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data RKA</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bidang Urusan</th>
                                    <th>Program</th>
                                    <th>Kegiatan</th>
                                    <th>Sub Kegiatan</th>
                                    <th>Indikator</th>
                                    <th>Satuan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rka_data ?? [] as $index => $rka)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $rka->bidang_urusan }}</td>
                                    <td>{{ $rka->program }}</td>
                                    <td>{{ $rka->kegiatan }}</td>
                                    <td>{{ $rka->sub_kegiatan }}</td>
                                    <td>{{ $rka->indikator }}</td>
                                    <td>{{ $rka->satuan }}</td>
                                    <td>{{ $rka->status }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('opd.rka.edit', $rka->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('opd.rka.destroy', $rka->id) }}" method="POST" class="d-inline">
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
                                    <td colspan="12" class="text-center">Tidak ada data</td>
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
        background-color: #1a237e;
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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Load Urusan
    $.get("{{ route('admin.master.urusan.list') }}", function(response) {
        try {
            const select = $('#kodeUrusan');
            select.empty();
            select.append('<option value="">Pilih Urusan</option>');
            
            if (Array.isArray(response)) {
                response.forEach(function(item) {
                    select.append(`<option value="${item.kode}">${item.kode} - ${item.nama_urusan}</option>`);
                });
            } else {
                console.error('Data urusan bukan array:', response);
            }
        } catch (error) {
            console.error('Error loading urusan:', error);
        }
    }).fail(function(xhr, status, error) {
        console.error('Failed to load urusan:', error);
    });

    // Load Bidang Urusan when Urusan is selected
    $('#kodeUrusan').on('change', function() {
        const kodeUrusan = $(this).val();
        const bidangUrusanSelect = $('#kodeBidangUrusan');
        const programSelect = $('#kodeProgram');
        const kegiatanSelect = $('#kodeKegiatan');
        const subKegiatanSelect = $('#kodeSubKegiatan');
        
        if (kodeUrusan) {
            bidangUrusanSelect.prop('disabled', false);
            $.get("{{ url('admin/master/program/bidang-urusan') }}/" + kodeUrusan, function(response) {
                try {
                    bidangUrusanSelect.empty();
                    bidangUrusanSelect.append('<option value="">Pilih Bidang Urusan</option>');
                    
                    if (Array.isArray(response)) {
                        response.forEach(function(item) {
                            bidangUrusanSelect.append(`<option value="${item.kode}">${item.kode} - ${item.nama_bidang_urusan}</option>`);
                        });
                    } else {
                        console.error('Data bidang urusan bukan array:', response);
                    }
                } catch (error) {
                    console.error('Error loading bidang urusan:', error);
                }
            }).fail(function(xhr, status, error) {
                console.error('Failed to load bidang urusan:', error);
            });
        } else {
            bidangUrusanSelect.prop('disabled', true);
            bidangUrusanSelect.empty();
            bidangUrusanSelect.append('<option value="">Pilih Bidang Urusan</option>');
            programSelect.prop('disabled', true);
            programSelect.empty();
            programSelect.append('<option value="">Pilih Program</option>');
            kegiatanSelect.prop('disabled', true);
            kegiatanSelect.empty();
            kegiatanSelect.append('<option value="">Pilih Kegiatan</option>');
            subKegiatanSelect.prop('disabled', true);
            subKegiatanSelect.empty();
            subKegiatanSelect.append('<option value="">Pilih Sub Kegiatan</option>');
        }
    });

    // Load Program when Bidang Urusan is selected
    $('#kodeBidangUrusan').on('change', function() {
        const kodeBidangUrusan = $(this).val();
        const programSelect = $('#kodeProgram');
        const kegiatanSelect = $('#kodeKegiatan');
        const subKegiatanSelect = $('#kodeSubKegiatan');
        
        if (kodeBidangUrusan) {
            programSelect.prop('disabled', false);
            $.get("{{ route('admin.master.program.list') }}?kode_bidang_urusan=" + kodeBidangUrusan, function(response) {
                try {
                    programSelect.empty();
                    programSelect.append('<option value="">Pilih Program</option>');
                    
                    if (Array.isArray(response)) {
                        response.forEach(function(item) {
                            programSelect.append(`<option value="${item.kode}">${item.kode} - ${item.nama_program}</option>`);
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
        } else {
            programSelect.prop('disabled', true);
            programSelect.empty();
            programSelect.append('<option value="">Pilih Program</option>');
            kegiatanSelect.prop('disabled', true);
            kegiatanSelect.empty();
            kegiatanSelect.append('<option value="">Pilih Kegiatan</option>');
            subKegiatanSelect.prop('disabled', true);
            subKegiatanSelect.empty();
            subKegiatanSelect.append('<option value="">Pilih Sub Kegiatan</option>');
        }
    });

    // Load Kegiatan when Program is selected
    $('#kodeProgram').on('change', function() {
        const kodeProgram = $(this).val();
        const kegiatanSelect = $('#kodeKegiatan');
        const subKegiatanSelect = $('#kodeSubKegiatan');
        
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
            subKegiatanSelect.prop('disabled', true);
            subKegiatanSelect.empty();
            subKegiatanSelect.append('<option value="">Pilih Sub Kegiatan</option>');
        }
    });

    // Load Sub Kegiatan when Kegiatan is selected
    $('#kodeKegiatan').on('change', function() {
        const kodeKegiatan = $(this).val();
        const subKegiatanSelect = $('#kodeSubKegiatan');
        
        if (kodeKegiatan) {
            subKegiatanSelect.prop('disabled', false);
            $.get("{{ route('admin.master.sub-kegiatan.list') }}?kode_kegiatan=" + kodeKegiatan, function(response) {
                try {
                    subKegiatanSelect.empty();
                    subKegiatanSelect.append('<option value="">Pilih Sub Kegiatan</option>');
                    
                    if (Array.isArray(response)) {
                        response.forEach(function(item) {
                            subKegiatanSelect.append(`<option value="${item.kode}">${item.kode} - ${item.nama_sub_kegiatan}</option>`);
                        });
                    } else {
                        console.error('Data sub kegiatan bukan array:', response);
                    }
                } catch (error) {
                    console.error('Error loading sub kegiatan:', error);
                }
            }).fail(function(xhr, status, error) {
                console.error('Failed to load sub kegiatan:', error);
            });
        } else {
            subKegiatanSelect.prop('disabled', true);
            subKegiatanSelect.empty();
            subKegiatanSelect.append('<option value="">Pilih Sub Kegiatan</option>');
        }
    });

    // Format Pagu Anggaran
    $('input[name="pagu_anggaran"]').on('input', function() {
        let value = $(this).val();
        value = value.replace(/\D/g, '');
        $(this).val(value);
    });
});
</script>
@endpush 