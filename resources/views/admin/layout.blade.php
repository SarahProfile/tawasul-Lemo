<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Tawasul Limo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            color: white;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: #495057;
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: #495057;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .btn-primary {
            background-color: #212529;
            border-color: #212529;
        }
        .btn-primary:hover {
            background-color: #495057;
            border-color: #495057;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="px-3 py-2 text-center border-bottom">
                        <h5 class="mb-0">Tawasul Limo Admin</h5>
                    </div>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check me-2"></i>
                                Bookings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="fas fa-users me-2"></i>
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                                <i class="fas fa-envelope me-2"></i>
                                Contact Messages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.locations.index') }}" class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Contact Locations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.content.index') }}" class="nav-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                                <i class="fas fa-edit me-2"></i>
                                Page Content
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.careers.index') }}" class="nav-link {{ request()->routeIs('admin.careers.*') ? 'active' : '' }}">
                                <i class="fas fa-briefcase me-2"></i>
                                Career Positions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="fas fa-home me-2"></i>
                                Back to Site
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link text-start w-100 text-light">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('page-actions')
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>