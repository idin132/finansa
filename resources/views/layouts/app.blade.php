<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Pencatatan Keuangan</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/1170/1170576.png">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 1rem;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            border-radius: 8px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }
        .content {
            padding: 20px;
        }
        footer {
            background-color: #fff;
            border-top: 1px solid #dee2e6;
            text-align: center;
            padding: 10px;
            margin-top: 30px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-flex flex-column">
                <h5 class="text-center text-light mb-4">💰 KeuanganKu</h5>

                <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    🗂️ Kategori
                </a>

                <div class="mt-auto mb-3 text-center">
                    <hr class="border-secondary">
                    <small class="text-secondary">v1.0 | {{ date('Y') }}</small>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-10 content">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-3">
                    <div class="container-fluid">
                        <span class="navbar-brand fw-semibold">📊 @yield('title')</span>
                        <span class="text-muted small">Pencatatan Keuangan Pribadi</span>
                    </div>
                </nav>

                <!-- Alert jika ada pesan sukses -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Konten Halaman -->
                @yield('content')

                <!-- Footer -->
                <footer>
                    &copy; {{ date('Y') }} KeuanganKu — Dibuat oleh <strong>Idin Naufal Hakim</strong>
                </footer>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
