<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Uangmu, Raih Mimpimu - [Nama Aplikasi]</title>
    <link rel="stylesheet" href="{{ asset('css/LandingPage.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <header class="navbar">
        <div class="container">
            <h1 class="logo">Finansa</h1>
            <nav class="nav-links" id="navLinks">
                <a href="#fitur">Fitur</a>
                <a href="#harga">Guide Book</a>
                @auth
                 <a href="/dashboard" class="cta-button">Dashboard</a>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="cta-button">Masuk</a>
                @endguest
            </nav>
            <div class="menu-toggle" id="mobileMenu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </header>

    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h2>Kelola Keuangan Jadi Mudah</h2>
                <p>Catat, analisis, dan kontrol pengeluaran Anda dengan mudah. Mulai kelola finansial Anda hari ini!</p>
                <a href="/login" class="cta-primary">Coba Sekarang</a>
            </div>
            <div class="hero-image">
                <img src="{{ asset('foto/logo-finansa.png') }}" alt="Aplikasi Manajemen Keuangan"
                    class="responsive-hero-img">
            </div>
        </div>
    </section>

    <section class="slider-section" id="fitur">
        <div class="container">
            <h3>Lihat Bagaimana Kami Memudahkan Anda</h3>
            <div class="slider-wrapper">
                <div class="slider" id="appSlider">
                    <img src="{{ asset('foto/foto1.png') }}" alt="Tampilan Catatan Transaksi" class="slide">
                    <img src="{{ asset('foto/foto2.png') }}" alt="Tampilan Grafik Pengeluaran" class="slide">
                    <img src="{{ asset('foto/foto3.png') }}" alt="Tampilan Pengaturan Anggaran" class="slide">
                </div>
                <button class="prev-btn">◀</button>
                <button class="next-btn">▶</button>
                <div class="dots-container" id="sliderDots"></div>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <h3 class="section-title">Fitur Terbaik untuk Kontrol Penuh</h3>
            <div class="feature-grid">
                <div class="feature-card">
                    <h4>Pencatatan Praktis</h4>
                    <p>Catat pengeluaran hanya dalam hitungan detik. Lupakan struk yang tercecer dan lupa mencatat.</p>
                </div>
                <div class="feature-card">
                    <h4>Anggaran Cerdas</h4>
                    <p>Buat anggaran untuk setiap kategori dan dapatkan notifikasi *real-time* jika hampir melebihi
                        batas.</p>
                </div>
                <div class="feature-card">
                    <h4>Laporan Visual</h4>
                    <p>Lihat kondisi keuangan Anda dalam bentuk grafik dan diagram yang mudah dipahami.</p>
                </div>
                <div class="feature-card">
                    <h4>Aman & Terenkripsi</h4>
                    <p>Data keuangan Anda dilindungi dengan enkripsi terbaik. Keamanan adalah prioritas kami.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2025 Finansa. Kelola Uangmu, Atur Hidupmu</p>
        </div>
    </footer>

    <script src="{{ asset('js/LandingPage.js') }}"></script>
</body>

</html>