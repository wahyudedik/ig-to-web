@php
    $heroImages = cache('site_setting_hero_images');
    if ($heroImages) {
        $heroImages = json_decode($heroImages, true);
    }
    $heroTitle = cache('site_setting_hero_title', 'Selamat Datang di Portal Digital Pendidikan');
    $heroSubtitle = cache(
        'site_setting_hero_subtitle',
        'Website sekolah yang mengintegrasikan semua layanan pendidikan dalam satu platform digital yang modern dan efisien.',
    );

    // Default hero images jika tidak ada setting dari admin
    $defaultImages = [
        asset('assets/img/slider/slider-1.jpg'),
        asset('assets/img/slider/slider-2.jpg'),
        asset('assets/img/slider/slider-3.jpg'),
    ];
@endphp

<!-- hero slider -->
<div class="hero-section">
    <div class="hero-slider owl-carousel owl-theme">
        @if ($heroImages && count($heroImages) > 0)
            {{-- Gunakan gambar dari admin panel --}}
            @foreach ($heroImages as $index => $image)
                <div class="hero-single" style="background: url({{ Storage::url($image) }})">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-lg-7">
                                <div class="hero-content">
                                    <h6 class="hero-sub-title" data-animation="fadeInDown" data-delay=".25s">
                                        <i
                                            class="far fa-book-open-reader"></i>{{ cache('site_setting_site_name', 'Portal Digital Pendidikan') }}
                                    </h6>
                                    <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                        {{ $heroTitle }}
                                    </h1>
                                    <p data-animation="fadeInLeft" data-delay=".75s">
                                        {{ $heroSubtitle }}
                                    </p>
                                    <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                        <a href="#features" class="theme-btn">Jelajahi Fitur<i
                                                class="fas fa-arrow-right-long"></i></a>
                                        <a href="#contact" class="theme-btn theme-btn2">Hubungi Kami<i
                                                class="fas fa-arrow-right-long"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            {{-- Gunakan gambar default dari public assets --}}
            @foreach ($defaultImages as $index => $image)
                <div class="hero-single" style="background: url({{ $image }})">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-lg-7">
                                <div class="hero-content">
                                    <h6 class="hero-sub-title" data-animation="fadeInDown" data-delay=".25s">
                                        <i
                                            class="far fa-book-open-reader"></i>{{ cache('site_setting_site_name', 'Portal Digital Pendidikan') }}
                                    </h6>
                                    <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                        {{ $heroTitle }}
                                    </h1>
                                    <p data-animation="fadeInLeft" data-delay=".75s">
                                        {{ $heroSubtitle }}
                                    </p>
                                    <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                        <a href="#features" class="theme-btn">Jelajahi Fitur<i
                                                class="fas fa-arrow-right-long"></i></a>
                                        <a href="#contact" class="theme-btn theme-btn2">Hubungi Kami<i
                                                class="fas fa-arrow-right-long"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
<!-- hero slider end -->
