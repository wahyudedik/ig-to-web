<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Analytics Dashboard</h1>
                <p class="text-slate-600 mt-1">Comprehensive system analytics and insights</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.analytics') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh Data
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Overview Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Total Users</p>
                        <p class="text-2xl font-bold text-slate-900">
                            {{ number_format($analytics['overview']['total_users']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Students</p>
                        <p class="text-2xl font-bold text-slate-900">
                            {{ number_format($analytics['overview']['total_students']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Teachers</p>
                        <p class="text-2xl font-bold text-slate-900">
                            {{ number_format($analytics['overview']['total_teachers']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Assets</p>
                        <p class="text-2xl font-bold text-slate-900">
                            {{ number_format($analytics['overview']['total_assets']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Activity & Module Usage -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- User Activity -->
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">User Activity</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Invited Users This Week</span>
                        <span
                            class="text-xl font-bold text-slate-900">{{ $analytics['user_activity']['invited_users_this_week'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Invited Users This Month</span>
                        <span
                            class="text-xl font-bold text-slate-900">{{ $analytics['user_activity']['invited_users_this_month'] }}</span>
                    </div>

                    <div class="pt-4 border-t">
                        <h4 class="text-sm font-medium text-slate-700 mb-3">User Distribution</h4>
                        @foreach ($analytics['user_activity']['user_distribution'] as $role => $count)
                            <div class="flex justify-between items-center py-2">
                                <span class="text-slate-600 capitalize">{{ $role }}</span>
                                <span class="font-semibold text-slate-900">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Module Usage -->
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Module Usage</h3>
                <div class="space-y-4">
                    <!-- OSIS -->
                    <div class="border-b pb-3">
                        <h4 class="text-sm font-medium text-slate-700 mb-2">E-OSIS</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-slate-500">Candidates</p>
                                <p class="text-lg font-bold text-slate-900">
                                    {{ $analytics['module_usage']['e_osis']['total_candidates'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Voters</p>
                                <p class="text-lg font-bold text-slate-900">
                                    {{ $analytics['module_usage']['e_osis']['total_voters'] }}</p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-slate-500">Participation Rate</p>
                            <p class="text-lg font-bold text-green-600">
                                {{ $analytics['module_usage']['e_osis']['voting_participation'] }}%</p>
                        </div>
                    </div>

                    <!-- Graduation -->
                    <div class="border-b pb-3">
                        <h4 class="text-sm font-medium text-slate-700 mb-2">E-Lulus</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-slate-500">Graduates</p>
                                <p class="text-lg font-bold text-slate-900">
                                    {{ $analytics['module_usage']['e_lulus']['total_graduates'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Pending</p>
                                <p class="text-lg font-bold text-slate-900">
                                    {{ $analytics['module_usage']['e_lulus']['pending_verification'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sarpras -->
                    <div>
                        <h4 class="text-sm font-medium text-slate-700 mb-2">Sarpras</h4>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach ($analytics['module_usage']['sarpras']['assets_by_condition'] as $condition => $count)
                                <div>
                                    <p class="text-xs text-slate-500 capitalize">{{ $condition }}</p>
                                    <p class="text-lg font-bold text-slate-900">{{ $count }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trends Chart -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">User Invitation Trend (Last 30 Days)</h3>
            <div class="h-64 flex items-end justify-between space-x-2">
                @php
                    $maxCount = max(array_column($analytics['trends']['user_invitations'], 'count'));
                    $maxCount = $maxCount > 0 ? $maxCount : 1;
                @endphp
                @foreach ($analytics['trends']['user_invitations'] as $day)
                    <div class="flex-1 flex flex-col items-center group relative">
                        <!-- Tooltip -->
                        <div
                            class="absolute bottom-full mb-2 hidden group-hover:block bg-slate-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                            {{ $day['date'] }}: {{ $day['count'] }} invited users
                        </div>
                        <!-- Bar -->
                        <div class="w-full bg-blue-500 rounded-t transition-all duration-300 hover:bg-blue-600"
                            style="height: {{ $day['count'] > 0 ? ($day['count'] / $maxCount) * 100 : 2 }}%">
                        </div>
                        <!-- Label -->
                        @if ($loop->index % 5 == 0)
                            <span class="text-xs text-slate-500 mt-2 rotate-45 origin-left">{{ $day['date'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Module Usage Trend -->
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Module Activity Trend (Last 30 Days)</h3>
            <div class="h-64">
                <div class="flex items-end justify-between space-x-2 h-full">
                    @php
                        $maxModuleCount = 0;
                        foreach ($analytics['trends']['module_usage'] as $day) {
                            $total = $day['voting'] + $day['graduation'] + $day['assets'];
                            if ($total > $maxModuleCount) {
                                $maxModuleCount = $total;
                            }
                        }
                        $maxModuleCount = $maxModuleCount > 0 ? $maxModuleCount : 1;
                    @endphp
                    @foreach ($analytics['trends']['module_usage'] as $day)
                        <div class="flex-1 flex flex-col items-center group relative h-full justify-end">
                            <!-- Tooltip -->
                            <div
                                class="absolute bottom-full mb-2 hidden group-hover:block bg-slate-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                <div>{{ $day['date'] }}</div>
                                <div>Voting: {{ $day['voting'] }}</div>
                                <div>Graduation: {{ $day['graduation'] }}</div>
                                <div>Assets: {{ $day['assets'] }}</div>
                            </div>
                            <!-- Stacked Bars -->
                            <div class="w-full space-y-1">
                                @if ($day['voting'] > 0)
                                    <div class="w-full bg-purple-500 rounded"
                                        style="height: {{ ($day['voting'] / $maxModuleCount) * 200 }}px"></div>
                                @endif
                                @if ($day['graduation'] > 0)
                                    <div class="w-full bg-green-500 rounded"
                                        style="height: {{ ($day['graduation'] / $maxModuleCount) * 200 }}px"></div>
                                @endif
                                @if ($day['assets'] > 0)
                                    <div class="w-full bg-orange-500 rounded"
                                        style="height: {{ ($day['assets'] / $maxModuleCount) * 200 }}px"></div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Legend -->
            <div class="flex justify-center gap-4 mt-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-purple-500 rounded mr-2"></div>
                    <span class="text-sm text-slate-600">Voting</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded mr-2"></div>
                    <span class="text-sm text-slate-600">Graduation</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-orange-500 rounded mr-2"></div>
                    <span class="text-sm text-slate-600">Assets</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
