<!DOCTYPE html>
<html>

<head>
    <title>Admin - Rental System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            overflow-x: hidden;
            background: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #212529;
            position: fixed;
            width: 240px;
            display: flex;
            flex-direction: column;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 12px 20px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #343a40;
            color: #fff;
        }

        .sidebar a.active {
            background: #0d6efd;
            color: #fff;
        }

        .content {
            margin-left: 240px;
            padding: 30px;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4 class="text-white text-center py-3 border-bottom">
            <i class="bi bi-shield-lock"></i> Admin Panel
        </h4>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <a href="{{ route('equipment.index') }}" class="{{ request()->routeIs('equipment.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam me-2"></i> Equipment
        </a>

        <a href="{{ route('admin.rentals.index') }}"
            class="{{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}">
            <i class="bi bi-receipt me-2"></i> Rental
        </a>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="content">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-x-circle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
