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
                            <p class="text-xs text-green-600 mt-1">+12% dari bulan lalu</p>
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
                            <p class="text-xs text-green-600 mt-1">+5% dari bulan lalu</p>
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
                            <p class="text-xs text-blue-600 mt-1">Online sekarang</p>
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
                            <p class="text-xs text-orange-600 mt-1">Sarana Prasarana</p>
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
                        <h3 class="text-lg font-semibold text-slate-900">Pertumbuhan User</h3>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-sm text-slate-600">Siswa</span>
                            <div class="w-3 h-3 bg-green-500 rounded-full ml-4"></div>
                            <span class="text-sm text-slate-600">Guru</span>
                        </div>
                    </div>
                    <div class="h-64 flex items-end justify-between space-x-2">
                        <!-- Sample Chart Bars -->
                        <div class="flex flex-col items-center">
                            <div class="w-8 bg-blue-200 rounded-t" style="height: 60%"></div>
                            <span class="text-xs text-slate-500 mt-2">Jan</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 bg-blue-300 rounded-t" style="height: 75%"></div>
                            <span class="text-xs text-slate-500 mt-2">Feb</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 bg-blue-400 rounded-t" style="height: 85%"></div>
                            <span class="text-xs text-slate-500 mt-2">Mar</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 bg-blue-500 rounded-t" style="height: 95%"></div>
                            <span class="text-xs text-slate-500 mt-2">Apr</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 bg-blue-600 rounded-t" style="height: 100%"></div>
                            <span class="text-xs text-slate-500 mt-2">May</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 bg-blue-700 rounded-t" style="height: 90%"></div>
                            <span class="text-xs text-slate-500 mt-2">Jun</span>
                        </div>
                    </div>
                </div>

                <!-- Module Usage Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Penggunaan Module</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-sm text-slate-600">User Management</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-24 bg-slate-200 rounded-full h-2 mr-3">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                                <span class="text-sm font-medium text-slate-900">85%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm text-slate-600">Guru Management</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-24 bg-slate-200 rounded-full h-2 mr-3">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 72%"></div>
                                </div>
                                <span class="text-sm font-medium text-slate-900">72%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                <span class="text-sm text-slate-600">Siswa Management</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-24 bg-slate-200 rounded-full h-2 mr-3">
                                    <div class="bg-purple-500 h-2 rounded-full" style="width: 68%"></div>
                                </div>
                                <span class="text-sm font-medium text-slate-900">68%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                                <span class="text-sm text-slate-600">Sarpras Management</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-24 bg-slate-200 rounded-full h-2 mr-3">
                                    <div class="bg-orange-500 h-2 rounded-full" style="width: 45%"></div>
                                </div>
                                <span class="text-sm font-medium text-slate-900">45%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-pink-500 rounded-full mr-3"></div>
                                <span class="text-sm text-slate-600">OSIS System</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-24 bg-slate-200 rounded-full h-2 mr-3">
                                    <div class="bg-pink-500 h-2 rounded-full" style="width: 38%"></div>
                                </div>
                                <span class="text-sm font-medium text-slate-900">38%</span>
                            </div>
                        </div>
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
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $recentActivities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php if($activity): ?>
                                    <div class="flex items-start space-x-3">
                                        <div
                                            class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-slate-900">
                                                <?php echo e($activity?->description ?? 'User activity logged'); ?></p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                <?php echo e($activity?->created_at?->diffForHumans() ?? 'Just now'); ?></p>
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