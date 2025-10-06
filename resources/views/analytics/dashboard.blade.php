<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Analytics Dashboard</h1>
                <p class="text-slate-600 mt-1">Comprehensive system analytics and insights</p>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="refreshAnalytics()" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh Data
                </button>
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
        <!-- Loading State -->
        <div id="loading-state" class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
            <p class="text-slate-600 mt-4">Loading analytics data...</p>
        </div>

        <!-- Analytics Content -->
        <div id="analytics-content" class="hidden">
            <!-- Overview Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-600">Total Users</p>
                            <p class="text-2xl font-bold text-slate-900" id="total-users">-</p>
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
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-600">Total Students</p>
                            <p class="text-2xl font-bold text-slate-900" id="total-students">-</p>
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
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-600">Total Teachers</p>
                            <p class="text-2xl font-bold text-slate-900" id="total-teachers">-</p>
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
                            <p class="text-sm font-medium text-slate-600">Total Assets</p>
                            <p class="text-2xl font-bold text-slate-900" id="total-assets">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- User Activity Chart -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">User Activity (Last 30 Days)</h3>
                    <canvas id="userActivityChart" width="400" height="200"></canvas>
                </div>

                <!-- Module Usage Chart -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Module Usage</h3>
                    <canvas id="moduleUsageChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Real-time Statistics -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Real-time Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Online Users</span>
                            <span class="text-lg font-semibold text-slate-900" id="online-users">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Memory Usage</span>
                            <span class="text-lg font-semibold text-slate-900" id="memory-usage">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Server Load</span>
                            <span class="text-lg font-semibold text-slate-900" id="server-load">-</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Performance Metrics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Response Time</span>
                            <span class="text-lg font-semibold text-slate-900" id="response-time">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Error Rate</span>
                            <span class="text-lg font-semibold text-slate-900" id="error-rate">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Cache Hit Rate</span>
                            <span class="text-lg font-semibold text-slate-900" id="cache-hit-rate">-</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">System Health</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Database</span>
                            <span class="text-lg font-semibold text-green-600" id="db-status">Healthy</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Cache</span>
                            <span class="text-lg font-semibold text-green-600" id="cache-status">Healthy</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Storage</span>
                            <span class="text-lg font-semibold text-green-600" id="storage-status">Healthy</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Module Statistics -->
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Module Statistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-900">E-OSIS</h4>
                        <p class="text-2xl font-bold text-slate-900" id="osis-candidates">-</p>
                        <p class="text-sm text-slate-600">Candidates</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-900">E-Lulus</h4>
                        <p class="text-2xl font-bold text-slate-900" id="graduated-students">-</p>
                        <p class="text-sm text-slate-600">Graduated</p>
                    </div>

                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-900">Sarpras</h4>
                        <p class="text-2xl font-bold text-slate-900" id="maintenance-due">-</p>
                        <p class="text-sm text-slate-600">Maintenance Due</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-900">Instagram</h4>
                        <p class="text-2xl font-bold text-slate-900" id="instagram-posts">-</p>
                        <p class="text-sm text-slate-600">Posts</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let userActivityChart, moduleUsageChart;
        let refreshInterval;

        // Load analytics data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadAnalyticsData();

            // Auto-refresh every 30 seconds
            refreshInterval = setInterval(loadAnalyticsData, 30000);
        });

        function refreshAnalytics() {
            loadAnalyticsData();
        }

        function loadAnalyticsData() {
            fetch('{{ route('api.dashboard.analytics') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateAnalytics(data.data);
                        showContent();
                    } else {
                        console.error('Failed to load analytics:', data);
                    }
                })
                .catch(error => {
                    console.error('Error loading analytics:', error);
                });
        }

        function updateAnalytics(data) {
            // Update overview statistics
            document.getElementById('total-users').textContent = data.overview.total_users;
            document.getElementById('total-students').textContent = data.overview.total_students;
            document.getElementById('total-teachers').textContent = data.overview.total_teachers;
            document.getElementById('total-assets').textContent = data.overview.total_assets;

            // Update real-time statistics
            document.getElementById('online-users').textContent = data.real_time_stats.online_users;
            document.getElementById('memory-usage').textContent = data.real_time_stats.memory_usage_mb + ' MB';
            document.getElementById('server-load').textContent = data.real_time_stats.server_load.toFixed(2);

            // Update performance metrics
            document.getElementById('response-time').textContent = data.performance_metrics.response_time + ' ms';
            document.getElementById('error-rate').textContent = (data.performance_metrics.error_rate * 100).toFixed(2) +
            '%';
            document.getElementById('cache-hit-rate').textContent = data.performance_metrics.cache_hit_rate + '%';

            // Update module statistics
            document.getElementById('osis-candidates').textContent = data.module_usage.e_osis.total_candidates;
            document.getElementById('graduated-students').textContent = data.module_usage.e_lulus.total_graduates;
            document.getElementById('maintenance-due').textContent = data.module_usage.sarpras.maintenance_due;
            document.getElementById('instagram-posts').textContent = data.module_usage.instagram.total_posts;

            // Update charts
            updateCharts(data);
        }

        function updateCharts(data) {
            // User Activity Chart
            const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
            if (userActivityChart) {
                userActivityChart.destroy();
            }

            userActivityChart = new Chart(userActivityCtx, {
                type: 'line',
                data: {
                    labels: data.trends.user_registrations.map(item => item.date),
                    datasets: [{
                        label: 'New Users',
                        data: data.trends.user_registrations.map(item => item.count),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'Login Activity',
                        data: data.trends.login_activity.map(item => item.count),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Module Usage Chart
            const moduleUsageCtx = document.getElementById('moduleUsageChart').getContext('2d');
            if (moduleUsageChart) {
                moduleUsageChart.destroy();
            }

            moduleUsageChart = new Chart(moduleUsageCtx, {
                type: 'doughnut',
                data: {
                    labels: ['E-OSIS', 'E-Lulus', 'Sarpras', 'Instagram'],
                    datasets: [{
                        data: [
                            data.module_usage.e_osis.total_candidates,
                            data.module_usage.e_lulus.total_graduates,
                            data.module_usage.sarpras.total_assets,
                            data.module_usage.instagram.total_posts
                        ],
                        backgroundColor: [
                            'rgb(59, 130, 246)',
                            'rgb(16, 185, 129)',
                            'rgb(139, 92, 246)',
                            'rgb(236, 72, 153)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        function showContent() {
            document.getElementById('loading-state').classList.add('hidden');
            document.getElementById('analytics-content').classList.remove('hidden');
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });
    </script>
</x-app-layout>
