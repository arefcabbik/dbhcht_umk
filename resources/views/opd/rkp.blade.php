<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input RKP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Form Input RKP</h2>
        <form action="{{ route('rkp.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_program" class="form-label">Nama Program</label>
                <input type="text" class="form-control" id="nama_program" name="nama_program" required>
            </div>
            <div class="mb-3">
                <label for="anggaran" class="form-label">Anggaran</label>
                <input type="number" class="form-control" id="anggaran" name="anggaran" required>
            </div>
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>
