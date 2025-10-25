<?php $__env->startSection('content'); ?>
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url(<?php echo e(asset('assets/img/breadcrumb/01.jpg')); ?>)">
        <div class="container">
            <h2 class="breadcrumb-title">Event MAUDU</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">Kegiatan</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Event Sections -->
    <!-- KOMPASS Event -->
    <div class="campus-tour pt-120 pb-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <h2 class="site-title">
                                KOMPASS
                            </h2>
                        </div>
                        <p class="content-text">
                            <?php echo e(cache('event_kompass_description', 'Kompetisi Agama, Sains, dan Seni yang menjadi ajang unjuk kemampuan siswa dalam berbagai bidang. Event ini menampilkan kreativitas dan prestasi siswa dalam mengintegrasikan ilmu agama, sains, dan seni.')); ?>

                        </p>
                        <p class="content-text mt-2">
                            <?php echo e(cache('event_kompass_detail', 'KOMPASS merupakan program unggulan yang mengasah kemampuan siswa dalam berbagai kompetensi, mulai dari keagamaan, sains, hingga seni budaya.')); ?>

                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-img wow fadeInRight" data-wow-delay=".25s">
                        <img src="<?php echo e(asset('assets/img/campus-tour/01.jpg')); ?>" alt="KOMPASS">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- KOMPASS end -->

    <!-- MHW Event -->
    <div class="campus-life pt-120 pb-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content-img wow fadeInLeft" data-wow-delay=".25s">
                        <img src="<?php echo e(asset('assets/img/campus-life/01.jpg')); ?>" alt="MHW">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <h2 class="site-title">
                                MHW <span>: MAUDU</span> Healthy Work
                            </h2>
                        </div>
                        <p class="content-text">
                            <?php echo e(cache('event_mhw_description', 'Program kesehatan dan kebugaran yang mengintegrasikan nilai-nilai keislaman dengan gaya hidup sehat. MHW membentuk karakter siswa yang sehat jasmani dan rohani.')); ?>

                        </p>
                        <p class="content-text mt-2">
                            <?php echo e(cache('event_mhw_detail', 'MAUDU Healthy Work mengajarkan pentingnya menjaga kesehatan sebagai bagian dari ibadah dan tanggung jawab sebagai muslim yang baik.')); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MHW end -->

    <!-- MAUDUFEST Event -->
    <div class="campus-tour pt-120 pb-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <h2 class="site-title">
                                MAUDUFEST
                            </h2>
                        </div>
                        <p class="content-text">
                            <?php echo e(cache('event_maudufest_description', 'Festival tahunan yang menampilkan berbagai prestasi dan kreativitas siswa MAUDU. Event ini menjadi puncak dari semua kegiatan pembelajaran sepanjang tahun.')); ?>

                        </p>
                        <p class="content-text mt-2">
                            <?php echo e(cache('event_maudufest_detail', 'MAUDUFEST adalah ajang apresiasi bagi semua pencapaian siswa dalam bidang akademik, seni, olahraga, dan keagamaan.')); ?>

                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-img wow fadeInRight" data-wow-delay=".25s">
                        <img src="<?php echo e(asset('assets/img/campus-tour/01.jpg')); ?>" alt="MAUDUFEST">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MAUDUFEST end -->

    <!-- MANASIK HAJI Event -->
    <div class="campus-life pt-120 pb-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content-img wow fadeInLeft" data-wow-delay=".25s">
                        <img src="<?php echo e(asset('assets/img/campus-life/01.jpg')); ?>" alt="Manasik Haji">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <h2 class="site-title">
                                MANASIK<span> HAJI</span>
                            </h2>
                        </div>
                        <p class="content-text">
                            <?php echo e(cache('event_manasik_description', 'Praktik ibadah haji yang dilakukan di lingkungan sekolah untuk memberikan pengalaman langsung kepada siswa tentang tata cara pelaksanaan haji yang benar.')); ?>

                        </p>
                        <p class="content-text mt-2">
                            <?php echo e(cache('event_manasik_detail', 'Manasik Haji mengajarkan siswa tentang rukun dan sunnah haji, serta nilai-nilai spiritual yang terkandung dalam ibadah haji.')); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MANASIK HAJI end -->

    <!-- RUKYATUL HILAL Event -->
    <div class="campus-tour pt-120 pb-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <h2 class="site-title">
                                RUKYATUL HILAL
                            </h2>
                        </div>
                        <p class="content-text">
                            <?php echo e(cache('event_rukyatul_description', 'Kegiatan pengamatan hilal (bulan sabit) untuk menentukan awal bulan hijriyah. Siswa diajak untuk memahami aspek astronomi dalam penentuan kalender Islam.')); ?>

                        </p>
                        <p class="content-text mt-2">
                            <?php echo e(cache('event_rukyatul_detail', 'Rukyatul Hilal mengintegrasikan ilmu falak dengan pembelajaran agama, memberikan pemahaman yang mendalam tentang sistem kalender Islam.')); ?>

                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-img wow fadeInRight" data-wow-delay=".25s">
                        <img src="<?php echo e(asset('assets/img/campus-tour/01.jpg')); ?>" alt="Rukyatul Hilal">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- RUKYATUL HILAL end -->

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
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative">
                                <img src="<?php echo e($post['media_url']); ?>" class="card-img-top" alt="Kegiatan Sekolah"
                                    style="height: 250px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <a href="<?php echo e($post['permalink']); ?>" target="_blank" class="btn btn-sm btn-dark">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-text flex-grow-1">
                                    <?php echo e(Str::limit($post['caption'], 150)); ?>

                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <span class="badge bg-danger">
                                            <i class="fas fa-heart"></i> <?php echo e(number_format($post['like_count'])); ?>

                                        </span>
                                        <span class="badge bg-primary ms-1">
                                            <i class="fas fa-comment"></i>
                                            <?php echo e(number_format($post['comment_count'])); ?>

                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo e($post['timestamp']->diffForHumans()); ?>

                                    </small>
                                </div>
                                <div class="mt-2">
                                    <a href="<?php echo e($post['permalink']); ?>" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fab fa-instagram me-1"></i> Lihat di Instagram
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fab fa-instagram fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada kegiatan</h4>
                            <p class="text-muted">Kegiatan sekolah akan muncul di sini setelah terhubung dengan
                                Instagram</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Instagram Feed Gallery end -->

    <?php $__env->startPush('scripts'); ?>
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
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/instagram/activities.blade.php ENDPATH**/ ?>