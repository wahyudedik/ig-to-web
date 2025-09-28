<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kegiatan Sekolah - Galeri Kegiatan Terbaru">
    <meta name="keywords" content="kegiatan, sekolah, galeri, instagram, aktivitas">

    <!-- title -->
    <title>Kegiatan Sekolah - Galeri Kegiatan Terbaru</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all-fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
</head>

<body>

    <!-- header area -->
    <header class="header">
        <!-- header top -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-wrap">
                    <div class="header-top-left">
                        <div class="header-top-social">
                            <span>Follow Us: </span>
                            <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ route('instagram.activities') }}" target="_blank"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                    <div class="header-top-right">
                        <div class="header-top-contact">
                            <ul>
                                <li>
                                    <a href="#" target="_blank"><i class="far fa-location-dot"></i> Jl. Pendidikan
                                        No. 123, Jakarta</a>
                                </li>
                                <li>
                                    <a href="mailto:info@sekolahdigital.com" target="_blank"><i
                                            class="far fa-envelopes"></i> info@sekolahdigital.com</a>
                                </li>
                                <li>
                                    <a href="tel:+62123456789" target="_blank"><i class="far fa-phone-volume"></i> +62
                                        123 456 789</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-navigation">
            <nav class="navbar navbar-expand-lg">
                <div class="container position-relative">
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo">
                    </a>
                    <div class="mobile-menu-right">
                        <div class="search-btn">
                            <button type="button" class="nav-right-link search-box-outer"><i
                                    class="far fa-search"></i></button>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-mobile-icon"><i class="far fa-bars"></i></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="main_nav">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">PROFIL</a>
                                <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item" href="{{ route('pages.index') }}">HALAMAN</a></li>
                                    <li><a class="dropdown-item" href="{{ route('instagram.activities') }}">GALERI</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('siswa.index') }}">DATA SISWA</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"
                                    data-bs-toggle="dropdown">AKADEMIK</a>
                                <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item" href="{{ route('guru.index') }}">TENAGA PENDIDIK</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('pages.index') }}">KURIKULUM</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('instagram.activities') }}">KEGIATAN</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">LAYANAN
                                    DIGITAL</a>
                                <ul class="dropdown-menu fade-down">
                                    @php
                                        $user = Auth::user();
                                        $siswa = $user ? \App\Models\Siswa::where('user_id', $user->id)->first() : null;
                                        $isGrade12 = $siswa && str_contains($siswa->kelas, 'XII');
                                    @endphp
                                    @if ($isGrade12)
                                        <li><a class="dropdown-item" href="{{ route('kelulusan.check') }}">🎓
                                                E-LULUS</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('osis.voting') }}">🗳️ E-OSIS</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('sarpras.index') }}">🏢 E-SARPRAS</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('instagram.activities') }}">📸
                                            E-GALERI</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link active"
                                    href="{{ route('instagram.activities') }}">KEGIATAN</a></li>
                        </ul>
                        <div class="nav-right">
                            <div class="nav-right-btn mt-2">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="theme-btn"><span
                                                class="fal fa-user"></span> DASHBOARD</a>
                                    @else
                                        <a href="{{ route('login') }}" class="theme-btn"><span
                                                class="fal fa-sign-in"></span> LOGIN</a>
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- header area end -->

    <!-- popup search -->
    <div class="search-popup">
        <button class="close-search"><span class="far fa-times"></span></button>
        <form action="#">
            <div class="form-group">
                <input type="search" name="search-field" placeholder="Search Here..." required>
                <button type="submit"><i class="far fa-search"></i></button>
            </div>
        </form>
    </div>
    <!-- popup search end -->

    <main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background: url({{ asset('assets/img/breadcrumb/01.jpg') }})">
            <div class="container">
                <h2 class="breadcrumb-title">Kegiatan Sekolah</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="/">Home</a></li>
                    <li class="active">Kegiatan</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Success Message -->
        @if (session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Instagram Activities Section -->
        <div class="campus-tour pt-120 pb-80">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <h2 class="site-title">
                                    KEGIATAN SEKOLAH
                                </h2>
                            </div>
                            <p class="content-text">
                                Dokumentasi kegiatan dan aktivitas sekolah yang terintegrasi dengan Instagram.
                                Semua momen berharga, prestasi siswa, dan kegiatan pembelajaran dapat dilihat
                                secara real-time melalui galeri digital ini.
                            </p>
                            <p class="content-text mt-2">
                                Platform ini memungkinkan orang tua, siswa, dan masyarakat untuk mengikuti
                                perkembangan kegiatan sekolah secara langsung dan transparan.
                            </p>
                            <div class="mt-4">
                                <button id="refreshBtn" class="theme-btn">
                                    <i class="fas fa-sync-alt mr-2"></i>
                                    <span id="refreshText">Perbarui Data</span>
                                </button>
                                <div class="mt-2 text-sm text-muted">
                                    <i class="fas fa-clock mr-1"></i>
                                    Terakhir diperbarui: <span
                                        id="lastUpdated">{{ now()->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-img wow fadeInRight" data-wow-delay=".25s">
                            <img src="{{ asset('assets/img/campus-tour/01.jpg') }}" alt="Kegiatan Sekolah">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Instagram Activities Section end -->

        <!-- Instagram Feed Gallery -->
        <div class="campus-life pt-120 pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="site-heading text-center mb-5">
                            <h2 class="site-title">Galeri Kegiatan Terbaru</h2>
                            <p class="site-subtitle">Update kegiatan sekolah dari Instagram</p>
                        </div>
                    </div>
                </div>

                <!-- Loading State -->
                <div id="loadingState" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">Memuat data Instagram...</p>
                </div>

                <!-- Posts Grid -->
                <div id="postsContainer" class="row">
                    @forelse ($posts as $index => $post)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ $post['media_url'] }}" class="card-img-top" alt="Kegiatan Sekolah"
                                        style="height: 250px; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <a href="{{ $post['permalink'] }}" target="_blank"
                                            class="btn btn-sm btn-dark">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <p class="card-text flex-grow-1">
                                        {{ Str::limit($post['caption'], 150) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <span class="badge bg-danger">
                                                <i class="fas fa-heart"></i> {{ number_format($post['like_count']) }}
                                            </span>
                                            <span class="badge bg-primary ms-1">
                                                <i class="fas fa-comment"></i>
                                                {{ number_format($post['comment_count']) }}
                                            </span>
                                        </div>
                                        <small class="text-muted">
                                            {{ $post['timestamp']->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ $post['permalink'] }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fab fa-instagram me-1"></i> Lihat di Instagram
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fab fa-instagram fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum ada kegiatan</h4>
                                <p class="text-muted">Kegiatan sekolah akan muncul di sini setelah terhubung dengan
                                    Instagram</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- Instagram Feed Gallery end -->

    </main>

    <!-- footer area -->
    <footer class="footer-area">
        <div class="footer-shape">
            <img src="{{ asset('assets/img/shape/03.png') }}" alt="">
        </div>
        <div class="footer-widget">
            <div class="container">
                <div class="row footer-widget-wrapper pt-100 pb-70">
                    <div class="col-md-6 col-lg-4">
                        <div class="footer-widget-box about-us">
                            <a href="/" class="footer-logo">
                                <img src="{{ asset('assets/img/logo/logo-light.png') }}" alt="">
                            </a>
                            <p class="mb-3">
                                Portal Digital Pendidikan yang mengintegrasikan semua layanan sekolah
                                dalam satu platform modern dan terpadu.
                            </p>
                            <ul class="footer-contact">
                                <li><a href="#"><i class="fab fa-whatsapp"></i>+62 123 456 789</a></li>
                                <li><i class="far fa-map-marker-alt"></i>Jl. Pendidikan No. 123, Jakarta</li>
                                <li><a href="mailto:info@sekolahdigital.com"><i
                                            class="far fa-envelope"></i>info@sekolahdigital.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Link Terkait</h4>
                            <ul class="footer-list">
                                <li><a href="{{ route('pages.index') }}"><i class="fas fa-caret-right"></i>
                                        Halaman</a></li>
                                <li><a href="{{ route('guru.index') }}"><i class="fas fa-caret-right"></i> Tenaga
                                        Pendidik</a></li>
                                <li><a href="{{ route('siswa.index') }}"><i class="fas fa-caret-right"></i> Data
                                        Siswa</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Layanan Digital</h4>
                            <ul class="footer-list">
                                <li><a href="{{ route('kelulusan.check') }}"><i class="fas fa-caret-right"></i>
                                        E-Lulus</a></li>
                                <li><a href="{{ route('osis.voting') }}"><i class="fas fa-caret-right"></i>
                                        E-OSIS</a></li>
                                <li><a href="{{ route('sarpras.index') }}"><i class="fas fa-caret-right"></i>
                                        E-Sarpras</a></li>
                                <li><a href="{{ route('instagram.activities') }}"><i class="fas fa-caret-right"></i>
                                        E-Galeri</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Slogan Kami</h4>
                            <div class="footer-newsletter">
                                <p>Pendidikan Digital, Masa Depan Cerah</p>
                                <div class="subscribe-form">
                                    <form action="{{ route('instagram.activities') }}">
                                        <button class="theme-btn" type="submit">
                                            LIHAT KEGIATAN <i class="far fa-camera"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="copyright-wrapper">
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <p class="copyright-text">
                                &copy; Copyright <span id="date"></span> <a href="#">Website Sekolah</a>
                                All Rights Reserved.
                            </p>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <ul class="footer-social">
                                <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="{{ route('instagram.activities') }}" target="_blank"><i
                                            class="fab fa-instagram"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->

    <!-- scroll-top -->
    <a href="#" id="scroll-top"><i class="far fa-arrow-up-from-arc"></i></a>
    <!-- scroll-top end -->

    <!-- js -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter-up.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Custom JavaScript for Instagram Activities -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const refreshBtn = document.getElementById('refreshBtn');
            const refreshText = document.getElementById('refreshText');
            const loadingState = document.getElementById('loadingState');
            const postsContainer = document.getElementById('postsContainer');
            const lastUpdated = document.getElementById('lastUpdated');

            // Refresh button functionality
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    // Show loading state
                    refreshBtn.disabled = true;
                    refreshText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui...';

                    if (loadingState) {
                        loadingState.style.display = 'block';
                    }

                    // Fetch new data
                    fetch('/kegiatan/posts')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update last updated time
                                if (lastUpdated) {
                                    lastUpdated.textContent = new Date().toLocaleString('id-ID', {
                                        day: 'numeric',
                                        month: 'short',
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });
                                }

                                // Show success message
                                showNotification('Data berhasil diperbarui!', 'success');

                                // Reload page to show new data
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Gagal memperbarui data', 'error');
                        })
                        .finally(() => {
                            // Reset button state
                            refreshBtn.disabled = false;
                            refreshText.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Perbarui Data';

                            if (loadingState) {
                                loadingState.style.display = 'none';
                            }
                        });
                });
            }

            // Notification function
            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className =
                    `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 5000);
            }

            // Auto refresh every 30 minutes
            setInterval(() => {
                fetch('/kegiatan/posts')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && lastUpdated) {
                            lastUpdated.textContent = new Date().toLocaleString('id-ID', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }
                    })
                    .catch(error => console.error('Auto refresh error:', error));
            }, 30 * 60 * 1000); // 30 minutes
        });
    </script>

</body>

</html>
