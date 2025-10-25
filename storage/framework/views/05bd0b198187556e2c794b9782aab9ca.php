<!-- campus life -->
<div class="campus-life pt-120 pb-80">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="content-img wow fadeInLeft" data-wow-delay=".25s">
                    <?php if(cache('site_setting_headmaster_photo')): ?>
                        <img src="<?php echo e(Storage::url(cache('site_setting_headmaster_photo'))); ?>" alt="Foto Kepala Sekolah">
                    <?php else: ?>
                        <img src="<?php echo e(asset('assets/img/campus-life/01.jpg')); ?>" alt="">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                    <div class="site-heading mb-3">
                        <h4 class="site-title">
                            Kepala Madrasah <span>:
                                <?php echo e(cache('site_setting_headmaster_name', 'Khoiruddinul Qoyyum,S.S.,M.Pd')); ?></span>
                        </h4>
                    </div>
                    <p class="content-text">
                        <?php echo e(cache('site_setting_headmaster_description', 'Sebagai kepala madrasah yang berpengalaman, kami berkomitmen untuk memberikan pendidikan terbaik bagi para siswa dengan mengintegrasikan nilai-nilai keislaman dan pengetahuan modern.')); ?>

                    </p>
                    <p class="content-text mt-2">
                        <?php echo e(cache('site_setting_headmaster_vision', 'Visi kami adalah menciptakan generasi yang unggul dalam akademik, berakhlak mulia, dan siap menghadapi tantangan masa depan dengan bekal ilmu pengetahuan yang komprehensif.')); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- campus life end-->
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/components/landing/campus-life.blade.php ENDPATH**/ ?>