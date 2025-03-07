@extends('layouts.admin')

@section('title', 'Dashboard Admin Perekonomian')

@section('content')
<!-- Welcome Section -->
<div class="welcome-section">
    <h3>Selamat Datang di Dashboard Admin Perekonomian</h3>
    <p>Kelola dan monitor aktivitas DBHCHT dengan mudah</p>
</div>

<div class="dashboard-header">
    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary text-white">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">150</div>
                <div class="stat-label">Total Pengguna</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success text-white">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">45</div>
                <div class="stat-label">RKP Terverifikasi</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning text-white">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">12</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-info text-white">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-value">89</div>
                <div class="stat-label">Total RKP</div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity Card -->
    <div class="card mt-4">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover activity-table mb-0">
                    <thead>
                        <tr>
                            <th>Aktivitas</th>
                            <th>Pengguna</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Verifikasi RKP</td>
                            <td>Dinas Kesehatan</td>
                            <td><span class="badge bg-success">Selesai</span></td>
                            <td>2 jam yang lalu</td>
                        </tr>
                        <tr>
                            <td>Input RKA</td>
                            <td>Dinas Pendidikan</td>
                            <td><span class="badge bg-warning">Menunggu</span></td>
                            <td>3 jam yang lalu</td>
                        </tr>
                        <tr>
                            <td>Update RKP</td>
                            <td>Dinas Sosial</td>
                            <td><span class="badge bg-info">Diproses</span></td>
                            <td>5 jam yang lalu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
