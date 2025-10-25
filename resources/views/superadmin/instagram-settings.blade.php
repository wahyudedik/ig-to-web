<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    <i class="fab fa-instagram mr-2"
                        style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    Instagram Settings
                </h1>
                <p class="text-slate-600 mt-1">Configure Instagram API integration for social media feed</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('docs.instagram-setup') }}" class="btn btn-secondary">
                    <i class="fas fa-book mr-2"></i>
                    Setup Guide
                </a>
                <a href="{{ route('public.kegiatan') }}" class="btn btn-secondary">
                    <i class="fas fa-images mr-2"></i>
                    View Feed
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Current Status -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div
                        class="w-12 h-12 {{ $settings && $settings->is_active ? 'bg-green-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                        <div
                            class="status-indicator {{ $settings && $settings->is_active ? 'status-active' : 'status-inactive' }}">
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Instagram Integration Status
                        </h3>
                        <p class="text-sm text-slate-600">
                            @if ($settings && $settings->is_active)
                                <span class="font-medium text-green-600">Active</span>
                                @if ($settings->username)
                                    - Connected as <span class="font-medium">@{{ $settings - > username }}</span>
                                @endif
                                @if ($settings->account_type)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 ml-2">
                                        {{ $settings->account_type }}
                                    </span>
                                @endif
                                <br>
                                <span class="text-xs">Last sync:
                                    {{ $settings->last_sync ? $settings->last_sync->diffForHumans() : 'Never' }}</span>
                            @else
                                Inactive - No Instagram integration configured
                            @endif
                        </p>

                        @if ($settings && $settings->is_active && $settings->token_expires_at)
                            @if ($settings->isTokenExpired())
                                <div class="mt-2 flex items-center text-red-600 text-xs">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Token expired on {{ $settings->token_expires_at->format('M d, Y') }}. Please update
                                    your access token.
                                </div>
                            @elseif ($settings->isTokenExpiringSoon())
                                <div class="mt-2 flex items-center text-orange-600 text-xs">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Token will expire on {{ $settings->token_expires_at->format('M d, Y') }}. Consider
                                    refreshing soon.
                                </div>
                            @else
                                <div class="mt-2 flex items-center text-green-600 text-xs">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Token valid until {{ $settings->token_expires_at->format('M d, Y') }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="flex space-x-3">
                    @if ($settings && $settings->is_active)
                        <button id="syncBtn" class="btn btn-success">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Sync Now
                        </button>
                        <button id="deactivateBtn" class="btn btn-danger">
                            <i class="fas fa-power-off mr-2"></i>
                            Deactivate
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-6">Instagram API Configuration</h3>

            <form id="instagramSettingsForm" class="space-y-6">
                <!-- API Credentials -->

                @if ($urlAccessToken)
                    <!-- OAuth Success Alert -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-0.5 mr-3"></i>
                            <div class="text-sm text-green-800">
                                <p class="font-medium mb-1">✅ Access Token Berhasil Didapatkan!</p>
                                <p>Sekarang masukkan <strong>User ID</strong> (Instagram Account ID seperti
                                    17841428646148329 yang tertera di Meta Dashboard), lalu klik <strong>Test
                                        Connection</strong> untuk verifikasi, kemudian <strong>Save Settings</strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Info Alert -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Instagram Platform API dengan Instagram Login</p>
                            <p>Dapatkan Access Token dan User ID dari <strong>Instagram Platform API</strong> (bukan
                                Basic Display API).
                                Lihat <a href="{{ route('docs.instagram-setup') }}" class="underline font-medium">Setup
                                    Guide</a> untuk panduan lengkap.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Access Token <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="access_token" id="access_token" class="form-input"
                            placeholder="Enter Instagram User Access Token"
                            value="@if (isset($urlAccessToken) && $urlAccessToken) {{ $urlAccessToken }}@elseif(isset($settings) && $settings && $settings->access_token){{ $settings->access_token }}@else{{ $envDefaults['access_token'] ?? '' }} @endif"
                            required>
                        <p class="text-xs text-slate-500 mt-1">
                            <i class="fas fa-key mr-1"></i>
                            Instagram User Access Token dari Business Login
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            User ID <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="user_id" id="user_id" class="form-input"
                            placeholder="Enter Instagram Professional Account ID (contoh: 17841428646148329)"
                            value="@if (isset($urlUserId) && $urlUserId) {{ $urlUserId }}@elseif(isset($settings) && $settings && $settings->user_id){{ $settings->user_id }}@else{{ $envDefaults['user_id'] ?? '' }} @endif"
                            required>
                        <p class="text-xs text-slate-500 mt-1">
                            <i class="fas fa-user mr-1"></i>
                            Instagram Business/Creator Account ID (bukan Facebook Page ID). <strong>Contoh:
                                17841428646148329</strong> (lihat di Meta Dashboard)
                        </p>
                    </div>
                </div>

                <!-- Optional Settings -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            App ID
                        </label>
                        <input type="text" name="app_id" id="app_id" class="form-input"
                            placeholder="Enter Instagram App ID (e.g., 1575539400487129)"
                            value="{{ $settings->app_id ?? ($envDefaults['app_id'] ?? '') }}">
                        <p class="text-xs text-slate-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Optional: Instagram App ID dari Meta Dashboard
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            App Secret
                        </label>
                        <div class="relative">
                            <input type="password" name="app_secret" id="app_secret" class="form-input pr-10"
                                placeholder="Enter Instagram App Secret (e.g., 7b6f727ebfd70...)"
                                value="{{ $settings->app_secret ?? ($envDefaults['app_secret'] ?? '') }}">
                            <button type="button" id="toggleAppSecret"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="fas fa-eye" id="appSecretIcon"></i>
                            </button>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Optional: Instagram App Secret dari Meta Dashboard
                        </p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Redirect URI
                    </label>
                    <input type="url" name="redirect_uri" id="redirect_uri" class="form-input"
                        placeholder="{{ url('/instagram/callback') }}"
                        value="{{ $settings->redirect_uri ?? url('/instagram/callback') }}">
                    <p class="text-xs text-slate-500 mt-1">
                        <i class="fas fa-link mr-1"></i>
                        URL callback untuk OAuth. Harus sama dengan yang di-setup di Meta Dashboard.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Webhook Verify Token
                    </label>
                    <input type="text" name="webhook_verify_token" id="webhook_verify_token" class="form-input"
                        placeholder="Enter webhook verify token (e.g., mySchoolWebhook2025)"
                        value="{{ $settings->webhook_verify_token ?? ($envDefaults['webhook_verify_token'] ?? 'mySchoolWebhook2025') }}">
                    <p class="text-xs text-slate-500 mt-1">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Secret token untuk verifikasi webhook dari Meta. Buat token unik sendiri.
                    </p>
                    <div class="mt-2 p-3 bg-amber-50 border border-amber-200 rounded-md">
                        <p class="text-xs text-amber-800">
                            <i class="fas fa-lightbulb mr-1"></i>
                            <strong>Webhook URL:</strong> <code
                                class="bg-amber-100 px-2 py-1 rounded">{{ url('/instagram/webhook') }}</code>
                            <br>
                            Gunakan URL dan token ini di Meta Dashboard → Konfigurasi webhook
                        </p>
                    </div>
                </div>

                <!-- Sync Settings -->
                <div class="border-t border-slate-200 pt-6">
                    <h4 class="text-md font-semibold text-slate-900 mb-4">Sync Settings</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Sync Frequency (minutes)
                            </label>
                            <select name="sync_frequency" id="sync_frequency" class="form-select">
                                <option value="5" {{ ($settings->sync_frequency ?? 30) == 5 ? 'selected' : '' }}>
                                    5
                                    minutes</option>
                                <option value="15"
                                    {{ ($settings->sync_frequency ?? 30) == 15 ? 'selected' : '' }}>
                                    15 minutes</option>
                                <option value="30"
                                    {{ ($settings->sync_frequency ?? 30) == 30 ? 'selected' : '' }}>
                                    30 minutes</option>
                                <option value="60"
                                    {{ ($settings->sync_frequency ?? 30) == 60 ? 'selected' : '' }}>
                                    1 hour</option>
                                <option value="120"
                                    {{ ($settings->sync_frequency ?? 30) == 120 ? 'selected' : '' }}>2 hours</option>
                                <option value="240"
                                    {{ ($settings->sync_frequency ?? 30) == 240 ? 'selected' : '' }}>4 hours</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Cache Duration (seconds)
                            </label>
                            <select name="cache_duration" id="cache_duration" class="form-select">
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
                                    {{ ($settings->cache_duration ?? 3600) == 3600 ? 'selected' : '' }}>1 hour</option>
                                <option value="7200"
                                    {{ ($settings->cache_duration ?? 3600) == 7200 ? 'selected' : '' }}>2 hours
                                </option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label class="flex items-center">
                                <input type="checkbox" name="auto_sync_enabled" id="auto_sync_enabled"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    {{ $settings->auto_sync_enabled ?? true ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-slate-700">
                                    Enable Auto Sync
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-slate-200">
                    <button type="button" id="testConnectionBtn" class="btn btn-warning">
                        <i class="fas fa-plug mr-2"></i>
                        Test Connection
                    </button>
                    <div class="flex space-x-3">
                        <button type="button" id="resetFormBtn" class="btn btn-secondary">
                            <i class="fas fa-undo mr-2"></i>
                            Reset
                        </button>
                        <button type="submit" id="saveSettingsBtn" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Save Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="bg-blue-50 rounded-xl border border-blue-200 p-6 mt-8">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-1"></i>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Need Help?</h3>
                    <p class="text-blue-800 mb-4">
                        Follow our step-by-step guide to set up Instagram API integration for your school's social media
                        feed.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('docs.instagram-setup') }}" class="btn btn-primary">
                            <i class="fas fa-book mr-2"></i>
                            Setup Guide
                        </a>
                        <a href="{{ route('public.kegiatan') }}" class="btn btn-success">
                            <i class="fas fa-images mr-2"></i>
                            View Instagram Feed
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .status-indicator {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                display: inline-block;
            }

            .status-active {
                background-color: #10b981;
                animation: pulse 2s infinite;
            }

            .status-inactive {
                background-color: #ef4444;
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
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('instagramSettingsForm');
                const testBtn = document.getElementById('testConnectionBtn');
                const saveBtn = document.getElementById('saveSettingsBtn');
                const syncBtn = document.getElementById('syncBtn');
                const deactivateBtn = document.getElementById('deactivateBtn');
                const resetBtn = document.getElementById('resetFormBtn');

                // Toggle App Secret visibility
                const toggleAppSecretBtn = document.getElementById('toggleAppSecret');
                const appSecretInput = document.getElementById('app_secret');
                const appSecretIcon = document.getElementById('appSecretIcon');

                console.log('Toggle App Secret elements:', {
                    btn: !!toggleAppSecretBtn,
                    input: !!appSecretInput,
                    icon: !!appSecretIcon
                });

                if (toggleAppSecretBtn && appSecretInput && appSecretIcon) {
                    toggleAppSecretBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        console.log('Toggle clicked, current type:', appSecretInput.type);

                        if (appSecretInput.type === 'password') {
                            appSecretInput.type = 'text';
                            appSecretIcon.classList.remove('fa-eye');
                            appSecretIcon.classList.add('fa-eye-slash');
                            console.log('Changed to text');
                        } else {
                            appSecretInput.type = 'password';
                            appSecretIcon.classList.remove('fa-eye-slash');
                            appSecretIcon.classList.add('fa-eye');
                            console.log('Changed to password');
                        }
                    });
                    console.log('✅ Toggle App Secret initialized successfully');
                } else {
                    console.error('❌ Toggle App Secret elements not found!');
                }

                // Test Connection
                testBtn.addEventListener('click', function() {
                    const accessToken = document.getElementById('access_token').value;
                    const userId = document.getElementById('user_id').value;

                    console.log('Test Connection clicked', {
                        accessToken: accessToken ? 'Set (length: ' + accessToken.length + ')' : 'Empty',
                        userId: userId ? 'Set: ' + userId : 'Empty'
                    });

                    if (!accessToken || !userId) {
                        showError('Error', 'Harap isi Access Token dan User ID terlebih dahulu');
                        return;
                    }

                    testBtn.disabled = true;
                    testBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Testing...';
                    showLoading('Menguji koneksi...', 'Menghubungi Instagram API');

                    fetch('{{ route('admin.superadmin.instagram-settings.test-connection') }}', {
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
                        .then(response => {
                            console.log('Response status:', response.status);
                            console.log('Response headers:', response.headers.get('content-type'));

                            // Check if response is JSON
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            } else {
                                // Not JSON, probably redirected to login or error page
                                throw new Error('Response is not JSON. Status: ' + response.status +
                                    '. You may have been logged out.');
                            }
                        })
                        .then(data => {
                            closeLoading();
                            console.log('Response data:', data);

                            if (data.success) {
                                showSuccess('Koneksi Berhasil!', data.message);
                                if (data.account_info) {
                                    setTimeout(() => showAccountInfo(data.account_info), 500);
                                }
                            } else {
                                showError('Koneksi Gagal', data.message || 'Periksa kredensial Anda');
                            }
                        })
                        .catch(error => {
                            closeLoading();
                            console.error('Connection test error:', error);

                            // More helpful error message
                            if (error.message.includes('logged out')) {
                                showError('Session Expired',
                                    'Anda mungkin ter-logout. Silakan refresh halaman dan login kembali.<br><br>' +
                                    '<button onclick="window.location.reload()" class="btn btn-primary mt-2">Refresh Halaman</button>'
                                );
                            } else {
                                showError('Koneksi Gagal',
                                    'Terjadi kesalahan: ' + error.message +
                                    '<br>Cek console (F12) untuk detail.'
                                );
                            }
                        })
                        .finally(() => {
                            testBtn.disabled = false;
                            testBtn.innerHTML = '<i class="fas fa-plug mr-2"></i>Test Connection';
                        });
                });

                // Save Settings
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    console.log('Save Settings form submitted');

                    const accessToken = document.getElementById('access_token').value;
                    const userId = document.getElementById('user_id').value;

                    if (!accessToken || !userId) {
                        showError('Error', 'Access Token dan User ID wajib diisi');
                        return;
                    }

                    saveBtn.disabled = true;
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
                    showLoading('Menyimpan pengaturan...', 'Mohon tunggu');

                    const formData = new FormData(form);

                    // Log form data for debugging
                    console.log('Form data:', {
                        access_token: accessToken ? 'Set (length: ' + accessToken.length + ')' :
                            'Empty',
                        user_id: userId,
                        app_id: formData.get('app_id') || 'Not set',
                        app_secret: formData.get('app_secret') ? 'Set (length: ' + formData.get(
                            'app_secret').length + ')' : 'Not set',
                        redirect_uri: formData.get('redirect_uri') || 'Not set',
                        webhook_verify_token: formData.get('webhook_verify_token') || 'Not set',
                        sync_frequency: formData.get('sync_frequency'),
                        cache_duration: formData.get('cache_duration'),
                        auto_sync_enabled: formData.get('auto_sync_enabled')
                    });

                    fetch('{{ route('admin.superadmin.instagram-settings.store') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => {
                            console.log('Save response status:', response.status);
                            console.log('Save response headers:', response.headers.get('content-type'));

                            // Check if response is JSON
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            } else {
                                // Not JSON, probably redirected to login or error page
                                throw new Error('Response is not JSON. Status: ' + response.status +
                                    '. You may have been logged out.');
                            }
                        })
                        .then(data => {
                            closeLoading();
                            console.log('Save response data:', data);

                            if (data.success) {
                                showSuccess('Pengaturan Tersimpan!', data.message).then(() => {
                                    // Clean URL (remove access_token parameter) before reload
                                    window.location.href =
                                        '{{ route('admin.superadmin.instagram-settings') }}';
                                });
                            } else {
                                showError('Gagal Menyimpan', data.message || 'Terjadi kesalahan');
                            }
                        })
                        .catch(error => {
                            closeLoading();
                            console.error('Save error:', error);

                            // More helpful error message
                            if (error.message.includes('logged out')) {
                                showError('Session Expired',
                                    'Anda mungkin ter-logout. Silakan refresh halaman dan login kembali.<br><br>' +
                                    '<button onclick="window.location.reload()" class="btn btn-primary mt-2">Refresh Halaman</button>'
                                );
                            } else {
                                showError('Gagal Menyimpan',
                                    'Terjadi kesalahan: ' + error.message +
                                    '<br>Cek console (F12) untuk detail.'
                                );
                            }
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
                        showLoading();

                        fetch('{{ route('admin.superadmin.instagram-settings.sync') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                closeLoading();
                                if (data.success) {
                                    showSuccess(data.message).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    showError(data.message);
                                }
                            })
                            .catch(error => {
                                closeLoading();
                                console.error('Error:', error);
                                showError('Sync failed');
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
                        showConfirm(
                            'Konfirmasi',
                            'Apakah Anda yakin ingin menonaktifkan integrasi Instagram?',
                            'Ya, Nonaktifkan',
                            'Batal'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                deactivateBtn.disabled = true;
                                deactivateBtn.innerHTML =
                                    '<i class="fas fa-spinner fa-spin mr-2"></i>Deactivating...';

                                fetch('{{ route('admin.superadmin.instagram-settings.deactivate') }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                    'meta[name="csrf-token"]')
                                                .getAttribute('content')
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            showSuccess(data.message).then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            showError(data.message);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        showError('Deactivation failed');
                                    })
                                    .finally(() => {
                                        deactivateBtn.disabled = false;
                                        deactivateBtn.innerHTML =
                                            '<i class="fas fa-power-off mr-2"></i>Deactivate';
                                    });
                            }
                        });
                    });
                }

                // Reset Form
                resetBtn.addEventListener('click', function() {
                    showConfirm(
                        'Konfirmasi',
                        'Apakah Anda yakin ingin mereset form?',
                        'Ya, Reset',
                        'Batal'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            form.reset();
                            showSuccess('Form berhasil direset');
                        }
                    });
                });

                // Helper functions
                function showAccountInfo(accountInfo) {
                    const modal = document.createElement('div');
                    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                    modal.innerHTML = `
                    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Account Information</h3>
                        <div class="space-y-2">
                            <p class="text-slate-700"><strong>Username:</strong> ${accountInfo.username || 'N/A'}</p>
                            <p class="text-slate-700"><strong>Account Type:</strong> ${accountInfo.account_type || 'N/A'}</p>
                            <p class="text-slate-700"><strong>Media Count:</strong> ${accountInfo.media_count || 'N/A'}</p>
                        </div>
                        <button onclick="this.closest('.fixed').remove()" class="mt-4 btn btn-primary">
                            Close
                        </button>
                    </div>
                `;
                    document.body.appendChild(modal);
                }
            });
        </script>
    @endpush
</x-app-layout>
