@extends('layouts.opd')

@section('title', 'RKA Manual')

@section('content')
<div class="row mb-2">
    <div>
        <h4 class="mb-0">RKA Manual</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('opd.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">RKA Manual</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Form RKA Manual</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('opd.rka.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Program</label>
                        <select class="form-select" name="program_id" required>
                            <option value="">Pilih Program</option>
                            <!-- Options will be populated via AJAX -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kegiatan</label>
                        <select class="form-select" name="kegiatan_id" required disabled>
                            <option value="">Pilih Kegiatan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sub Kegiatan</label>
                        <select class="form-select" name="sub_kegiatan_id" required disabled>
                            <option value="">Pilih Sub Kegiatan</option>
                        </select>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sumber Dana</label>
                        <select class="form-select" name="sumber_dana" required>
                            <option value="">Pilih Sumber Dana</option>
                            <option value="DBHCHT">DBHCHT</option>
                            <option value="DAU">DAU</option>
                            <option value="DAK">DAK</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai Anggaran</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="nilai_anggaran" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <!-- Rincian Belanja -->
            <div class="mt-4">
                <h5>Rincian Belanja</h5>
                <div id="rincian-container">
                    <div class="rincian-item border rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Komponen</label>
                                    <select class="form-select" name="rincian[0][komponen]" required>
                                        <option value="">Pilih Komponen</option>
                                        <option value="Belanja Pegawai">Belanja Pegawai</option>
                                        <option value="Belanja Barang">Belanja Barang</option>
                                        <option value="Belanja Modal">Belanja Modal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Item</label>
                                    <input type="text" class="form-control" name="rincian[0][item]" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Nilai</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="rincian[0][nilai]" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" id="tambah-rincian">
                    <i class="fas fa-plus me-2"></i>Tambah Rincian
                </button>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan RKA
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Program Change
    document.querySelector('select[name="program_id"]').addEventListener('change', function() {
        const kegiatanSelect = document.querySelector('select[name="kegiatan_id"]');
        if (this.value) {
            // Enable and populate kegiatan dropdown
            kegiatanSelect.disabled = false;
            // Add AJAX call here to populate kegiatan options
        } else {
            kegiatanSelect.disabled = true;
        }
    });

    // Handle Kegiatan Change
    document.querySelector('select[name="kegiatan_id"]').addEventListener('change', function() {
        const subKegiatanSelect = document.querySelector('select[name="sub_kegiatan_id"]');
        if (this.value) {
            // Enable and populate sub kegiatan dropdown
            subKegiatanSelect.disabled = false;
            // Add AJAX call here to populate sub kegiatan options
        } else {
            subKegiatanSelect.disabled = true;
        }
    });

    // Handle Tambah Rincian
    document.getElementById('tambah-rincian').addEventListener('click', function() {
        const container = document.getElementById('rincian-container');
        const count = container.children.length;
        
        const template = `
            <div class="rincian-item border rounded p-3 mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Komponen</label>
                            <select class="form-select" name="rincian[${count}][komponen]" required>
                                <option value="">Pilih Komponen</option>
                                <option value="Belanja Pegawai">Belanja Pegawai</option>
                                <option value="Belanja Barang">Belanja Barang</option>
                                <option value="Belanja Modal">Belanja Modal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Item</label>
                            <input type="text" class="form-control" name="rincian[${count}][item]" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nilai</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="rincian[${count}][nilai]" required>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2 hapus-rincian">
                    <i class="fas fa-trash me-2"></i>Hapus
                </button>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', template);
    });

    // Handle Hapus Rincian
    document.addEventListener('click', function(e) {
        if (e.target.closest('.hapus-rincian')) {
            e.target.closest('.rincian-item').remove();
        }
    });
});
</script>
@endpush 