<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.555a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.43 0l5.01-2.147a1 1 0 00.71-.739 1 1 0 00-.71-1.26l-5.01-2.147a3 3 0 00-2.43 0L7 8.5V5.5a1 1 0 00-1.5-.5L3.5 6.5a1 1 0 00-.5 1.5v8a1 1 0 001.5.5L7 14.5v-1.5a1 1 0 011.5-.5L9.3 16.573z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-slate-900">Sekolah</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="text-sm font-medium <?php echo e(request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-slate-600 hover:text-slate-900'); ?> transition-colors">
                    Dashboard
                </a>

                <!-- Academic Management -->
                <div class="relative group">
                    <button
                        class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors flex items-center">
                        Academic
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute top-full left-0 mt-1 w-56 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            <a href="<?php echo e(route('admin.guru.index')); ?>"
                                class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>Guru Management
                            </a>
                            <a href="<?php echo e(route('admin.siswa.index')); ?>"
                                class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-user-graduate mr-2"></i>Siswa Management
                            </a>
                            <a href="<?php echo e(route('admin.sarpras.index')); ?>"
                                class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-building mr-2"></i>Sarpras Management
                            </a>
                        </div>
                    </div>
                </div>

                <!-- E-Services -->
                <div class="relative group">
                    <button
                        class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors flex items-center">
                        E-Services
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            <a href="<?php echo e(route('admin.osis.index')); ?>"
                                class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-vote-yea mr-2"></i>E-OSIS Voting
                            </a>
                            <a href="<?php echo e(route('admin.lulus.index')); ?>"
                                class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-graduation-cap mr-2"></i>E-Lulus Graduation
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Content Management -->
                <div class="relative group">
                    <button
                        class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors flex items-center">
                        Content
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            <a href="<?php echo e(route('landing')); ?>"
                                class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-globe mr-2"></i>Landing Page
                            </a>
                            <a href="<?php echo e(route('admin.pages.index')); ?>"
                                class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-file-alt mr-2"></i>Page Management
                            </a>
                            <a href="<?php echo e(route('admin.instagram.management')); ?>"
                                class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <i class="fab fa-instagram mr-2"></i>Instagram & Events
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Management (Superadmin only) -->
                <?php if(Auth::user()->hasRole('superadmin')): ?>
                    <div class="relative group">
                        <button
                            class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors flex items-center">
                            System
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div
                            class="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-2">
                                <a href="<?php echo e(route('admin.user-management.index')); ?>"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                    <i class="fas fa-users mr-2"></i>User Management
                                </a>
                                <a href="<?php echo e(route('admin.role-permissions.index')); ?>"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                    <i class="fas fa-shield-alt mr-2"></i>Role & Permissions
                                </a>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', App\Models\Permission::class)): ?>
                                    <a href="<?php echo e(route('admin.permissions.index')); ?>"
                                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <i class="fas fa-shield-alt mr-2"></i>Permission Management
                                    </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAnalytics', App\Models\User::class)): ?>
                                    <a href="<?php echo e(route('admin.analytics')); ?>"
                                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <i class="fas fa-chart-line mr-2"></i>Analytics Dashboard
                                    </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewSystemHealth', App\Models\User::class)): ?>
                                    <a href="<?php echo e(route('admin.system.health')); ?>"
                                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <i class="fas fa-heartbeat mr-2"></i>System Health
                                    </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewNotifications', App\Models\User::class)): ?>
                                    <a href="<?php echo e(route('admin.notifications')); ?>"
                                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <i class="fas fa-bell mr-2"></i>Notification Center
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('admin.settings.index')); ?>"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                    <i class="fas fa-cog mr-2"></i>System Settings
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- User Profile Dropdown -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 text-slate-600 hover:text-slate-900 transition-colors">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-white"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></span>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-slate-900"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-xs text-slate-500">
                                <?php echo e(ucfirst(Auth::user()->getRoleNames()->first() ?? 'User')); ?></p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-slate-200 z-50">
                        <div class="py-2">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="text-sm font-medium text-slate-900"><?php echo e(Auth::user()->name); ?></p>
                                <p class="text-sm text-slate-500"><?php echo e(Auth::user()->email); ?></p>
                                <p class="text-xs text-slate-400 mt-1">
                                    <?php echo e(ucfirst(Auth::user()->getRoleNames()->first() ?? 'User')); ?></p>
                            </div>

                            <!-- Profile Actions -->
                            <div class="py-2">
                                <a href="<?php echo e(route('admin.profile.edit')); ?>"
                                    class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile Settings
                                </a>
                                <a href="<?php echo e(route('landing')); ?>" target="_blank"
                                    class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    View Website
                                </a>
                            </div>

                            <!-- Quick Settings -->
                            <div class="py-2 border-t border-slate-100">
                                <div class="px-4 py-2">
                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Quick
                                        Access</p>
                                </div>
                                <?php if(Auth::user()->hasRole('superadmin')): ?>
                                    <a href="<?php echo e(route('admin.superadmin.instagram-settings')); ?>"
                                        class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001z" />
                                        </svg>
                                        Instagram Settings
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('admin.settings.index')); ?>"
                                    class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    System Settings
                                </a>
                            </div>

                            <!-- Logout -->
                            <div class="py-2 border-t border-slate-100">
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open"
                    class="p-2 rounded-md text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="open" x-transition class="md:hidden border-t border-slate-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Dashboard -->
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="block px-3 py-2 rounded-md text-base font-medium <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'); ?>">
                    Dashboard
                </a>

                <!-- Academic Management -->
                <div class="px-3 py-2">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Academic Management
                    </div>
                    <div class="space-y-1 ml-2">
                        <a href="<?php echo e(route('admin.guru.index')); ?>"
                            class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>Guru Management
                        </a>
                        <a href="<?php echo e(route('admin.siswa.index')); ?>"
                            class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                            <i class="fas fa-user-graduate mr-2"></i>Siswa Management
                        </a>
                        <a href="<?php echo e(route('admin.sarpras.index')); ?>"
                            class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                            <i class="fas fa-building mr-2"></i>Sarpras Management
                        </a>
                    </div>
                </div>

                <!-- E-Services -->
                <div class="px-3 py-2">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">E-Services</div>
                    <div class="space-y-1 ml-2">
                        <a href="<?php echo e(route('admin.osis.index')); ?>"
                            class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                            <i class="fas fa-vote-yea mr-2"></i>E-OSIS Voting
                        </a>
                        <a href="<?php echo e(route('admin.lulus.index')); ?>"
                            class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                            <i class="fas fa-graduation-cap mr-2"></i>E-Lulus Graduation
                        </a>
                    </div>
                </div>

                <!-- Content Management -->
                <div class="px-3 py-2">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Content Management
                    </div>
                    <div class="space-y-1 ml-2">
                        <a href="<?php echo e(route('landing')); ?>"
                            class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                            <i class="fas fa-globe mr-2"></i>Landing Page
                        </a>
                        <a href="<?php echo e(route('admin.pages.index')); ?>"
                            class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                            <i class="fas fa-file-alt mr-2"></i>Page Management
                        </a>
                        <a href="<?php echo e(route('admin.instagram.management')); ?>"
                            class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                            <i class="fab fa-instagram mr-2"></i>Instagram & Events
                        </a>
                    </div>
                </div>

                <!-- System Management -->
                <?php if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')): ?>
                    <div class="px-3 py-2">
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">System
                            Management</div>
                        <div class="space-y-1 ml-2">
                            <a href="<?php echo e(route('admin.superadmin.users')); ?>"
                                class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                                <i class="fas fa-users mr-2"></i>User Management
                            </a>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', App\Models\Permission::class)): ?>
                                <a href="<?php echo e(route('admin.permissions.index')); ?>"
                                    class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                                    <i class="fas fa-shield-alt mr-2"></i>Permission Management
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('admin.analytics')); ?>"
                                class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                                <i class="fas fa-chart-line mr-2"></i>Analytics Dashboard
                            </a>
                            <a href="<?php echo e(route('admin.system.health')); ?>"
                                class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                                <i class="fas fa-heartbeat mr-2"></i>System Health
                            </a>
                            <a href="<?php echo e(route('admin.notifications')); ?>"
                                class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                                <i class="fas fa-bell mr-2"></i>Notification Center
                            </a>
                            <a href="<?php echo e(route('admin.settings.index')); ?>"
                                class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                                <i class="fas fa-cog mr-2"></i>System Settings
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>