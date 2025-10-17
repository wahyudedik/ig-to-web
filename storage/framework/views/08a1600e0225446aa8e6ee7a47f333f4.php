

<?php $__env->startSection('content'); ?>
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url(<?php echo e(asset('assets/img/breadcrumb/01.jpg')); ?>)">
        <div class="container">
            <h2 class="breadcrumb-title">Halaman</h2>
            <ul class="breadcrumb-menu">
                <li><a href="<?php echo e(route('landing')); ?>">Home</a></li>
                <li class="active">Halaman</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- pages area -->
    <section class="pages-area pt-120 pb-120">
        <div class="container">
            <!-- Search and Filter -->
            <div class="row mb-5">
                <div class="col-xl-12">
                    <div class="pages-search-wrapper">
                        <form action="<?php echo e(route('pages.public.index')); ?>" method="GET" class="pages-search-form">
                            <div class="row g-3">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                            placeholder="Cari halaman..." class="form-control">
                                    </div>
                                </div>

                                <?php if($categories->count() > 0): ?>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <select name="category" class="form-control">
                                                <option value="">Semua Kategori</option>
                                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($category); ?>"
                                                        <?php echo e(request('category') == $category ? 'selected' : ''); ?>>
                                                        <?php echo e($category); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="col-lg-1">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Pages Grid -->
            <?php if($pages->count() > 0): ?>
                <div class="row">
                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                            <div class="pages-item">
                                <div class="pages-img">
                                    <?php if($page->featured_image): ?>
                                        <img src="<?php echo e(Storage::url($page->featured_image)); ?>" alt="<?php echo e($page->title); ?>">
                                    <?php else: ?>
                                        <div class="pages-placeholder">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($page->category): ?>
                                        <div class="pages-category">
                                            <span><?php echo e($page->category); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="pages-content">
                                    <h3 class="pages-title">
                                        <a href="<?php echo e(route('pages.public.show', $page->slug)); ?>"><?php echo e($page->title); ?></a>
                                    </h3>

                                    <?php if($page->excerpt): ?>
                                        <p class="pages-desc"><?php echo e(Str::limit($page->excerpt, 120)); ?></p>
                                    <?php endif; ?>

                                    <div class="pages-meta">
                                        <?php if($page->published_at): ?>
                                            <span class="pages-date">
                                                <i class="far fa-calendar-alt"></i>
                                                <?php echo e($page->published_at->format('d F Y')); ?>

                                            </span>
                                        <?php endif; ?>

                                        <a href="<?php echo e(route('pages.public.show', $page->slug)); ?>" class="pages-read-more">
                                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="pagination-wrapper text-center">
                            <?php echo e($pages->links()); ?>

                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="pages-empty text-center">
                            <div class="pages-empty-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h3 class="pages-empty-title">Tidak Ada Halaman</h3>
                            <p class="pages-empty-desc">
                                <?php if(request('search') || request('category')): ?>
                                    Tidak ada halaman yang sesuai dengan pencarian Anda.
                                <?php else: ?>
                                    Belum ada halaman yang dipublikasikan.
                                <?php endif; ?>
                            </p>

                            <?php if(request('search') || request('category')): ?>
                                <a href="<?php echo e(route('pages.public.index')); ?>" class="btn btn-primary">
                                    Lihat Semua Halaman
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- pages area end -->

    <style>
        /* Pages Styles */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            color: white;
        }

        .page-header-content {
            text-align: center;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }

        .page-desc {
            font-size: 1.2rem;
            opacity: 0.9;
            margin: 0;
        }

        .pages-search-wrapper {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .pages-search-form .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .pages-search-form .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .pages-item {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .pages-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .pages-img {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .pages-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .pages-item:hover .pages-img img {
            transform: scale(1.05);
        }

        .pages-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            opacity: 0.7;
        }

        .pages-category {
            position: absolute;
            top: 15px;
            left: 15px;
        }

        .pages-category span {
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .pages-content {
            padding: 1.5rem;
        }

        .pages-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .pages-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .pages-title a:hover {
            color: #667eea;
        }

        .pages-desc {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .pages-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pages-date {
            color: #999;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pages-read-more {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .pages-read-more:hover {
            color: #5a6fd8;
            text-decoration: none;
        }

        .pages-read-more i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .pages-read-more:hover i {
            transform: translateX(3px);
        }

        .pages-empty {
            padding: 4rem 2rem;
        }

        .pages-empty-icon {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1.5rem;
        }

        .pages-empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 1rem;
        }

        .pages-empty-desc {
            color: #999;
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .pagination-wrapper {
            margin-top: 3rem;
        }

        .pagination-wrapper .pagination {
            justify-content: center;
        }

        .pagination-wrapper .page-link {
            color: #667eea;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 5px;
        }

        .pagination-wrapper .page-link:hover {
            background-color: #667eea;
            border-color: #667eea;
            color: white;
        }

        .pagination-wrapper .page-item.active .page-link {
            background-color: #667eea;
            border-color: #667eea;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .pages-search-wrapper {
                padding: 1.5rem;
            }

            .pages-content {
                padding: 1rem;
            }

            .pages-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/pages/public/index.blade.php ENDPATH**/ ?>