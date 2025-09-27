<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instagram Settings - Superadmin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Include the existing Tailwind CSS here */
        </style>
    @endif

    <style>
        .instagram-gradient {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        .setting-card {
            transition: all 0.3s ease;
        }

        .setting-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .status-active {
            background-color: #10b981;
            animation: pulse 2s infinite;
        }

        .status-inactive {
            background-color: #ef4444;
        }

        .status-syncing {
            background-color: #f59e0b;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/dashboard" class="text-2xl font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                            Superadmin Dashboard
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/superadmin"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Dashboard
                    </a>
                    <a href="/superadmin/users"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Users
                    </a>
                    <a href="/docs/instagram-setup"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Docs
                    </a>
                    <a href="/kegiatan" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        View Instagram
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="pt-20 pb-8 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-4">
                    <i class="fab fa-instagram text-3xl instagram-gradient mr-3"></i>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Instagram Settings</h1>
                </div>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-6">
                    Configure Instagram API integration for your school's social media feed
                </p>
            </div>
        </div>
    </section>

    <!-- Settings Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Current Status -->
            <div class="setting-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="status-indicator {{ $settings && $settings->is_active ? 'status-active' : 'status-inactive' }}">
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Instagram Integration Status
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                @if ($settings && $settings->is_active)
                                    Active - Last sync:
                                    {{ $settings->last_sync ? $settings->last_sync->diffForHumans() : 'Never' }}
                                @else
                                    Inactive - No Instagram integration configured
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        @if ($settings && $settings->is_active)
                            <button id="syncBtn"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Sync Now
                            </button>
                            <button id="deactivateBtn"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                                <i class="fas fa-power-off mr-2"></i>
                                Deactivate
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Settings Form -->
            <div class="setting-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Instagram API Configuration</h3>

                <form id="instagramSettingsForm" class="space-y-6">
                    <!-- API Credentials -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Access Token <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="access_token" id="access_token"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter Instagram Access Token" value="{{ $settings->access_token ?? '' }}"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Get this from Instagram Basic Display API</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                User ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="user_id" id="user_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter Instagram User ID" value="{{ $settings->user_id ?? '' }}" required>
                            <p class="text-xs text-gray-500 mt-1">Your Instagram account user ID</p>
                        </div>
                    </div>

                    <!-- Optional Settings -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                App ID
                            </label>
                            <input type="text" name="app_id" id="app_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter Instagram App ID" value="{{ $settings->app_id ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                App Secret
                            </label>
                            <input type="password" name="app_secret" id="app_secret"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter Instagram App Secret" value="{{ $settings->app_secret ?? '' }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Redirect URI
                        </label>
                        <input type="url" name="redirect_uri" id="redirect_uri"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            placeholder="https://yourdomain.com/instagram/callback"
                            value="{{ $settings->redirect_uri ?? '' }}">
                    </div>

                    <!-- Sync Settings -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Sync Settings</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Sync Frequency (minutes)
                                </label>
                                <select name="sync_frequency" id="sync_frequency"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="5"
                                        {{ ($settings->sync_frequency ?? 30) == 5 ? 'selected' : '' }}>5 minutes
                                    </option>
                                    <option value="15"
                                        {{ ($settings->sync_frequency ?? 30) == 15 ? 'selected' : '' }}>15 minutes
                                    </option>
                                    <option value="30"
                                        {{ ($settings->sync_frequency ?? 30) == 30 ? 'selected' : '' }}>30 minutes
                                    </option>
                                    <option value="60"
                                        {{ ($settings->sync_frequency ?? 30) == 60 ? 'selected' : '' }}>1 hour</option>
                                    <option value="120"
                                        {{ ($settings->sync_frequency ?? 30) == 120 ? 'selected' : '' }}>2 hours
                                    </option>
                                    <option value="240"
                                        {{ ($settings->sync_frequency ?? 30) == 240 ? 'selected' : '' }}>4 hours
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cache Duration (seconds)
                                </label>
                                <select name="cache_duration" id="cache_duration"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="300"
                                        {{ ($settings->cache_duration ?? 3600) == 300 ? 'selected' : '' }}>5 minutes
                                    </option>
                                    <option value="900"
                                        {{ ($settings->cache_duration ?? 3600) == 900 ? 'selected' : '' }}>15 minutes
                                    </option>
                                    <option value="1800"
                                        {{ ($settings->cache_duration ?? 3600) == 1800 ? 'selected' : '' }}>30 minutes
                                    </option>
                                    <option value="3600"
                                        {{ ($settings->cache_duration ?? 3600) == 3600 ? 'selected' : '' }}>1 hour
                                    </option>
                                    <option value="7200"
                                        {{ ($settings->cache_duration ?? 3600) == 7200 ? 'selected' : '' }}>2 hours
                                    </option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    <input type="checkbox" name="auto_sync_enabled" id="auto_sync_enabled"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        {{ $settings->auto_sync_enabled ?? true ? 'checked' : '' }}>
                                    <label for="auto_sync_enabled"
                                        class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Enable Auto Sync
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" id="testConnectionBtn"
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                            <i class="fas fa-plug mr-2"></i>
                            Test Connection
                        </button>
                        <div class="flex space-x-3">
                            <button type="button" id="resetFormBtn"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                                <i class="fas fa-undo mr-2"></i>
                                Reset
                            </button>
                            <button type="submit" id="saveSettingsBtn"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                                <i class="fas fa-save mr-2"></i>
                                Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Help Section -->
            <div class="setting-card bg-blue-50 dark:bg-blue-900 rounded-xl shadow-lg p-6 mt-8">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 text-xl mr-3 mt-1"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Need Help?</h3>
                        <p class="text-blue-800 dark:text-blue-200 mb-4">
                            Follow our step-by-step guide to set up Instagram API integration for your school's social
                            media feed.
                        </p>
                        <div class="flex space-x-4">
                            <a href="/docs/instagram-setup"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                                <i class="fas fa-book mr-2"></i>
                                Setup Guide
                            </a>
                            <a href="/kegiatan"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                                <i class="fab fa-instagram mr-2"></i>
                                View Instagram Feed
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2024 Website Sekolah. Semua hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('instagramSettingsForm');
            const testBtn = document.getElementById('testConnectionBtn');
            const saveBtn = document.getElementById('saveSettingsBtn');
            const syncBtn = document.getElementById('syncBtn');
            const deactivateBtn = document.getElementById('deactivateBtn');
            const resetBtn = document.getElementById('resetFormBtn');

            // Test Connection
            testBtn.addEventListener('click', function() {
                const accessToken = document.getElementById('access_token').value;
                const userId = document.getElementById('user_id').value;

                if (!accessToken || !userId) {
                    showNotification('Please fill in Access Token and User ID first', 'error');
                    return;
                }

                testBtn.disabled = true;
                testBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Testing...';

                fetch('/superadmin/instagram-settings/test-connection', {
                        method: 'POST',
                        body: JSON.stringify({
                            access_token: accessToken,
                            user_id: userId
                        }),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        showNotification(data.message, data.success ? 'success' : 'error');
                        if (data.success && data.account_info) {
                            showAccountInfo(data.account_info);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Connection test failed', 'error');
                    })
                    .finally(() => {
                        testBtn.disabled = false;
                        testBtn.innerHTML = '<i class="fas fa-plug mr-2"></i>Test Connection';
                    });
            });

            // Save Settings
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                saveBtn.disabled = true;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';

                const formData = new FormData(form);

                fetch('/superadmin/instagram-settings', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        showNotification(data.message, data.success ? 'success' : 'error');
                        if (data.success) {
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Failed to save settings', 'error');
                    })
                    .finally(() => {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Save Settings';
                    });
            });

            // Sync Data
            if (syncBtn) {
                syncBtn.addEventListener('click', function() {
                    syncBtn.disabled = true;
                    syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Syncing...';

                    fetch('/superadmin/instagram-settings/sync', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            showNotification(data.message, data.success ? 'success' : 'error');
                            if (data.success) {
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Sync failed', 'error');
                        })
                        .finally(() => {
                            syncBtn.disabled = false;
                            syncBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Sync Now';
                        });
                });
            }

            // Deactivate
            if (deactivateBtn) {
                deactivateBtn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to deactivate Instagram integration?')) {
                        deactivateBtn.disabled = true;
                        deactivateBtn.innerHTML =
                            '<i class="fas fa-spinner fa-spin mr-2"></i>Deactivating...';

                        fetch('/superadmin/instagram-settings/deactivate', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                showNotification(data.message, data.success ? 'success' : 'error');
                                if (data.success) {
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('Deactivation failed', 'error');
                            })
                            .finally(() => {
                                deactivateBtn.disabled = false;
                                deactivateBtn.innerHTML =
                                    '<i class="fas fa-power-off mr-2"></i>Deactivate';
                            });
                    }
                });
            }

            // Reset Form
            resetBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to reset the form?')) {
                    form.reset();
                }
            });

            // Helper functions
            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-lg text-white ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                }`;
                notification.textContent = message;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 5000);
            }

            function showAccountInfo(accountInfo) {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full mx-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Information</h3>
                        <div class="space-y-2">
                            <p><strong>Username:</strong> ${accountInfo.username || 'N/A'}</p>
                            <p><strong>Account Type:</strong> ${accountInfo.account_type || 'N/A'}</p>
                            <p><strong>Media Count:</strong> ${accountInfo.media_count || 'N/A'}</p>
                        </div>
                        <button onclick="this.closest('.fixed').remove()" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                            Close
                        </button>
                    </div>
                `;
                document.body.appendChild(modal);
            }
        });
    </script>
</body>

</html>
