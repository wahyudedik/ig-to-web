<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    <?php if(Auth::user()->hasRole('superadmin')): ?>
                        Superadmin Dashboard
                    <?php elseif(Auth::user()->hasRole('admin')): ?>
                        Admin Dashboard
                    <?php elseif(Auth::user()->hasRole('guru')): ?>
                        Guru Dashboard
                    <?php elseif(Auth::user()->hasRole('siswa')): ?>
                        Siswa Dashboard
                    <?php elseif(Auth::user()->hasRole('sarpras')): ?>
                        Sarpras Dashboard
                    <?php else: ?>
                        Dashboard
                    <?php endif; ?>
                </h1>
                <p class="text-slate-600 mt-1">Welcome back, <?php echo e(Auth::user()->name); ?>!</p>
            </div>
            <div class="flex items-center space-x-2">
                <?php if(Auth::user()->hasRole('superadmin')): ?>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <span class="w-2 h-2 bg-red-400 rounded-full mr-1.5"></span>
                        Superadmin
                    </span>
                <?php elseif(Auth::user()->hasRole('admin')): ?>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <span class="w-2 h-2 bg-blue-400 rounded-full mr-1.5"></span>
                        Admin
                    </span>
                <?php elseif(Auth::user()->hasRole('guru')): ?>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                        Guru
                    </span>
                <?php elseif(Auth::user()->hasRole('siswa')): ?>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        <span class="w-2 h-2 bg-purple-400 rounded-full mr-1.5"></span>
                        Siswa
                    </span>
                <?php elseif(Auth::user()->hasRole('sarpras')): ?>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        <span class="w-2 h-2 bg-orange-400 rounded-full mr-1.5"></span>
                        Sarpras
                    </span>
                <?php endif; ?>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Students -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Total Siswa</p>
                            <p class="text-2xl font-bold text-slate-900"><?php echo e($statistics['total_siswa'] ?? 0); ?></p>
                            
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Teachers -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Total Guru</p>
                            <p class="text-2xl font-bold text-slate-900"><?php echo e($statistics['total_guru'] ?? 0); ?></p>
                            
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Active Users</p>
                            <p class="text-2xl font-bold text-slate-900"><?php echo e($statistics['total_users'] ?? 0); ?></p>
                            
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Assets -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Total Assets</p>
                            <p class="text-2xl font-bold text-slate-900"><?php echo e($statistics['total_barang'] ?? 0); ?></p>
                            
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Analytics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- User Growth Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Pertumbuhan User</h3>
                            <p class="text-xs text-slate-500 mt-1">6 bulan terakhir - Total:
                                <?php echo e($userGrowth['total_siswa']); ?> siswa, <?php echo e($userGrowth['total_guru']); ?> guru</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-xs text-slate-600">Siswa</span>
                            <div class="w-3 h-3 bg-green-500 rounded-full ml-4"></div>
                            <span class="text-xs text-slate-600">Guru</span>
                        </div>
                    </div>
                    <div class="h-64 flex items-end justify-between space-x-2">
                        <?php $__currentLoopData = $userGrowth['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex flex-col items-center flex-1 group relative">
                                <!-- Tooltip -->
                                <div
                                    class="absolute bottom-full mb-2 hidden group-hover:block bg-slate-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                    <div>Siswa: <?php echo e($monthData['siswa']['count']); ?></div>
                                    <div>Guru: <?php echo e($monthData['guru']['count']); ?></div>
                                </div>

                                <!-- Bars Container -->
                                <div class="flex space-x-1 h-full items-end">
                                    <!-- Siswa Bar -->
                                    <div class="w-6 bg-blue-500 rounded-t transition-all duration-500 hover:bg-blue-600"
                                        style="height: <?php echo e($monthData['siswa']['percentage'] > 0 ? $monthData['siswa']['percentage'] : 5); ?>%"
                                        title="Siswa: <?php echo e($monthData['siswa']['count']); ?>">
                                    </div>
                                    <!-- Guru Bar -->
                                    <div class="w-6 bg-green-500 rounded-t transition-all duration-500 hover:bg-green-600"
                                        style="height: <?php echo e($monthData['guru']['percentage'] > 0 ? $monthData['guru']['percentage'] : 5); ?>%"
                                        title="Guru: <?php echo e($monthData['guru']['count']); ?>">
                                    </div>
                                </div>

                                <!-- Month Label -->
                                <span class="text-xs text-slate-500 mt-2"><?php echo e($monthData['month']); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Module Usage Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Penggunaan Module</h3>
                    <p class="text-xs text-slate-500 mb-4">Berdasarkan jumlah data (70%) & aktivitas 30 hari terakhir
                        (30%)</p>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $moduleUsage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-<?php echo e($module['color']); ?>-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-slate-600"><?php echo e($moduleName); ?></span>
                                    <span class="text-xs text-slate-400 ml-2">(<?php echo e($module['data_count']); ?> data)</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-24 bg-slate-200 rounded-full h-2 mr-3">
                                        <div class="bg-<?php echo e($module['color']); ?>-500 h-2 rounded-full transition-all duration-500"
                                            style="width: <?php echo e($module['percentage']); ?>%"></div>
                                    </div>
                                    <span
                                        class="text-sm font-medium text-slate-900"><?php echo e($module['percentage']); ?>%</span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions and Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Actions -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <?php if(Auth::user()->hasRole('superadmin') || Auth::user()->can('users.create')): ?>
                                <a href="<?php echo e(route('admin.superadmin.users.create')); ?>"
                                    class="flex items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-slate-900">Tambah User Baru</span>
                                </a>
                            <?php endif; ?>

                            <?php if(Auth::user()->hasRole('superadmin') || Auth::user()->can('guru.create')): ?>
                                <a href="<?php echo e(route('admin.guru.create')); ?>"
                                    class="flex items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-slate-900">Tambah Guru Baru</span>
                                </a>
                            <?php endif; ?>

                            <?php if(Auth::user()->hasRole('superadmin') || Auth::user()->can('siswa.create')): ?>
                                <a href="<?php echo e(route('admin.siswa.create')); ?>"
                                    class="flex items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div
                                        class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-slate-900">Tambah Siswa Baru</span>
                                </a>
                            <?php endif; ?>

                            <?php if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('sarpras') || Auth::user()->can('sarpras.create')): ?>
                                <a href="<?php echo e(route('admin.sarpras.barang.create')); ?>"
                                    class="flex items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div
                                        class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-slate-900">Tambah Asset Baru</span>
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo e(route('admin.instagram.management')); ?>"
                                class="flex items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297zm7.718-1.297c-.875.807-2.026 1.297-3.323 1.297s-2.448-.49-3.323-1.297c-.807-.875-1.297-2.026-1.297-3.323s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-900">Kelola Instagram</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-900">Recent Activity</h3>
                            <span class="text-xs text-slate-500">Last 10 activities</span>
                        </div>
                        <div class="space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $recentActivities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php if($activity): ?>
                                    <?php
                                        $action = strtolower($activity->action ?? '');
                                        $iconColor = 'blue';
                                        $iconBg = 'bg-blue-100';
                                        $icon = 'check';

                                        if (str_contains($action, 'create') || str_contains($action, 'add')) {
                                            $iconColor = 'green';
                                            $iconBg = 'bg-green-100';
                                            $icon = 'plus';
                                        } elseif (str_contains($action, 'update') || str_contains($action, 'edit')) {
                                            $iconColor = 'blue';
                                            $iconBg = 'bg-blue-100';
                                            $icon = 'pencil';
                                        } elseif (str_contains($action, 'delete') || str_contains($action, 'remove')) {
                                            $iconColor = 'red';
                                            $iconBg = 'bg-red-100';
                                            $icon = 'trash';
                                        } elseif (str_contains($action, 'login') || str_contains($action, 'logout')) {
                                            $iconColor = 'purple';
                                            $iconBg = 'bg-purple-100';
                                            $icon = 'user';
                                        } elseif (str_contains($action, 'view') || str_contains($action, 'access')) {
                                            $iconColor = 'indigo';
                                            $iconBg = 'bg-indigo-100';
                                            $icon = 'eye';
                                        }
                                    ?>
                                    <div
                                        class="flex items-start space-x-3 py-2 hover:bg-slate-50 rounded-lg px-2 -mx-2 transition-colors">
                                        <div
                                            class="w-8 h-8 <?php echo e($iconBg); ?> rounded-full flex items-center justify-center flex-shrink-0">
                                            <?php if($icon == 'plus'): ?>
                                                <svg class="w-4 h-4 text-<?php echo e($iconColor); ?>-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            <?php elseif($icon == 'pencil'): ?>
                                                <svg class="w-4 h-4 text-<?php echo e($iconColor); ?>-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            <?php elseif($icon == 'trash'): ?>
                                                <svg class="w-4 h-4 text-<?php echo e($iconColor); ?>-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            <?php elseif($icon == 'user'): ?>
                                                <svg class="w-4 h-4 text-<?php echo e($iconColor); ?>-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            <?php elseif($icon == 'eye'): ?>
                                                <svg class="w-4 h-4 text-<?php echo e($iconColor); ?>-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            <?php else: ?>
                                                <svg class="w-4 h-4 text-<?php echo e($iconColor); ?>-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <?php if($activity->user): ?>
                                                    <span
                                                        class="text-sm font-medium text-slate-900"><?php echo e($activity->user->name); ?></span>
                                                <?php else: ?>
                                                    <span class="text-sm font-medium text-slate-900">System</span>
                                                <?php endif; ?>

                                                <?php if($activity->action): ?>
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-<?php echo e($iconColor); ?>-100 text-<?php echo e($iconColor); ?>-800">
                                                        <?php echo e(ucfirst($activity->action)); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-sm text-slate-600 mt-0.5">
                                                <?php echo e($activity->description ?? 'User activity logged'); ?>

                                            </p>
                                            <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <?php echo e($activity->created_at?->diffForHumans() ?? 'Just now'); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-slate-900">No recent activity</h3>
                                    <p class="mt-1 text-sm text-slate-500">Activity will appear here as users interact
                                        with the system.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/dashboards/admin.blade.php ENDPATH**/ ?>