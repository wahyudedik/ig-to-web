<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">System Health Monitor</h1>
                <p class="text-slate-600 mt-1">Real-time system health and performance monitoring</p>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="refreshHealthData()" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh
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
            <p class="text-slate-600 mt-4">Loading system health data...</p>
        </div>

        <!-- Health Content -->
        <div id="health-content" class="hidden">
            <!-- Overall Status -->
            <div class="mb-8">
                <div id="overall-status" class="bg-white rounded-xl border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div id="status-icon" class="w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900" id="status-title">System Healthy</h2>
                                <p class="text-slate-600" id="status-description">All systems are operating normally</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-600">Last Updated</p>
                            <p class="text-lg font-semibold text-slate-900" id="last-updated">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Checks -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Database -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">Database</h3>
                        <span id="db-status-badge"
                            class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Healthy
                        </span>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Response Time</span>
                            <span class="text-sm font-medium text-slate-900" id="db-response-time">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Version</span>
                            <span class="text-sm font-medium text-slate-900" id="db-version">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Connections</span>
                            <span class="text-sm font-medium text-slate-900" id="db-connections">-</span>
                        </div>
                    </div>
                </div>

                <!-- Cache -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">Cache</h3>
                        <span id="cache-status-badge"
                            class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Healthy
                        </span>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Driver</span>
                            <span class="text-sm font-medium text-slate-900" id="cache-driver">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Store</span>
                            <span class="text-sm font-medium text-slate-900" id="cache-store">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Hit Rate</span>
                            <span class="text-sm font-medium text-slate-900" id="cache-hit-rate">-</span>
                        </div>
                    </div>
                </div>

                <!-- Storage -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">Storage</h3>
                        <span id="storage-status-badge"
                            class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Healthy
                        </span>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Local Disk</span>
                            <span class="text-sm font-medium text-slate-900" id="storage-local">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Public Disk</span>
                            <span class="text-sm font-medium text-slate-900" id="storage-public">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Free Space</span>
                            <span class="text-sm font-medium text-slate-900" id="storage-free">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Memory Usage -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Memory Usage</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-slate-600">Current Usage</span>
                                <span class="text-sm font-medium text-slate-900" id="memory-current">-</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="memory-progress" class="bg-blue-600 h-2 rounded-full" style="width: 0%">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-slate-600">Peak Usage</span>
                                <span class="text-sm font-medium text-slate-900" id="memory-peak">-</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="memory-peak-progress" class="bg-purple-600 h-2 rounded-full"
                                    style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Limit</span>
                            <span class="text-sm font-medium text-slate-900" id="memory-limit">-</span>
                        </div>
                    </div>
                </div>

                <!-- Disk Usage -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Disk Usage</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-slate-600">Used Space</span>
                                <span class="text-sm font-medium text-slate-900" id="disk-used">-</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="disk-progress" class="bg-green-600 h-2 rounded-full" style="width: 0%">
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Total Space</span>
                            <span class="text-sm font-medium text-slate-900" id="disk-total">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Free Space</span>
                            <span class="text-sm font-medium text-slate-900" id="disk-free">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Application Info -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Application Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Environment</span>
                            <span class="text-sm font-medium text-slate-900" id="app-environment">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Debug Mode</span>
                            <span class="text-sm font-medium text-slate-900" id="app-debug">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Maintenance Mode</span>
                            <span class="text-sm font-medium text-slate-900" id="app-maintenance">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">PHP Version</span>
                            <span class="text-sm font-medium text-slate-900" id="php-version">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-600">Laravel Version</span>
                            <span class="text-sm font-medium text-slate-900" id="laravel-version">-</span>
                        </div>
                    </div>
                </div>

                <!-- External Services -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">External Services</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Instagram API</span>
                            <span id="instagram-status"
                                class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Healthy
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Email Service</span>
                            <span id="email-status"
                                class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Healthy
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Queue System</span>
                            <span id="queue-status"
                                class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Healthy
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Trends -->
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Performance Trends</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-900">Response Time</h4>
                        <p class="text-2xl font-bold text-slate-900" id="avg-response-time">-</p>
                        <p class="text-sm text-slate-600">Average (ms)</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-900">Error Rate</h4>
                        <p class="text-2xl font-bold text-slate-900" id="avg-error-rate">-</p>
                        <p class="text-sm text-slate-600">Percentage</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-900">Uptime</h4>
                        <p class="text-2xl font-bold text-slate-900" id="system-uptime">-</p>
                        <p class="text-sm text-slate-600">System Uptime</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let refreshInterval;

        // Load health data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadHealthData();

            // Auto-refresh every 10 seconds
            refreshInterval = setInterval(loadHealthData, 10000);
        });

        function refreshHealthData() {
            loadHealthData();
        }

        function loadHealthData() {
            fetch('{{ route('api.system.health') }}')
                .then(response => response.json())
                .then(data => {
                    updateHealthData(data);
                    showContent();
                })
                .catch(error => {
                    console.error('Error loading health data:', error);
                });
        }

        function updateHealthData(data) {
            // Update overall status
            updateOverallStatus(data.status);

            // Update last updated time
            document.getElementById('last-updated').textContent = new Date(data.timestamp).toLocaleTimeString();

            // Update system checks
            updateSystemChecks(data.checks);

            // Update performance metrics
            updatePerformanceMetrics(data.checks);

            // Update application info
            updateApplicationInfo(data);

            // Update external services
            updateExternalServices(data.checks.external_services);
        }

        function updateOverallStatus(status) {
            const statusElement = document.getElementById('overall-status');
            const statusIcon = document.getElementById('status-icon');
            const statusTitle = document.getElementById('status-title');
            const statusDescription = document.getElementById('status-description');

            if (status === 'healthy') {
                statusElement.className = 'bg-white rounded-xl border border-green-200 p-6';
                statusIcon.className = 'w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4';
                statusIcon.innerHTML =
                    '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                statusTitle.textContent = 'System Healthy';
                statusDescription.textContent = 'All systems are operating normally';
            } else {
                statusElement.className = 'bg-white rounded-xl border border-red-200 p-6';
                statusIcon.className = 'w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4';
                statusIcon.innerHTML =
                    '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                statusTitle.textContent = 'System Issues Detected';
                statusDescription.textContent = 'Some systems require attention';
            }
        }

        function updateSystemChecks(checks) {
            // Database
            updateStatusBadge('db-status-badge', checks.database.status);
            document.getElementById('db-response-time').textContent = checks.database.response_time_ms + ' ms';
            document.getElementById('db-version').textContent = checks.database.version || 'Unknown';
            document.getElementById('db-connections').textContent = checks.database.connection_count || 'Unknown';

            // Cache
            updateStatusBadge('cache-status-badge', checks.cache.status);
            document.getElementById('cache-driver').textContent = checks.cache.driver || 'Unknown';
            document.getElementById('cache-store').textContent = checks.cache.store || 'Unknown';

            // Storage
            updateStatusBadge('storage-status-badge', checks.storage.status);
            document.getElementById('storage-local').textContent = checks.storage.local_disk || 'Unknown';
            document.getElementById('storage-public').textContent = checks.storage.public_disk || 'Unknown';
        }

        function updatePerformanceMetrics(checks) {
            // Memory usage
            const memoryUsage = checks.memory.usage_percentage;
            document.getElementById('memory-current').textContent = checks.memory.current_mb + ' MB';
            document.getElementById('memory-peak').textContent = checks.memory.peak_memory_mb + ' MB';
            document.getElementById('memory-limit').textContent = checks.memory.limit_mb + ' MB';
            document.getElementById('memory-progress').style.width = memoryUsage + '%';
            document.getElementById('memory-peak-progress').style.width = (checks.memory.peak_memory_mb / checks.memory
                .limit_mb * 100) + '%';

            // Disk usage
            const diskUsage = checks.disk_space.usage_percentage;
            document.getElementById('disk-used').textContent = checks.disk_space.used_gb + ' GB';
            document.getElementById('disk-total').textContent = checks.disk_space.total_gb + ' GB';
            document.getElementById('disk-free').textContent = checks.disk_space.free_gb + ' GB';
            document.getElementById('disk-progress').style.width = diskUsage + '%';
        }

        function updateApplicationInfo(data) {
            // This would come from the metrics endpoint
            document.getElementById('app-environment').textContent = data.environment || 'Unknown';
            document.getElementById('app-debug').textContent = data.debug_mode ? 'Enabled' : 'Disabled';
            document.getElementById('app-maintenance').textContent = data.maintenance_mode ? 'Enabled' : 'Disabled';
            document.getElementById('php-version').textContent = data.php_version || 'Unknown';
            document.getElementById('laravel-version').textContent = data.laravel_version || 'Unknown';
        }

        function updateExternalServices(services) {
            updateServiceStatus('instagram-status', services.instagram_api.status);
            updateServiceStatus('email-status', services.email_service.status);
            updateServiceStatus('queue-status', 'healthy'); // Default for now
        }

        function updateStatusBadge(elementId, status) {
            const element = document.getElementById(elementId);
            if (status === 'healthy') {
                element.className = 'px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
                element.textContent = 'Healthy';
            } else if (status === 'warning') {
                element.className = 'px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800';
                element.textContent = 'Warning';
            } else {
                element.className = 'px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
                element.textContent = 'Unhealthy';
            }
        }

        function updateServiceStatus(elementId, status) {
            const element = document.getElementById(elementId);
            if (status === 'healthy') {
                element.className = 'px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800';
                element.textContent = 'Healthy';
            } else if (status === 'not_configured') {
                element.className = 'px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
                element.textContent = 'Not Configured';
            } else {
                element.className = 'px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800';
                element.textContent = 'Unhealthy';
            }
        }

        function showContent() {
            document.getElementById('loading-state').classList.add('hidden');
            document.getElementById('health-content').classList.remove('hidden');
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });
    </script>
</x-app-layout>
