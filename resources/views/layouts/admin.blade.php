<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - DBHCHT</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            /* Tema Warna Biru */
            --primary-color: #1a237e;
            /* Biru Gelap */
            --secondary-color: #283593;
            /* Biru Medium */
            --accent-color: #3949ab;
            /* Biru Accent */
            --light-color: #e8eaf6;
            /* Biru Sangat Muda */
            --hover-color: #3f51b5;
            /* Biru Hover */
            --text-color: #ffffff;
            /* Teks Putih */
            --text-dark: #1a237e;
            /* Teks Biru Gelap */
            --border-color: #c5cae9;
            /* Border Biru Muda */
        }

        /* Modal Styles */
        .modal-backdrop {
            opacity: 0.5 !important;
        }

        .modal-content {
            background-color: #ffffff !important;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Form Controls */
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #f8f9fa !important;
            opacity: 0.8;
        }

        .form-control,
        .form-select {
            background-color: #ffffff !important;
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        /* Required Fields */
        .text-danger {
            color: #dc3545 !important;
        }

        /* OPD Fields */
        .opd-fields,
        .opd-fields-edit {
            opacity: 1 !important;
            background-color: #ffffff !important;
        }

        /* Sidebar Styles */
        .sidebar {
            background: var(--primary-color);
            color: var(--text-color);
            height: 100vh;
            position: fixed;
            left: 0;
            overflow-y: auto;
            width: 250px;
        }

        .nav-link {
            color: var(--text-color);
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 8px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--hover-color);
            color: var(--text-color);
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            background: #f4f6f9;
            position: relative;
            overflow-x: hidden;
        }

        /* Card Styles */
        .card {
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            position: relative;
            display: flex;
            flex-direction: column;
            background: #fff;
            border: none;
            border-radius: 0.5rem;
        }

        .card-header {
            background: var(--light-color);
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-color);
        }

        /* Button Styles */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--hover-color);
            border-color: var(--hover-color);
        }

        /* Table Styles */
        .table thead th {
            background: var(--light-color);
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-color);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-container">
                    <div class="text-center mb-4">
                        <h4 class="mt-2">DBHCHT</h4>
                        <p class="text-light mb-0">Admin Perekonomian</p>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home me-2"></i>
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.master.index') }}" class="nav-link {{ request()->routeIs('admin.master.*') ? 'active' : '' }}">
                                <i class="fas fa-database me-2"></i>
                                Master Data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.manajemenpengguna') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="fas fa-users me-2"></i>
                                Manajemen User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.verifikasi.rkp') }}" class="nav-link {{ request()->routeIs('admin.verifikasi.rkp') ? 'active' : '' }}">
                                <i class="fas fa-file-alt me-2"></i>
                                Verifikasi RKP
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.verifikasi.rka') }}" class="nav-link {{ request()->routeIs('admin.verifikasi.rka') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice me-2"></i>
                                Verifikasi RKA
                            </a>
                        </li>
                        <!-- Tambah Menu Setting -->
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.setting.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#settingCollapse">
                                <i class="fas fa-cog me-2"></i>
                                Setting
                                <i class="fas fa-chevron-down float-end mt-1"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('admin.setting.*') ? 'show' : '' }}" id="settingCollapse">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.setting.rkp.index') }}" class="nav-link {{ request()->routeIs('admin.setting.rkp.*') ? 'active' : '' }}">
                                            <i class="fas fa-percent me-2"></i>
                                            Presentanse Pembagian Dana DBHCHT
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('admin.setting.rkp.index') }}" class="nav-link {{ request()->routeIs('admin.setting.rkp.*') ? 'active' : '' }}">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            Setting RKP
                                        </a>
                                    </li>
                                    <!-- Tambahkan submenu setting lainnya di sini jika diperlukan -->
                                </ul>
                            </div>
                        </li>
                    </ul>

                    <!-- Logout Button -->
                    <div class="logout-button mt-auto">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Aktifkan dropdown jika salah satu submenu aktif
            const activeSubmenu = document.querySelector('#settingCollapse .nav-link.active');
            if (activeSubmenu) {
                const settingCollapse = new bootstrap.Collapse(document.getElementById('settingCollapse'), {
                    toggle: false
                });
                settingCollapse.show();
            }

            // Animasi icon saat dropdown dibuka/ditutup
            document.querySelectorAll('.nav-link.dropdown-toggle').forEach(function(element) {
                element.addEventListener('click', function() {
                    const icon = this.querySelector('.fa-chevron-down');
                    if (this.getAttribute('aria-expanded') === 'true') {
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        icon.style.transform = 'rotate(0deg)';
                    }
                });
            });
        });
    </script>
    @endpush

    @stack('scripts')

</body>

</html>