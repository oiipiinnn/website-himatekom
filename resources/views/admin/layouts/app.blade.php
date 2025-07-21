<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Himatekom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
        }

        .sidebar .nav-link {
            color: #fff;
            padding: 15px 20px;
            border-bottom: 1px solid #495057;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: #495057;
            color: #fff;
        }

        .sidebar .nav-link.active {
            background: #006738;
            color: #fff;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        .main-content {
            padding: 20px;
        }

        .navbar-brand {
            font-weight: bold;
            color: #006738 !important;
        }

        .pending-badge {
            background: #ffc107;
            color: #000;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 11px;
            font-weight: bold;
            margin-left: 5px;
        }

        .sidebar-section {
            padding: 15px 20px 5px;
            color: #adb5bd;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            border-bottom: 1px solid #495057;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h5 class="text-white">Admin Panel</h5>
                        <small class="text-muted">Himatekom UNAND</small>
                    </div>

                    <ul class="nav flex-column">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>

                        <!-- Organization Section -->
                        <li class="sidebar-section">Organisasi</li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.divisions.*') ? 'active' : '' }}"
                                href="{{ route('admin.divisions.index') }}">
                                <i class="fas fa-users-cog"></i> Divisi
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}"
                                href="{{ route('admin.members.index') }}">
                                <i class="fas fa-users"></i> Pengurus
                            </a>
                        </li>

                        <!-- Student Data Section -->
                        <li class="sidebar-section">Data Mahasiswa</li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"
                                href="{{ route('admin.students.index') }}">
                                <i class="fas fa-graduation-cap"></i> Data Mahasiswa
                                @php
                                    $pendingStudents = \App\Models\Student::pending()->count();
                                @endphp
                                @if ($pendingStudents > 0)
                                    <span class="pending-badge">{{ $pendingStudents }}</span>
                                @endif
                            </a>
                        </li>

                        <!-- Content Section -->
                        <li class="sidebar-section">Konten</li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
                                href="{{ route('admin.posts.index') }}">
                                <i class="fas fa-blog"></i> Blog Posts
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}"
                                href="{{ route('admin.galleries.index') }}">
                                <i class="fas fa-images"></i> Gallery
                            </a>
                        </li>

                        <!-- Communication Section -->
                        <li class="sidebar-section">Komunikasi</li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.aspirations.*') ? 'active' : '' }}"
                                href="{{ route('admin.aspirations.index') }}">
                                <i class="fas fa-comments"></i> Aspirasi
                                @php
                                    $pendingAspirations = \App\Models\Aspiration::where('status', 'pending')->count();
                                @endphp
                                @if ($pendingAspirations > 0)
                                    <span class="pending-badge">{{ $pendingAspirations }}</span>
                                @endif
                            </a>
                        </li>

                        <!-- Settings Section -->
                        <li class="sidebar-section">Pengaturan</li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}"
                                href="{{ route('admin.about.index') }}">
                                <i class="fas fa-info-circle"></i> About Settings
                            </a>
                        </li>

                        <hr class="text-white">

                        <!-- External Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                <i class="fas fa-external-link-alt"></i> Lihat Website
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('students.index') }}" target="_blank">
                                <i class="fas fa-graduation-cap"></i> Data Mahasiswa (Public)
                            </a>
                        </li>

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            @yield('page-actions')
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle"></i> {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="main-content">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
