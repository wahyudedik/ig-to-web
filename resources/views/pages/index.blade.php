<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ cache('site_setting_site_description', 'Halaman Sekolah - Informasi dan Konten Sekolah') }}">
    <meta name="keywords"
        content="{{ cache('site_setting_site_keywords', 'halaman, sekolah, informasi, konten, artikel') }}">

    <!-- title -->
    <title>{{ cache('site_setting_site_name', 'Halaman Sekolah') }} - {{ config('app.name') }}</title>

    <!-- favicon -->
    @if (cache('site_setting_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ Storage::url(cache('site_setting_favicon')) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}">
    @endif

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
                                @if (cache('site_setting_contact_address'))
                                    <li>
                                        <a href="#" target="_blank"><i class="far fa-location-dot"></i>
                                            {{ cache('site_setting_contact_address') }}</a>
                                    </li>
                                @endif
                                @if (cache('site_setting_contact_email'))
                                    <li>
                                        <a href="mailto:{{ cache('site_setting_contact_email') }}" target="_blank"><i
                                                class="far fa-envelopes"></i>
                                            {{ cache('site_setting_contact_email') }}</a>
                                    </li>
                                @endif
                                @if (cache('site_setting_contact_phone'))
                                    <li>
                                        <a href="tel:{{ cache('site_setting_contact_phone') }}" target="_blank"><i
                                                class="far fa-phone-volume"></i>
                                            {{ cache('site_setting_contact_phone') }}</a>
                                    </li>
                                @endif
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
                        @if (cache('site_setting_logo'))
                            <img src="{{ Storage::url(cache('site_setting_logo')) }}"
                                alt="{{ cache('site_setting_site_name', 'MAUDU REJOSO') }}" style="max-height: 50px;">
                        @else
                            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo">
                        @endif
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
                            @foreach ($headerMenus as $menu)
                                @if ($menu->children->count() > 0)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle {{ request()->is($menu->slug) ? 'active' : '' }}"
                                            href="#" data-bs-toggle="dropdown">
                                            @if ($menu->menu_icon)
                                                <i class="{{ $menu->menu_icon }}"></i>
                                            @endif
                                            {{ $menu->menu_title }}
                                        </a>
                                        <ul class="dropdown-menu fade-down">
                                            @foreach ($menu->children as $submenu)
                                                <li>
                                                    <a class="dropdown-item" href="{{ $submenu->menu_url }}"
                                                        @if ($submenu->menu_target_blank) target="_blank" @endif>
                                                        @if ($submenu->menu_icon)
                                                            <i class="{{ $submenu->menu_icon }}"></i>
                                                        @endif
                                                        {{ $submenu->menu_title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is($menu->slug) ? 'active' : '' }}"
                                            href="{{ $menu->menu_url }}"
                                            @if ($menu->menu_target_blank) target="_blank" @endif>
                                            @if ($menu->menu_icon)
                                                <i class="{{ $menu->menu_icon }}"></i>
                                            @endif
                                            {{ $menu->menu_title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                            <!-- Fallback menu items if no custom menus are configured -->
                            @if ($headerMenus->count() == 0)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle active" href="#"
                                        data-bs-toggle="dropdown">PROFIL</a>
                                    <ul class="dropdown-menu fade-down">
                                        <li><a class="dropdown-item" href="{{ route('pages.index') }}">HALAMAN</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('instagram.activities') }}">GALERI</a></li>
                                        <li><a class="dropdown-item" href="{{ route('siswa.index') }}">DATA SISWA</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#"
                                        data-bs-toggle="dropdown">AKADEMIK</a>
                                    <ul class="dropdown-menu fade-down">
                                        <li><a class="dropdown-item" href="{{ route('guru.index') }}">TENAGA
                                                PENDIDIK</a></li>
                                        <li><a class="dropdown-item" href="{{ route('pages.index') }}">KURIKULUM</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('instagram.activities') }}">KEGIATAN</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#"
                                        data-bs-toggle="dropdown">LAYANAN DIGITAL</a>
                                    <ul class="dropdown-menu fade-down">
                                        @php
                                            $user = Auth::user();
                                            $siswa = $user
                                                ? \App\Models\Siswa::where('user_id', $user->id)->first()
                                                : null;
                                            $isGrade12 = $siswa && str_contains($siswa->kelas, 'XII');
                                        @endphp
                                        @if ($isGrade12)
                                            <li><a class="dropdown-item" href="{{ route('kelulusan.check') }}">🎓
                                                    E-LULUS</a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="{{ route('osis.voting') }}">🗳️ E-OSIS</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('sarpras.index') }}">🏢
                                                E-SARPRAS</a></li>
                                        <li><a class="dropdown-item" href="{{ route('instagram.activities') }}">📸
                                                E-GALERI</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#contact">KONTAK</a></li>
                            @endif
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
                <h2 class="breadcrumb-title">Halaman Sekolah</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="/">Home</a></li>
                    <li class="active">Halaman</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Pages Info Section -->
        <div class="campus-tour pt-120 pb-80">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <h2 class="site-title">
                                    HALAMAN SEKOLAH
                                </h2>
                            </div>
                            <p class="content-text">
                                Kumpulan halaman informasi dan konten sekolah yang lengkap.
                                Temukan berbagai informasi penting, berita, pengumuman, dan
                                konten edukatif yang disediakan untuk siswa, orang tua, dan masyarakat.
                            </p>
                            <p class="content-text mt-2">
                                Semua halaman telah dikurasi dan dipublikasikan dengan standar
                                kualitas tinggi untuk memberikan pengalaman membaca yang optimal.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-img wow fadeInRight" data-wow-delay=".25s">
                            <img src="{{ asset('assets/img/campus-tour/01.jpg') }}" alt="Halaman Sekolah">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pages Info Section end -->

        <!-- Search and Filter Section -->
        <div class="campus-life pt-120 pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="site-heading text-center mb-5">
                            <h2 class="site-title">Cari Halaman</h2>
                            <p class="site-subtitle">Temukan informasi yang Anda butuhkan</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <form method="GET" class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari halaman..." class="form-control">
                            </div>
                            <div class="col-md-3">
                                <select name="category" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}"
                                            {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ ucfirst($category) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="theme-btn me-3">
                                    <i class="fas fa-search me-2"></i>Filter
                                </button>
                                <a href="{{ route('pages.index') }}" class="theme-btn theme-btn-2">
                                    <i class="fas fa-times me-2"></i>Clear
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search and Filter Section end -->

        <!-- Pages Grid Section -->
        <div class="campus-tour pt-120 pb-80">
            <div class="container">
                @if ($pages->count() > 0)
                    <div class="row">
                        <div class="col-12">
                            <div class="site-heading text-center mb-5">
                                <h2 class="site-title">Halaman Terbaru</h2>
                                <p class="site-subtitle">Kumpulan halaman informasi sekolah</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($pages as $page)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    @if ($page->featured_image)
                                        <img src="{{ Storage::url($page->featured_image) }}" class="card-img-top"
                                            alt="{{ $page->title }}" style="height: 250px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center"
                                            style="height: 250px; background-color: #f8f9fa;">
                                            <i class="fas fa-file-alt fa-4x text-muted"></i>
                                        </div>
                                    @endif

                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-2">
                                            @if ($page->category)
                                                <span class="badge bg-primary">{{ ucfirst($page->category) }}</span>
                                            @endif
                                            @if ($page->is_featured)
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-star me-1"></i>Featured
                                                </span>
                                            @endif
                                        </div>

                                        <h5 class="card-title">
                                            <a href="{{ route('pages.show', $page->slug) }}"
                                                class="text-decoration-none">
                                                {{ $page->title }}
                                            </a>
                                        </h5>

                                        @if ($page->excerpt)
                                            <p class="card-text flex-grow-1">{{ Str::limit($page->excerpt, 120) }}</p>
                                        @endif

                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $page->updated_at->format('M d, Y') }}
                                            </small>
                                            <a href="{{ route('pages.show', $page->slug) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($pages->hasPages())
                        <div class="row mt-5">
                            <div class="col-12">
                                <nav aria-label="Page navigation">
                                    {{ $pages->appends(request()->query())->links() }}
                                </nav>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum ada halaman</h4>
                                <p class="text-muted">
                                    @if (request()->hasAny(['search', 'category', 'status']))
                                        Coba ubah kriteria pencarian Anda.
                                    @else
                                        Belum ada halaman yang dipublikasikan.
                                    @endif
                                </p>
                                <a href="/" class="theme-btn">
                                    <i class="fas fa-home me-2"></i>Kembali ke Home
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- Pages Grid Section end -->

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
                                @if (cache('site_setting_logo'))
                                    <img src="{{ Storage::url(cache('site_setting_logo')) }}"
                                        alt="{{ cache('site_setting_site_name', 'MAUDU REJOSO') }}"
                                        style="max-height: 50px; filter: brightness(0) invert(1);">
                                @else
                                    <img src="{{ asset('assets/img/logo/logo-light.png') }}" alt="">
                                @endif
                            </a>
                            <p class="mb-3">
                                {{ cache('site_setting_site_description', 'Portal Digital Pendidikan yang mengintegrasikan semua layanan sekolah dalam satu platform modern dan terpadu.') }}
                            </p>
                            <ul class="footer-contact">
                                @if (cache('site_setting_contact_phone'))
                                    <li><a href="tel:{{ cache('site_setting_contact_phone') }}"><i
                                                class="fab fa-whatsapp"></i>{{ cache('site_setting_contact_phone') }}</a>
                                    </li>
                                @endif
                                @if (cache('site_setting_contact_address'))
                                    <li><i
                                            class="far fa-map-marker-alt"></i>{{ cache('site_setting_contact_address') }}
                                    </li>
                                @endif
                                @if (cache('site_setting_contact_email'))
                                    <li><a href="mailto:{{ cache('site_setting_contact_email') }}"><i
                                                class="far fa-envelope"></i>{{ cache('site_setting_contact_email') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!-- Dynamic Footer Menus -->
                    @if ($footerMenus->count() > 0)
                        @foreach ($footerMenus as $menu)
                            <div class="col-md-6 col-lg-2">
                                <div class="footer-widget-box list">
                                    <h4 class="footer-widget-title">{{ $menu->menu_title }}</h4>
                                    <ul class="footer-list">
                                        @if ($menu->children->count() > 0)
                                            @foreach ($menu->children as $submenu)
                                                <li>
                                                    <a href="{{ $submenu->menu_url }}"
                                                        @if ($submenu->menu_target_blank) target="_blank" @endif>
                                                        <i class="fas fa-caret-right"></i>
                                                        {{ $submenu->menu_title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li>
                                                <a href="{{ $menu->menu_url }}"
                                                    @if ($menu->menu_target_blank) target="_blank" @endif>
                                                    <i class="fas fa-caret-right"></i>
                                                    {{ $menu->menu_title }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback Footer Menus -->
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
                                    <li><a href="{{ route('instagram.activities') }}"><i
                                                class="fas fa-caret-right"></i> E-Galeri</a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Slogan Kami</h4>
                            <div class="footer-newsletter">
                                <p>Pendidikan Digital, Masa Depan Cerah</p>
                                <div class="subscribe-form">
                                    <form action="{{ route('pages.index') }}">
                                        <button class="theme-btn" type="submit">
                                            LIHAT HALAMAN <i class="far fa-file-alt"></i>
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

</body>

</html>
