<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - DBHCHT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a237e;
            --secondary-color: #283593;
            --accent-color: #3949ab;
            --light-color: #e8eaf6;
            --hover-color: #3f51b5;
            --text-color: #ffffff;
            --text-dark: #1a237e;
            --border-color: #c5cae9;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
        }
        
        .sidebar {
            background: var(--primary-color);
            min-height: 100vh;
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 2;
        }
        
        .sidebar-logo {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }
        
        .logo-img {
            border-radius: 8px;
            padding: 4px;
            background: white;
        }
        
        .sidebar-logo-text {
            font-size: 1.4rem;
            color: white;
            letter-spacing: 1px;
        }
        
        .opd-name {
            font-size: 0.85rem;
            opacity: 0.9;
            display: block;
            white-space: normal;
            line-height: 1.2;
        }
        
        .nav-link {
            color: var(--text-color) !important;
            padding: 0.75rem 1rem;
            position: relative;
            z-index: 3;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background-color: var(--hover-color);
        }
        
        .nav-link.active {
            background-color: var(--accent-color);
            color: white !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .nav-pills .nav-link.dropdown-toggle::after {
            float: right;
            margin-top: 8px;
        }
        
        .collapse .nav-link {
            padding-left: 3rem;
            font-size: 0.95rem;
        }
        
        .mt-auto .nav-link {
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }
        
        .mt-auto button {
            width: 100%;
            text-align: left;
            padding: 0.8rem 1rem;
            color: rgba(255,255,255,0.85);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .mt-auto button:hover {
            background: var(--hover-color);
            color: white;
        }
        
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            background: #f4f6f9;
            position: relative;
            z-index: 1;
        }
        
        /* Dropdown Menu Styles */
        .dropdown-menu {
            background: var(--secondary-color);
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            padding: 8px;
            border-radius: 10px;
            margin-top: 0;
        }
        
        .dropdown-item {
            color: var(--text-color);
            padding: 10px 20px;
            border-radius: 6px;
            margin: 2px 0;
        }
        
        .dropdown-item:hover {
            background: var(--accent-color);
            color: var(--text-color);
        }

        /* Multi-level dropdown */
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -8px;
            display: none;
        }

        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }

        /* Breadcrumb Styles */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--accent-color);
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 15px 20px;
        }

        /* Icons */
        .fas {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        /* Content Wrapper */
        .content-wrapper {
            position: relative;
            z-index: 1;
            background: #fff;
            min-height: calc(100vh - 40px);
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Form Elements */
        .form-control, .form-select {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 0.5rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(57, 73, 171, 0.25);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto px-0">
                <div class="sidebar">
                    <div class="d-flex flex-column h-100">
                        <!-- Logo -->
                        <div class="sidebar-logo p-3">
                            <a href="{{ route('opd.dashboard') }}" class="d-flex align-items-center text-decoration-none">
                                <img src="{{ asset('logo_jepara.png') }}" alt="Logo" height="45" class="logo-img">
                                <div class="ms-3">
                                    <span class="d-block sidebar-logo-text fw-bold">DBHCHT</span>
                                    <small class="text-light opd-name">{{ auth()->user()->name }}</small>
                                </div>
                            </a>
                        </div>

                        <!-- Menu -->
                        <ul class="nav nav-pills flex-column mb-auto p-3">
                            <!-- Dashboard -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('opd.dashboard') ? 'active' : '' }}" 
                                   href="{{ route('opd.dashboard') }}">
                                    <i class="fas fa-home me-2"></i>
                                    Dashboard
                                </a>
                            </li>

                            <!-- Perencanaan -->
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('opd.rkp.*', 'opd.ssh.*') ? 'active' : '' }}" 
                                   href="#perencanaan" data-bs-toggle="collapse" role="button">
                                    <i class="fas fa-tasks me-2"></i>
                                    Perencanaan
                                </a>
                                <div class="collapse {{ request()->routeIs('opd.rkp.*', 'opd.ssh.*') ? 'show' : '' }}" id="perencanaan">
                                    <ul class="nav nav-pills flex-column ms-3">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('opd.ssh.*') ? 'active' : '' }}" 
                                               href="{{ route('opd.ssh.index') }}">
                                                <i class="fas fa-tags me-2"></i>SSH/SBU
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('opd.rka.input') ? 'active' : '' }}" 
                                               href="{{ route('opd.rka.input') }}">
                                                <i class="fas fa-file-invoice me-2"></i>Input RKP
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('opd.rkp.input') ? 'active' : '' }}" 
                                               href="{{ route('opd.rkp.input') }}">
                                                <i class="fas fa-edit me-2"></i>Input RKA
                                            </a>
                                        </li>
                                       
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('opd.rkp.perubahan') ? 'active' : '' }}" 
                                               href="{{ route('opd.rkp.perubahan') }}">
                                                <i class="fas fa-exchange-alt me-2"></i>Perubahan RKP
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- Menu Laporan -->
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('opd.laporan.*', 'opd.realisasi.*') ? 'active' : '' }}" 
                                   href="#laporanCollapse" data-bs-toggle="collapse" role="button">
                                    <i class="fas fa-file-alt me-2"></i>
                                    Laporan
                                </a>
                                <div class="collapse {{ request()->routeIs('opd.laporan.*', 'opd.realisasi.*') ? 'show' : '' }}" id="laporanCollapse">
                                    <ul class="nav nav-pills flex-column ms-3">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('opd.laporan.bulanan') ? 'active' : '' }}" 
                                               href="{{ route('opd.laporan.bulanan') }}">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                Laporan Bulanan
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('opd.realisasi.*') ? 'active' : '' }}" 
                                               href="{{ route('opd.realisasi.index') }}">
                                                <i class="fas fa-edit me-2"></i>
                                                Input Realisasi
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                        <!-- Profile & Logout -->
                        <div class="mt-auto p-3">
                            <!-- Profile -->
                            <a href="{{ route('opd.profile') }}" 
                               class="nav-link mb-2 {{ request()->routeIs('opd.profile') ? 'active' : '' }}">
                                <i class="fas fa-user me-2"></i>
                                Profil
                            </a>

                            <!-- Logout -->
                            <form action="{{ route('logout') }}" method="POST" class="nav-item">
                                @csrf
                                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col ps-0">
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function(){
        // Enable Bootstrap dropdowns
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl)
        });

        // Handle submenu on hover for desktop
        if (window.matchMedia('(min-width: 992px)').matches) {
            document.querySelectorAll('.dropdown-submenu').forEach(function(element){
                element.addEventListener('mouseover', function(e){
                    let nextEl = this.querySelector('.dropdown-menu');
                    if(nextEl) {
                        nextEl.style.display = 'block';
                    }
                });
                element.addEventListener('mouseout', function(e){
                    let nextEl = this.querySelector('.dropdown-menu');
                    if(nextEl) {
                        nextEl.style.display = 'none';
                    }
                });
            });
        }
    });
    </script>
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Aktifkan dropdown jika salah satu submenu aktif
        const activeLaporanSubmenu = document.querySelector('#laporanCollapse .nav-link.active');
        if (activeLaporanSubmenu) {
            const laporanCollapse = new bootstrap.Collapse(document.getElementById('laporanCollapse'), {
                toggle: false
            });
            laporanCollapse.show();
        }

        // Animasi icon saat dropdown dibuka/ditutup
        document.querySelectorAll('.nav-link.dropdown-toggle').forEach(function(element) {
            element.addEventListener('click', function() {
                const icon = this.querySelector('.fa-chevron-down');
                if (icon) {
                    if (this.getAttribute('aria-expanded') === 'true') {
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
            });
        });
    });
    </script>
    @endpush
  
</body>
</html> 