<!-- portfolio-area -->
<div class="portfolio-area py-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="site-heading text-center">
                    <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Kegiatan MAUDU</span>
                    <h2 class="site-title">Kegiatan<span> Madrasah</span></h2>
                    <p>Ket// programmer : ambil data dari dari IG</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
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
                            'title' => 'Student Health Care',
                            'category' => 'Health',
                            'url' => '#',
                        ],
                        [
                            'image' => asset('assets/img/portfolio/02.jpg'),
                            'title' => 'Student Health Care',
                            'category' => 'Health',
                            'url' => '#',
                        ],
                        [
                            'image' => asset('assets/img/portfolio/03.jpg'),
                            'title' => 'Student Health Care',
                            'category' => 'Health',
                            'url' => '#',
                        ],
                        [
                            'image' => asset('assets/img/portfolio/04.jpg'),
                            'title' => 'Student Health Care',
                            'category' => 'Health',
                            'url' => '#',
                        ],
                        [
                            'image' => asset('assets/img/portfolio/05.jpg'),
                            'title' => 'Student Health Care',
                            'category' => 'Health',
                            'url' => '#',
                        ],
                        [
                            'image' => asset('assets/img/portfolio/06.jpg'),
                            'title' => 'Student Health Care',
                            'category' => 'Health',
                            'url' => '#',
                        ],
                    ];
                }
            ?>

            <?php $__currentLoopData = $instagramPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="portfolio-item">
                        <div class="portfolio-img">
                            <img src="<?php echo e($post['image']); ?>" alt="<?php echo e($post['title']); ?>">
                        </div>
                        <div class="portfolio-content">
                            <div class="portfolio-info">
                                <div class="portfolio-title-info">
                                    <h5 class="portfolio-subtitle"><span>//</span> <?php echo e($post['category']); ?>

                                    </h5>
                                    <a href="<?php echo e($post['url']); ?>" target="_blank">
                                        <h4 class="portfolio-title"><?php echo e($post['title']); ?></h4>
                                    </a>
                                </div>
                                <a href="<?php echo e($post['url']); ?>" target="_blank" class="portfolio-btn"><i
                                        class="far fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<!-- portfolio-area end -->
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/components/landing/gallery.blade.php ENDPATH**/ ?>