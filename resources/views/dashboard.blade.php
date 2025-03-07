<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DBHCHT - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a237e;
            --secondary-color: #283593;
            --accent-color: #3949ab;
            --text-color: #ffffff;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: var(--text-color) !important;
            font-weight: 600;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }

        .btn-login {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            padding: 0.7rem 2rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-login:hover {
            background-color: var(--accent-color);
            color: var(--text-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .main-content {
            padding: 40px 0;
        }

        .welcome-section {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .welcome-section h3 {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .welcome-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: -150px;
            right: -150px;
        }

        .welcome-section::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 20px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin: 10px 0;
            color: var(--primary-color);
        }

        .stat-label {
            color: #666;
            font-size: 15px;
            font-weight: 500;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 20px;
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.2rem;
        }

        .activity-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
        }

        .activity-table th {
            font-weight: 600;
            color: var(--primary-color);
            background-color: rgba(0,0,0,0.02);
            padding: 15px;
            font-size: 0.95rem;
        }

        .activity-table td {
            vertical-align: middle;
            padding: 15px;
            color: #555;
        }

        .badge {
            padding: 8px 12px;
            font-weight: 500;
            border-radius: 8px;
            font-size: 0.85rem;
        }

        .bg-success {
            background: #28a745 !important;
        }

        .bg-warning {
            background: #ffc107 !important;
        }

        .bg-info {
            background: #17a2b8 !important;
        }

        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: #1a237e;
            border: none;
        }

        .nav-tabs .nav-link.active {
            color: #1a237e;
            border: none;
            border-bottom: 2px solid #1a237e;
            background: none;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .progress {
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            transition: width 0.6s ease;
        }

        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-chart-line me-2"></i>
                DBHCHT
            </a>
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h3>Selamat Datang di DBHCHT</h3>
            <p>Sistem Informasi Dana Bagi Hasil Cukai Hasil Tembakau</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon text-white">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-value">25</div>
                    <div class="stat-label">Total OPD</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon text-white">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-value">150</div>
                    <div class="stat-label">Total RKP</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon text-white">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-value">85%</div>
                    <div class="stat-label">Realisasi Anggaran</div>
                </div>
            </div>
        </div>

        <!-- Rekap Laporan -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Rekap Laporan
                </h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="rekapTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="bulanan-tab" data-bs-toggle="tab" data-bs-target="#bulanan" type="button" role="tab" aria-controls="bulanan" aria-selected="true">
                            <i class="fas fa-calendar-alt me-2"></i>Laporan Bulanan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="semester-tab" data-bs-toggle="tab" data-bs-target="#semester" type="button" role="tab" aria-controls="semester" aria-selected="false">
                            <i class="fas fa-chart-bar me-2"></i>Laporan Semester
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="rekapTabContent">
                    <!-- Tab Laporan Bulanan -->
                    <div class="tab-pane fade show active" id="bulanan" role="tabpanel" aria-labelledby="bulanan-tab">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Target</th>
                                        <th>Realisasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Januari</td>
                                        <td>Rp 250.000.000</td>
                                        <td>Rp 225.000.000</td>
                                        <td><span class="badge bg-success">Selesai</span></td>
                                    </tr>
                                    <tr>
                                        <td>Februari</td>
                                        <td>Rp 300.000.000</td>
                                        <td>Rp 285.000.000</td>
                                        <td><span class="badge bg-success">Selesai</span></td>
                                    </tr>
                                    <tr>
                                        <td>Maret</td>
                                        <td>Rp 275.000.000</td>
                                        <td>Rp 150.000.000</td>
                                        <td><span class="badge bg-warning">Proses</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Tab Laporan Semester -->
                    <div class="tab-pane fade" id="semester" role="tabpanel" aria-labelledby="semester-tab">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Semester</th>
                                        <th>Target</th>
                                        <th>Realisasi</th>
                                        <th>Capaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Semester 1</td>
                                        <td>Rp 1.500.000.000</td>
                                        <td>Rp 1.200.000.000</td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Semester 2</td>
                                        <td>Rp 1.800.000.000</td>
                                        <td>-</td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>