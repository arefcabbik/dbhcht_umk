@extends('layouts.admin')

@section('title', 'Master Data - Kesejahteraan Masyarakat')

@section('content')
<div class="container-fluid">
    <!-- Navigation Buttons -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('admin.master.dana-master') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $title }}</h5>
                    <div class="card-tools">

                    </div>
                </div>
                <div class="card-body">
                    <!-- Tabel dana -->

                    <form action="{{route('admin.master.dana-master.store')}}" method="POST" onsubmit="return confirmSubmit(event)">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_dana" class="form-label">Tahun</label>
                            <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">-- Pilih Tahun --</option>
                                @for ($i = date('Y')-3; $i <= date('Y')+2; $i++)
                                    <option value="{{ $i }}"  {{ old('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                            </select>
                            @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Dana</label>
                            <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal') }}">
                            @error('nominal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmSubmit(event) {
        event.preventDefault(); // Mencegah form terkirim langsung

        Swal.fire({
            title: "Simpan data ?",
            text: "Data akan disimoan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit(); // Kirim form jika dikonfirmasi
            }
        });

        return false; // Mencegah pengiriman form sebelum konfirmasi
    }
</script>
@endpush
