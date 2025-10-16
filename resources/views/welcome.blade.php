<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ cache('site_setting_site_description', 'Portal Digital Pendidikan - Website Sekolah Terintegrasi') }}">
    <meta name="keywords"
        content="{{ cache('site_setting_site_keywords', 'sekolah, pendidikan, digital, portal, e-learning, e-osis, e-lulus, sarpras') }}">

    <!-- title -->
    <title>{{ cache('site_setting_site_name', 'Website Sekolah - Portal Digital Pendidikan') }}</title>

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
                            @if (cache('site_setting_social_facebook'))
                                <a href="{{ cache('site_setting_social_facebook') }}" target="_blank"><i
                                        class="fab fa-facebook-f"></i></a>
                            @else
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            @endif

                            @if (cache('site_setting_social_instagram'))
                                <a href="{{ cache('site_setting_social_instagram') }}" target="_blank"><i
                                        class="fab fa-instagram"></i></a>
                            @else
                                <a href="{{ route('public.instagram') }}" target="_blank"><i
                                        class="fab fa-instagram"></i></a>
                            @endif

                            @if (cache('site_setting_social_youtube'))
                                <a href="{{ cache('site_setting_social_youtube') }}" target="_blank"><i
                                        class="fab fa-youtube"></i></a>
                            @else
                                <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                            @endif

                            @if (cache('site_setting_social_whatsapp'))
                                <a href="{{ cache('site_setting_social_whatsapp') }}" target="_blank"><i
                                        class="fab fa-whatsapp"></i></a>
                            @else
                                <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="header-top-right">
                        <div class="header-top-contact">
                            <ul>
                                <li>
                                    @if (cache('site_setting_contact_address'))
                                        <a href="#" target="_blank"><i class="far fa-location-dot"></i>
                                            {{ cache('site_setting_contact_address') }}</a>
                                    @else
                                        <a href="#" target="_blank"><i class="far fa-location-dot"></i> Jl.
                                            Pendidikan No. 123, Jakarta</a>
                                    @endif
                                </li>
                                <li>
                                    @if (cache('site_setting_contact_email'))
                                        <a href="mailto:{{ cache('site_setting_contact_email') }}" target="_blank"><i
                                                class="far fa-envelopes"></i>
                                            {{ cache('site_setting_contact_email') }}</a>
                                    @else
                                        <a href="mailto:info@sekolahdigital.com" target="_blank"><i
                                                class="far fa-envelopes"></i> info@sekolahdigital.com</a>
                                    @endif
                                </li>
                                <li>
                                    @if (cache('site_setting_contact_phone'))
                                        <a href="tel:{{ cache('site_setting_contact_phone') }}" target="_blank"><i
                                                class="far fa-phone-volume"></i>
                                            {{ cache('site_setting_contact_phone') }}</a>
                                    @else
                                        <a href="tel:+62123456789" target="_blank"><i class="far fa-phone-volume"></i>
                                            +62 123 456 789</a>
                                    @endif
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
                                        <li><a class="dropdown-item"
                                                href="{{ route('pages.public.index') }}">HALAMAN</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('public.instagram') }}">GALERI</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('pages.public.show', 'data-siswa') }}">DATA SISWA</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#"
                                        data-bs-toggle="dropdown">AKADEMIK</a>
                                    <ul class="dropdown-menu fade-down">
                                        <li><a class="dropdown-item"
                                                href="{{ route('pages.public.show', 'tenaga-pendidik') }}">TENAGA
                                                PENDIDIK</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('pages.public.show', 'kurikulum') }}">KURIKULUM</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('public.instagram') }}">KEGIATAN</a></li>
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
                                            <li><a class="dropdown-item"
                                                    href="{{ route('public.graduation.check') }}">🎓
                                                    E-LULUS</a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="{{ route('public.instagram') }}">🗳️
                                                E-OSIS</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('public.instagram') }}">🏢
                                                E-SARPRAS</a></li>
                                        <li><a class="dropdown-item" href="{{ route('public.instagram') }}">📸
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
                                        <a href="{{ route('admin.dashboard') }}" class="theme-btn"><span
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

        <!-- hero carousel -->
        @include('components.hero-carousel')
        <!-- hero carousel end -->

        <!-- feature area -->
        <div class="feature-area fa-negative">
            <div class="col-xl-9 ms-auto">
                <div class="feature-wrapper">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <span class="count">01</span>
                                <div class="feature-icon">
                                    <img src="{{ asset('assets/img/icon/library.svg') }}" alt="">
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title"><a href="{{ route('pages.public.index') }}">E-PAGES</a>
                                    </h4>
                                    <p>Sistem manajemen konten untuk membuat halaman informasi sekolah</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <span class="count">02</span>
                                <div class="feature-icon">
                                    <img src="{{ asset('assets/img/icon/teacher-2.svg') }}" alt="">
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title"><a
                                            href="{{ route('pages.public.show', 'tenaga-pendidik') }}">TENAGA
                                            PENDIDIK</a>
                                    </h4>
                                    <p>Database lengkap informasi guru dan tenaga kependidikan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <span class="count">03</span>
                                <div class="feature-icon">
                                    <img src="{{ asset('assets/img/icon/course.svg') }}" alt="">
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title"><a href="{{ route('public.instagram') }}">E-GALERI</a>
                                    </h4>
                                    <p>Integrasi dengan Instagram sekolah untuk menampilkan kegiatan terbaru</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <span class="count">04</span>
                                <div class="feature-icon">
                                    <img src="{{ asset('assets/img/icon/graduation.svg') }}" alt="">
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title"><a
                                            href="{{ route('pages.public.show', 'data-siswa') }}">DATA SISWA</a>
                                    </h4>
                                    <p>Manajemen data siswa aktif dan alumni dengan informasi lengkap</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- feature area end -->

        <!-- campus life -->
        <div class="campus-life pt-120 pb-80">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="content-img wow fadeInLeft" data-wow-delay=".25s">
                            @if (cache('site_setting_headmaster_photo'))
                                <img src="{{ Storage::url(cache('site_setting_headmaster_photo')) }}"
                                    alt="Foto Kepala Sekolah">
                            @else
                                <img src="{{ asset('assets/img/campus-life/01.jpg') }}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <h4 class="site-title">
                                    Kepala Madrasah <span>:
                                        {{ cache('site_setting_headmaster_name', 'Khoiruddinul Qoyyum,S.S.,M.Pd') }}</span>
                                </h4>
                            </div>
                            <p class="content-text">
                                {{ cache('site_setting_headmaster_description', 'Sebagai kepala madrasah yang berpengalaman, kami berkomitmen untuk memberikan pendidikan terbaik bagi para siswa dengan mengintegrasikan nilai-nilai keislaman dan pengetahuan modern.') }}
                            </p>
                            <p class="content-text mt-2">
                                {{ cache('site_setting_headmaster_vision', 'Visi kami adalah menciptakan generasi yang unggul dalam akademik, berakhlak mulia, dan siap menghadapi tantangan masa depan dengan bekal ilmu pengetahuan yang komprehensif.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- campus life end-->

        <!-- video-area -->
        <div class="video-area py-120">
            <div class="container">
                <div class="video-content"
                    style="background-image: url({{ cache('site_setting_video_thumbnail') ? Storage::url(cache('site_setting_video_thumbnail')) : asset('assets/img/video/01.jpg') }});">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="video-wrapper">
                                <a class="play-btn popup-youtube"
                                    href="{{ cache('site_setting_video_url', 'https://www.youtube.com/watch?v=ckHzmP1evNU') }}">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- video-area end -->

        <!-- about area -->
        <div class="about-area py-120">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                            <div class="about-img">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        @if (cache('site_setting_about_image_1'))
                                            <img class="img-1"
                                                src="{{ Storage::url(cache('site_setting_about_image_1')) }}"
                                                alt="About Image 1">
                                        @else
                                            <img class="img-1" src="{{ asset('assets/img/about/01.jpg') }}"
                                                alt="">
                                        @endif
                                        <div class="about-experience mt-4">
                                            <div class="about-experience-icon">
                                                <img src="{{ asset('assets/img/icon/monitor.svg') }}" alt="">
                                            </div>
                                            <b class="text-start">Galeri Kegiatan<br> Sekolah Digital</b>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if (cache('site_setting_about_image_2'))
                                            <img class="img-2"
                                                src="{{ Storage::url(cache('site_setting_about_image_2')) }}"
                                                alt="About Image 2">
                                        @else
                                            <img class="img-2" src="{{ asset('assets/img/about/02.jpg') }}"
                                                alt="">
                                        @endif
                                        @if (cache('site_setting_about_image_3'))
                                            <img class="img-3 mt-4"
                                                src="{{ Storage::url(cache('site_setting_about_image_3')) }}"
                                                alt="About Image 3">
                                        @else
                                            <img class="img-3 mt-4" src="{{ asset('assets/img/about/03.jpg') }}"
                                                alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline"><i class="far fa-book-open-reader"></i>
                                    {{ cache('site_setting_about_section_subtitle', 'TENTANG KAMI') }}</span>
                                <h2 class="site-title">
                                    {{ cache('site_setting_about_section_title', 'Portal Digital <span>Pendidikan</span> Terintegrasi') }}
                                </h2>
                            </div>
                            <p class="about-text">
                                {{ cache('site_setting_about_section_description', 'Website sekolah yang mengintegrasikan semua layanan pendidikan dalam satu platform digital yang modern dan efisien. Memudahkan akses informasi dan layanan untuk seluruh civitas akademika.') }}
                            </p>
                            <div class="about-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="about-item">
                                            <div class="about-item-icon">
                                                <img src="{{ asset('assets/img/icon/information.svg') }}"
                                                    alt="">
                                            </div>
                                            <div class="about-item-content">
                                                <h5>{{ cache('site_setting_about_feature_1_title', 'SISTEM E-OSIS') }}
                                                </h5>
                                                <p>{{ cache('site_setting_about_feature_1_description', 'Pemilihan OSIS digital dengan monitoring real-time dan sistem voting yang aman') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="about-item">
                                            <div class="about-item-icon">
                                                <img src="{{ asset('assets/img/icon/global-education.svg') }}"
                                                    alt="">
                                            </div>
                                            <div class="about-item-content">
                                                <h5>{{ cache('site_setting_about_feature_2_title', 'SISTEM E-LULUS') }}
                                                </h5>
                                                <p>{{ cache('site_setting_about_feature_2_description', 'Pengumuman kelulusan dengan verifikasi NISN/NIS yang akurat dan real-time') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="about-item">
                                            <div class="about-item-icon">
                                                <img src="{{ asset('assets/img/icon/open-book.svg') }}"
                                                    alt="">
                                            </div>
                                            <div class="about-item-content">
                                                <h5>{{ cache('site_setting_about_feature_3_title', 'MANAJEMEN SARPRAS') }}
                                                </h5>
                                                <p>{{ cache('site_setting_about_feature_3_description', 'Sistem inventaris sarana dan prasarana sekolah dengan barcode tracking') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="about-item">
                                            <div class="about-item-icon">
                                                <img src="{{ asset('assets/img/icon/location.svg') }}"
                                                    alt="">
                                            </div>
                                            <div class="about-item-content">
                                                <h5>{{ cache('site_setting_about_feature_4_title', 'INTEGRASI INSTAGRAM') }}
                                                </h5>
                                                <p>{{ cache('site_setting_about_feature_4_description', 'Sinkronisasi otomatis dengan Instagram sekolah untuk galeri kegiatan terbaru') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="about-bottom">
                                <a href="#features"
                                    class="theme-btn">{{ cache('site_setting_about_button_text', 'JELAJAHI FITUR') }}<i
                                        class="fas fa-arrow-right-long"></i></a>
                                <div class="about-phone">
                                    <div class="icon"><i class="fal fa-headset"></i></div>
                                    <div class="number">
                                        <span>{{ cache('site_setting_about_contact_text', 'HUBUNGI KAMI') }}</span>
                                        <h6><a
                                                href="tel:{{ cache('site_setting_about_contact_phone', '+62 123 456 789') }}">{{ cache('site_setting_about_contact_phone', '+62 123 456 789') }}</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->

        <!-- counter area -->
        <div class="counter-area pt-60 pb-60">
            <div class="container">
                <div class="row">
                    @php
                        // Ambil data statistik dari database dengan error handling
                        try {
                            $totalGuru = \App\Models\Guru::count();
                        } catch (Exception $e) {
                            $totalGuru = 0;
                        }

                        try {
                            $totalSiswa = \App\Models\Siswa::count();
                        } catch (Exception $e) {
                            $totalSiswa = 0;
                        }

                        try {
                            $totalPages = \App\Models\Page::where('status', 'published')->count();
                        } catch (Exception $e) {
                            $totalPages = 0;
                        }

                        try {
                            $totalSarpras = \App\Models\Barang::count();
                        } catch (Exception $e) {
                            $totalSarpras = 0;
                        }
                    @endphp

                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="{{ asset('assets/img/icon/teacher-2.svg') }}" alt="">
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="{{ $totalGuru }}"
                                    data-speed="3000">{{ $totalGuru }}</span>
                                <h6 class="title">+ Tenaga Pendidik</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="{{ asset('assets/img/icon/graduation.svg') }}" alt="">
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="{{ $totalSiswa }}"
                                    data-speed="3000">{{ $totalSiswa }}</span>
                                <h6 class="title">+ Siswa Aktif</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="{{ asset('assets/img/icon/course.svg') }}" alt="">
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="{{ $totalPages }}"
                                    data-speed="3000">{{ $totalPages }}</span>
                                <h6 class="title">+ Halaman Informasi</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="{{ asset('assets/img/icon/award.svg') }}" alt="">
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="{{ $totalSarpras }}"
                                    data-speed="3000">{{ $totalSarpras }}</span>
                                <h6 class="title">+ Item Sarpras</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- counter area end -->

        <!-- choose-area -->
        <div class="choose-area pt-80 pb-80">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="choose-content wow fadeInUp" data-wow-delay=".25s">
                            <div class="choose-content-info">
                                <div class="site-heading mb-0">
                                    <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Program
                                        Peminatan</span>
                                    <h2 class="site-title text-white mb-10">
                                        {{ cache('site_setting_program_section_title', '3 Program Peminatan') }}</h2>
                                </div>
                                <div class="choose-content-wrap">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="choose-item">
                                                <div class="choose-item-icon">
                                                    <img src="{{ asset('assets/img/icon/course.svg') }}"
                                                        alt="">
                                                </div>
                                                <div class="choose-item-info">
                                                    <h4>{{ cache('site_setting_program_ipa_title', 'PEMINATAN ILMU PENGETAHUAN ALAM (IPA)') }}
                                                    </h4>
                                                    <p>{{ cache('site_setting_program_ipa_description', 'Menyiapkan peserta didik yang handal dalam kajian ilmiah dan alamiah dengan berlandaskan kepada ayat-ayat qauliyah dan kauniyah.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="choose-item">
                                                <div class="choose-item-icon">
                                                    <img src="{{ asset('assets/img/icon/course.svg') }}"
                                                        alt="">
                                                </div>
                                                <div class="choose-item-info">
                                                    <h4>{{ cache('site_setting_program_ips_title', 'PEMINATAN ILMU PENGETAHUAN SOSIAL (IPS)') }}
                                                    </h4>
                                                    <p>{{ cache('site_setting_program_ips_description', 'Menyiapkan peserta didik yang dapat menguasai ilmu-ilmu sosial secara terpadu antara keislaman dan pengetahuan sehingga menjadi insan yang sosialis-agamis.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="choose-item">
                                                <div class="choose-item-icon">
                                                    <img src="{{ asset('assets/img/icon/course.svg') }}"
                                                        alt="">
                                                </div>
                                                <div class="choose-item-info">
                                                    <h4>{{ cache('site_setting_program_religion_title', 'PEMINATAN KEAGAMAAN') }}
                                                    </h4>
                                                    <p>{{ cache('site_setting_program_religion_description', 'Menyiapkan peserta didik yang lebih mampu menguasai ilmu-ilmu agama dengan mengkaji sumber aslinya serta mengkolaborasikan dengan perkembangan IPTEK.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="choose-img wow fadeInRight" data-wow-delay=".25s">
                            @if (cache('site_setting_program_section_image'))
                                <img src="{{ Storage::url(cache('site_setting_program_section_image')) }}"
                                    alt="Program Peminatan">
                            @else
                                <img src="{{ asset('assets/img/choose/01.jpg') }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- choose-area end -->

        <!-- portfolio-area -->
        <div class="portfolio-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Galeri
                                Kegiatan</span>
                            <h2 class="site-title">Kegiatan<span> Sekolah</span> Terbaru</h2>
                            <p>Galeri kegiatan sekolah yang diambil langsung dari Instagram resmi</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        // Ambil data Instagram posts dari database
                        $instagramPosts = \App\Models\InstagramSetting::where('is_active', true)
                            ->orderBy('created_at', 'desc')
                            ->limit(6)
                            ->get()
                            ->map(function ($post) {
                                return [
                                    'image' => $post->image_url ?: asset('assets/img/portfolio/01.jpg'),
                                    'title' => $post->caption ?: 'Kegiatan Sekolah',
                                    'category' => $post->category ?: 'Kegiatan',
                                    'url' => $post->post_url ?: '#',
                                ];
                            })
                            ->toArray();

                        // Jika tidak ada data Instagram, gunakan dummy data
                        if (empty($instagramPosts)) {
                            $instagramPosts = [
                                [
                                    'image' => asset('assets/img/portfolio/01.jpg'),
                                    'title' => 'Kegiatan Pembelajaran',
                                    'category' => 'Akademik',
                                    'url' => '#',
                                ],
                                [
                                    'image' => asset('assets/img/portfolio/02.jpg'),
                                    'title' => 'Ekstrakurikuler',
                                    'category' => 'Kegiatan',
                                    'url' => '#',
                                ],
                                [
                                    'image' => asset('assets/img/portfolio/03.jpg'),
                                    'title' => 'Upacara Bendera',
                                    'category' => 'Kegiatan',
                                    'url' => '#',
                                ],
                                [
                                    'image' => asset('assets/img/portfolio/04.jpg'),
                                    'title' => 'Lomba Sains',
                                    'category' => 'Prestasi',
                                    'url' => '#',
                                ],
                                [
                                    'image' => asset('assets/img/portfolio/05.jpg'),
                                    'title' => 'Kegiatan Olahraga',
                                    'category' => 'Olahraga',
                                    'url' => '#',
                                ],
                                [
                                    'image' => asset('assets/img/portfolio/06.jpg'),
                                    'title' => 'Acara Sekolah',
                                    'category' => 'Event',
                                    'url' => '#',
                                ],
                            ];
                        }
                    @endphp

                    @foreach ($instagramPosts as $post)
                        <div class="col-md-4">
                            <div class="portfolio-item">
                                <div class="portfolio-img">
                                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}">
                                </div>
                                <div class="portfolio-content">
                                    <div class="portfolio-info">
                                        <div class="portfolio-title-info">
                                            <h5 class="portfolio-subtitle"><span>//</span> {{ $post['category'] }}
                                            </h5>
                                            <a href="{{ $post['url'] }}" target="_blank">
                                                <h4 class="portfolio-title">{{ $post['title'] }}</h4>
                                            </a>
                                        </div>
                                        <a href="{{ $post['url'] }}" target="_blank" class="portfolio-btn"><i
                                                class="far fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- portfolio-area end -->

        <!-- testimonial area -->
        <div class="testimonial-area ts-bg pt-80 pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-book-open-reader"></i>
                                Testimonials</span>
                            <h2 class="site-title text-white">Apa Kata<span> Alumni ?</span></h2>
                            <p class="text-white">Alumni kuliah di dalam Negeri dan di luar Negeri</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slider owl-carousel owl-theme">
                    @php
                        // Ambil testimonial dari database atau gunakan dummy data
                        $testimonials = \App\Models\Testimonial::approved()->featured()->latest()->limit(6)->get();

                        // Jika tidak ada testimonial di database, gunakan dummy data
                        if ($testimonials->isEmpty()) {
                            $testimonials = collect(\App\Models\Testimonial::getDummyTestimonials());
                        }
                    @endphp

                    @foreach ($testimonials as $testimonial)
                        <div class="testimonial-item">
                            <div class="testimonial-rate">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $testimonial['rating'] ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            <div class="testimonial-quote">
                                <p>{{ $testimonial['testimonial'] }}</p>
                            </div>
                            <div class="testimonial-content">
                                <div class="testimonial-author-img">
                                    <img src="{{ $testimonial['photo'] }}" alt="{{ $testimonial['name'] }}">
                                </div>
                                <div class="testimonial-author-info">
                                    <h4>{{ $testimonial['name'] }}</h4>
                                    <p>
                                        @if ($testimonial['position'] === 'Alumni')
                                            Alumni {{ $testimonial['graduation_year'] }}
                                        @elseif ($testimonial['position'] === 'Siswa')
                                            {{ $testimonial['class'] }}
                                        @else
                                            {{ $testimonial['position'] }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <span class="testimonial-quote-icon"><i class="far fa-quote-right"></i></span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- testimonial area end -->

    </main>

    <!-- footer area -->
    <footer class="footer-area" id="contact">
        <div class="footer-shape">
            <img src="{{ asset('assets/img/shape/03.png') }}" alt="">
        </div>
        <div class="footer-widget">
            <div class="container">
                <div class="row footer-widget-wrapper pt-100 pb-70">
                    <div class="col-md-6 col-lg-4">
                        <div class="footer-widget-box about-us">
                            <a href="#" class="footer-logo">
                                @if (cache('site_setting_logo'))
                                    <img src="{{ Storage::url(cache('site_setting_logo')) }}"
                                        alt="{{ cache('site_setting_site_name', 'MAUDU REJOSO') }}"
                                        style="max-height: 50px; filter: brightness(0) invert(1);">
                                @else
                                    <img src="{{ asset('assets/img/logo/logo-light.png') }}" alt="">
                                @endif
                            </a>
                            <p class="mb-3">
                                {{ cache('site_setting_site_description', 'Portal Digital Pendidikan yang mengintegrasikan semua layanan sekolah dalam satu platform modern dan efisien') }}
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
                                <h4 class="footer-widget-title">Menu Utama</h4>
                                <ul class="footer-list">
                                    <li><a href="{{ route('pages.public.index') }}"><i
                                                class="fas fa-caret-right"></i>
                                            Halaman</a></li>
                                    <li><a href="{{ route('pages.public.show', 'tenaga-pendidik') }}"><i
                                                class="fas fa-caret-right"></i> Tenaga
                                            Pendidik</a></li>
                                    <li><a href="{{ route('pages.public.show', 'data-siswa') }}"><i
                                                class="fas fa-caret-right"></i> Data
                                            Siswa</a></li>
                                    <li><a href="{{ route('public.instagram') }}"><i class="fas fa-caret-right"></i>
                                            Galeri</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="footer-widget-box list">
                                <h4 class="footer-widget-title">Layanan Digital</h4>
                                <ul class="footer-list">
                                    @php
                                        $user = Auth::user();
                                        $siswa = $user ? \App\Models\Siswa::where('user_id', $user->id)->first() : null;
                                        $isGrade12 = $siswa && str_contains($siswa->kelas, 'XII');
                                    @endphp
                                    @if ($isGrade12)
                                        <li><a href="{{ route('public.graduation.check') }}"><i
                                                    class="fas fa-caret-right"></i> E-Lulus</a></li>
                                    @endif
                                    <li><a href="{{ route('public.instagram') }}"><i class="fas fa-caret-right"></i>
                                            E-OSIS</a></li>
                                    <li><a href="{{ route('public.instagram') }}"><i class="fas fa-caret-right"></i>
                                            E-Sarpras</a></li>
                                    <li><a href="{{ route('public.instagram') }}"><i class="fas fa-caret-right"></i>
                                            E-Galeri</a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Akses Sistem</h4>
                            <div class="footer-newsletter">
                                <p>Login untuk mengakses semua fitur sistem</p>
                                <div class="subscribe-form">
                                    @if (Route::has('login'))
                                        @auth
                                            <a href="{{ route('admin.dashboard') }}" class="theme-btn">
                                                DASHBOARD <i class="far fa-user"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="theme-btn">
                                                LOGIN SISTEM <i class="far fa-sign-in"></i>
                                            </a>
                                        @endauth
                                    @endif
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
                                &copy; Copyright <span id="date"></span> <a
                                    href="#">{{ cache('site_setting_site_name', 'Portal Digital Pendidikan') }}</a>
                                All Rights Reserved.
                                @if (cache('site_setting_footer_text'))
                                    <br>{{ cache('site_setting_footer_text') }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <ul class="footer-social">
                                @if (cache('site_setting_social_facebook'))
                                    <li><a href="{{ cache('site_setting_social_facebook') }}" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                @else
                                    <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                @endif

                                @if (cache('site_setting_social_instagram'))
                                    <li><a href="{{ cache('site_setting_social_instagram') }}" target="_blank"><i
                                                class="fab fa-instagram"></i></a></li>
                                @else
                                    <li><a href="{{ route('public.instagram') }}" target="_blank"><i
                                                class="fab fa-instagram"></i></a></li>
                                @endif

                                @if (cache('site_setting_social_youtube'))
                                    <li><a href="{{ cache('site_setting_social_youtube') }}" target="_blank"><i
                                                class="fab fa-youtube"></i></a></li>
                                @else
                                    <li><a href="#" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                @endif

                                @if (cache('site_setting_social_whatsapp'))
                                    <li><a href="{{ cache('site_setting_social_whatsapp') }}" target="_blank"><i
                                                class="fab fa-whatsapp"></i></a></li>
                                @else
                                    <li><a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                                @endif
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

    <!-- Custom Scripts -->
    <script>
        // Update copyright year
        document.getElementById('date').innerHTML = new Date().getFullYear();

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>
