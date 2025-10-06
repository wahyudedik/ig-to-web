<?php
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
?>

<!-- hero slider -->
<div class="hero-section">
    <div class="hero-slider owl-carousel owl-theme">
        <?php if($heroImages && count($heroImages) > 0): ?>
            
            <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="hero-single" style="background: url(<?php echo e(Storage::url($image)); ?>)">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-lg-7">
                                <div class="hero-content">
                                    <h6 class="hero-sub-title" data-animation="fadeInDown" data-delay=".25s">
                                        <i
                                            class="far fa-book-open-reader"></i><?php echo e(cache('site_setting_site_name', 'Portal Digital Pendidikan')); ?>

                                    </h6>
                                    <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                        <?php echo e($heroTitle); ?>

                                    </h1>
                                    <p data-animation="fadeInLeft" data-delay=".75s">
                                        <?php echo e($heroSubtitle); ?>

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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            
            <?php $__currentLoopData = $defaultImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="hero-single" style="background: url(<?php echo e($image); ?>)">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-lg-7">
                                <div class="hero-content">
                                    <h6 class="hero-sub-title" data-animation="fadeInDown" data-delay=".25s">
                                        <i
                                            class="far fa-book-open-reader"></i><?php echo e(cache('site_setting_site_name', 'Portal Digital Pendidikan')); ?>

                                    </h6>
                                    <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                        <?php echo e($heroTitle); ?>

                                    </h1>
                                    <p data-animation="fadeInLeft" data-delay=".75s">
                                        <?php echo e($heroSubtitle); ?>

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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>
<!-- hero slider end -->
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/components/hero-carousel.blade.php ENDPATH**/ ?>