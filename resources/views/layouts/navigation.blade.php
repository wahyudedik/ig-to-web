<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
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
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('dashboard') }}"
                    class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                    Dashboard
                </a>

                @if (Auth::user() && Auth::user()->user_type === 'superadmin')
                    <a href="{{ route('pages.admin') }}"
                        class="text-sm font-medium {{ request()->routeIs('pages.admin') || request()->routeIs('admin.pages.*') ? 'text-blue-600' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                        Pages
                    </a>
                    <a href="{{ route('guru.index') }}"
                        class="text-sm font-medium {{ request()->routeIs('guru.*') ? 'text-blue-600' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                        Guru
                    </a>
                    <a href="{{ route('siswa.index') }}"
                        class="text-sm font-medium {{ request()->routeIs('siswa.*') ? 'text-blue-600' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                        Siswa
                    </a>
                    <a href="{{ route('osis.index') }}"
                        class="text-sm font-medium {{ request()->routeIs('osis.*') ? 'text-blue-600' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                        OSIS
                    </a>
                    <a href="{{ route('lulus.index') }}"
                        class="text-sm font-medium {{ request()->routeIs('lulus.*') ? 'text-blue-600' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                        Lulus
                    </a>
                    <a href="{{ route('sarpras.index') }}"
                        class="text-sm font-medium {{ request()->routeIs('sarpras.*') ? 'text-blue-600' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                        Sarpras
                    </a>
                @endif
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <span
                                class="text-sm font-medium text-white">{{ substr(Auth::user()?->name ?? 'U', 0, 1) }}</span>
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-medium text-slate-900">{{ Auth::user()?->name }}</p>
                            <p class="text-xs text-slate-500">{{ ucfirst(Auth::user()?->user_type) }}</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-slate-200 py-2 z-50">

                        <!-- Profile Section -->
                        <div class="px-4 py-2 border-b border-slate-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-sm font-medium text-white">{{ substr(Auth::user()?->name ?? 'U', 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ Auth::user()?->name }}</p>
                                    <p class="text-xs text-slate-500">{{ ucfirst(Auth::user()?->user_type) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Settings -->
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                            <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile Settings
                        </a>

                        @if (Auth::user() && Auth::user()->user_type === 'superadmin')
                            <!-- Settings Divider -->
                            <div class="border-t border-slate-100 my-2"></div>

                            <!-- Settings Section -->
                            <div class="px-4 py-2">
                                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Settings</h3>
                            </div>

                            <a href="{{ route('settings.index') }}"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                System Settings
                            </a>

                            <a href="{{ route('settings.data-management') }}"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Data Management
                            </a>

                            <a href="{{ route('settings.kelas-jurusan') }}"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                                </svg>
                                Kelas & Jurusan
                            </a>

                            <a href="{{ route('settings.landing-page') }}"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                </svg>
                                Landing Page
                            </a>

                            <a href="{{ route('settings.seo') }}"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                SEO Settings
                            </a>
                        @endif

                        <!-- Help & Support -->
                        <div class="border-t border-slate-100 mt-2 pt-2">
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Help & Support
                            </a>
                        </div>

                        <!-- Logout -->
                        <div class="border-t border-slate-100 mt-2 pt-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                    <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor"
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

                <!-- Mobile Menu Button -->
                <button @click="open = !open"
                    class="md:hidden p-2 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="open" x-transition class="md:hidden border-t border-slate-200 py-4">
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} rounded-lg">
                    Dashboard
                </a>

                @if (Auth::user() && Auth::user()->user_type === 'superadmin')
                    <a href="{{ route('pages.admin') }}"
                        class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('pages.admin') || request()->routeIs('admin.pages.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} rounded-lg">
                        Pages
                    </a>
                    <a href="{{ route('guru.index') }}"
                        class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('guru.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} rounded-lg">
                        Guru
                    </a>
                    <a href="{{ route('siswa.index') }}"
                        class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('siswa.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} rounded-lg">
                        Siswa
                    </a>
                    <a href="{{ route('osis.index') }}"
                        class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('osis.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} rounded-lg">
                        OSIS
                    </a>
                    <a href="{{ route('lulus.index') }}"
                        class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('lulus.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} rounded-lg">
                        Lulus
                    </a>
                    <a href="{{ route('sarpras.index') }}"
                        class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('sarpras.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} rounded-lg">
                        Sarpras
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>
