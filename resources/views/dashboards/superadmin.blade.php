<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Dashboard</h1>
                <p class="text-slate-600 mt-1">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
            <div class="flex items-center space-x-3">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    System Online
                </span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Enhanced Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div
                class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg border border-blue-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-700 mb-1">Total Users</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $stats['total_users'] ?? 0 }}</p>
                        <p class="text-xs text-blue-600 mt-1">Active members</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Roles -->
            <div
                class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl shadow-lg border border-green-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-700 mb-1">Total Roles</p>
                        <p class="text-3xl font-bold text-green-900">{{ $stats['total_roles'] ?? 0 }}</p>
                        <p class="text-xs text-green-600 mt-1">Access levels</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Permissions -->
            <div
                class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl shadow-lg border border-purple-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-700 mb-1">Permissions</p>
                        <p class="text-3xl font-bold text-purple-900">{{ $stats['total_permissions'] ?? 0 }}</p>
                        <p class="text-xs text-purple-600 mt-1">Access controls</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div
                class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl shadow-lg border border-emerald-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-emerald-700 mb-1">System Status</p>
                        <p class="text-2xl font-bold text-emerald-900">Online</p>
                        <p class="text-xs text-emerald-600 mt-1">All systems operational</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Quick Actions & Modules -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('superadmin.users') }}"
                        class="flex items-center p-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors group">
                        <div
                            class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <span class="text-slate-700 font-medium">Manage Users</span>
                    </a>

                    <a href="{{ route('pages.index') }}"
                        class="flex items-center p-3 rounded-xl bg-green-50 hover:bg-green-100 transition-colors group">
                        <div
                            class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-slate-700 font-medium">Manage Pages</span>
                    </a>

                    <a href="{{ route('guru.index') }}"
                        class="flex items-center p-3 rounded-xl bg-purple-50 hover:bg-purple-100 transition-colors group">
                        <div
                            class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="text-slate-700 font-medium">Manage Teachers</span>
                    </a>
                </div>
            </div>

            <!-- System Modules -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    System Modules
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('siswa.index') }}"
                        class="p-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors text-center group">
                        <div
                            class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                            </svg>
                        </div>
                        <p class="text-xs font-medium text-slate-700">Students</p>
                    </a>

                    <a href="{{ route('osis.index') }}"
                        class="p-3 rounded-xl bg-green-50 hover:bg-green-100 transition-colors text-center group">
                        <div
                            class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-xs font-medium text-slate-700">E-OSIS</p>
                    </a>

                    <a href="{{ route('lulus.index') }}"
                        class="p-3 rounded-xl bg-purple-50 hover:bg-purple-100 transition-colors text-center group">
                        <div
                            class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-xs font-medium text-slate-700">E-Lulus</p>
                    </a>

                    <a href="{{ route('sarpras.index') }}"
                        class="p-3 rounded-xl bg-orange-50 hover:bg-orange-100 transition-colors text-center group">
                        <div
                            class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <p class="text-xs font-medium text-slate-700">Sarpras</p>
                    </a>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recent Activities
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center p-3 rounded-xl bg-slate-50">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-900">System initialized</p>
                            <p class="text-xs text-slate-500">Just now</p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 rounded-xl bg-slate-50">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-900">Database migrated</p>
                            <p class="text-xs text-slate-500">2 minutes ago</p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 rounded-xl bg-slate-50">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-900">Modules loaded</p>
                            <p class="text-xs text-slate-500">5 minutes ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-slate-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                System Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 rounded-xl bg-slate-50">
                    <p class="text-2xl font-bold text-slate-900">{{ config('app.name') }}</p>
                    <p class="text-sm text-slate-600">Application Name</p>
                </div>
                <div class="text-center p-4 rounded-xl bg-slate-50">
                    <p class="text-2xl font-bold text-slate-900">{{ config('app.env') }}</p>
                    <p class="text-sm text-slate-600">Environment</p>
                </div>
                <div class="text-center p-4 rounded-xl bg-slate-50">
                    <p class="text-2xl font-bold text-slate-900">v1.0.0</p>
                    <p class="text-sm text-slate-600">Version</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
