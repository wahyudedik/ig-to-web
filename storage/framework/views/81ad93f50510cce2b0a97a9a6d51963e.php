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
                <h1 class="text-3xl font-bold text-slate-900 flex items-center">
                    <i class="fab fa-instagram mr-3"
                        style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    Instagram Integration
                </h1>
                <p class="text-slate-500 mt-1.5 text-sm">Manage your Instagram feed connection</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('docs.instagram-setup')); ?>"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                    <i class="fas fa-book mr-2 text-slate-500"></i>
                    Guide
                </a>
                <a href="<?php echo e(route('public.kegiatan')); ?>"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                    <i class="fas fa-images mr-2 text-slate-500"></i>
                    Feed
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
            <div class="px-6 py-5 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <?php if($settings && $settings->is_active): ?>
                            <div class="relative">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fab fa-instagram text-2xl text-green-600"></i>
                                </div>
                                <div
                                    class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white status-pulse">
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="text-lg font-semibold text-slate-900">Connected</h3>
                                    <?php if($settings->account_type): ?>
                                        <span
                                            class="px-2 py-0.5 bg-purple-50 text-purple-700 text-xs font-medium rounded-md">
                                            <?php echo e($settings->account_type); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php if($settings->username): ?>
                                    <p class="text-sm text-slate-600">{{ $settings - > username }}</p>
                                <?php endif; ?>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    Last sync:
                                    <?php echo e($settings->last_sync ? $settings->last_sync->diffForHumans() : 'Never'); ?>

                                </p>
                            </div>
                        <?php else: ?>
                            <div class="w-14 h-14 bg-slate-50 rounded-xl flex items-center justify-center">
                                <i class="fab fa-instagram text-2xl text-slate-300"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Not Connected</h3>
                                <p class="text-sm text-slate-500">Configure Instagram integration below</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($settings && $settings->is_active): ?>
                        <div class="flex gap-2">
                            <button id="syncBtn"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Sync
                            </button>
                            <button id="deactivateBtn"
                                class="inline-flex items-center px-4 py-2 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-power-off mr-2"></i>
                                Disconnect
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($settings && $settings->is_active && $settings->token_expires_at): ?>
                <div
                    class="px-6 py-3 <?php echo e($settings->isTokenExpired() ? 'bg-red-50' : ($settings->isTokenExpiringSoon() ? 'bg-amber-50' : 'bg-green-50')); ?>">
                    <div class="flex items-center text-sm">
                        <?php if($settings->isTokenExpired()): ?>
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <span class="text-red-700">Token expired on
                                <?php echo e($settings->token_expires_at->format('M d, Y')); ?> - Please update your access
                                token</span>
                        <?php elseif($settings->isTokenExpiringSoon()): ?>
                            <i class="fas fa-exclamation-circle text-amber-500 mr-2"></i>
                            <span class="text-amber-700">Token expires on
                                <?php echo e($settings->token_expires_at->format('M d, Y')); ?> - Consider refreshing</span>
                        <?php else: ?>
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-green-700">Token valid until
                                <?php echo e($settings->token_expires_at->format('M d, Y')); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <form id="instagramSettingsForm" class="space-y-4">
            <?php if($urlAccessToken): ?>
                <!-- Success Alert -->
                <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                    <div class="flex gap-3">
                        <i class="fas fa-check-circle text-green-600 text-lg mt-0.5"></i>
                        <div class="text-sm">
                            <p class="font-semibold text-green-900 mb-1">Access Token Retrieved</p>
                            <p class="text-green-700">Now enter your <strong>User ID</strong>, test the connection, then
                                save.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Info Alert -->
            <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                <div class="flex gap-3">
                    <i class="fas fa-info-circle text-blue-600 text-lg mt-0.5"></i>
                    <div class="text-sm">
                        <p class="font-semibold text-blue-900 mb-1">Using Instagram Business Login (Updated Jan 2025)
                        </p>
                        <p class="text-blue-700">Use Instagram Business Login with new scopes or enter credentials
                            manually.
                            <a href="<?php echo e(route('docs.instagram-setup')); ?>"
                                class="underline font-semibold hover:text-blue-900">View setup guide</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- NEW: Quick Setup with OAuth -->
            <?php if($authorizationUrl && !($settings && $settings->is_active)): ?>
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border-2 border-purple-200 p-6">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-bolt text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">
                                <i class="fas fa-sparkles text-purple-500 mr-1"></i>
                                Quick Setup (Recommended)
                            </h3>
                            <p class="text-sm text-slate-700 mb-4">
                                Authorize with Instagram Business Login to automatically get your 60-day access token.
                                This is the easiest way to connect your Instagram Professional account.
                            </p>

                            <div class="flex flex-wrap items-center gap-3">
                                <a href="<?php echo e($authorizationUrl); ?>"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold rounded-xl transition-all transform hover:scale-105 shadow-lg">
                                    <i class="fab fa-instagram text-xl mr-2"></i>
                                    Connect with Instagram
                                </a>

                                <button type="button"
                                    onclick="document.getElementById('manualSetup').scrollIntoView({behavior: 'smooth'})"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-lg transition-colors">
                                    <i class="fas fa-keyboard mr-2"></i>
                                    Or enter manually
                                </button>
                            </div>

                            <div class="mt-4 p-3 bg-white/50 rounded-lg border border-purple-200">
                                <p class="text-xs text-slate-600">
                                    <i class="fas fa-shield-alt text-purple-600 mr-1"></i>
                                    <strong>New scopes (Jan 27, 2025 update):</strong> instagram_business_basic,
                                    instagram_business_content_publish, instagram_business_manage_comments,
                                    instagram_business_manage_messages
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($urlPermissions): ?>
                <!-- OAuth Success Info -->
                <div class="bg-green-50 rounded-xl p-4 border-2 border-green-200">
                    <div class="flex gap-3">
                        <i class="fas fa-check-circle text-green-600 text-xl mt-0.5"></i>
                        <div class="text-sm flex-1">
                            <p class="font-bold text-green-900 mb-2">Authorization Successful!</p>
                            <p class="text-green-700 mb-2">Permissions granted: <code
                                    class="bg-white px-2 py-1 rounded text-xs"><?php echo e(is_array($urlPermissions) ? implode(', ', $urlPermissions) : $urlPermissions); ?></code>
                            </p>
                            <?php if($urlExpiresIn): ?>
                                <p class="text-green-700">Token valid for: <strong><?php echo e(floor($urlExpiresIn / 86400)); ?>

                                        days</strong></p>
                            <?php endif; ?>
                            <p class="text-green-800 font-semibold mt-3">
                                <i class="fas fa-arrow-down mr-1"></i>
                                Now click "Test Connection" below, then "Save Settings"
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div id="manualSetup"></div>

            <!-- Card 1: Required Credentials -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex items-center gap-3 mb-4">
                    <span
                        class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center text-sm font-bold">1</span>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Access Credentials</h3>
                        <p class="text-xs text-slate-500">
                            <span class="font-semibold text-blue-600">Option A:</span> Use OAuth (skip this, fill Card 2
                            instead) |
                            <span class="font-semibold text-slate-600">Option B:</span> Enter manually (fill both
                            fields)
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Access Token <span class="text-slate-400 text-xs">(required for manual setup)</span>
                        </label>
                        <input type="text" name="access_token" id="access_token"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm"
                            placeholder="IGAAW... (leave empty if using OAuth)"
                            value="<?php if(isset($urlAccessToken) && $urlAccessToken): ?> <?php echo e($urlAccessToken); ?><?php elseif(isset($settings) && $settings && $settings->access_token): ?><?php echo e($settings->access_token); ?> <?php endif; ?>">
                        <p class="text-xs text-slate-500 mt-1.5">
                            <i class="fas fa-info-circle text-blue-500"></i>
                            Long-lived user access token from Instagram Platform API
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Instagram User ID <span class="text-slate-400 text-xs">(required for manual setup)</span>
                        </label>
                        <input type="text" name="user_id" id="user_id"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm"
                            placeholder="17841428646148329 (leave empty if using OAuth)"
                            value="<?php if(isset($urlUserId) && $urlUserId): ?> <?php echo e($urlUserId); ?><?php elseif(isset($settings) && $settings && $settings->user_id): ?><?php echo e($settings->user_id); ?> <?php endif; ?>">
                        <p class="text-xs text-slate-500 mt-1.5">
                            <i class="fas fa-info-circle text-blue-500"></i>
                            Instagram Business/Creator Account ID from Meta Dashboard
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Sync & Cache Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex items-center gap-3 mb-4">
                    <span
                        class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center text-sm font-bold">2</span>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Sync & Cache Settings</h3>
                        <p class="text-xs text-slate-500">Configure automatic synchronization and caching</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Sync Frequency</label>
                        <select name="sync_frequency" id="sync_frequency"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm">
                            <option value="5" <?php echo e(($settings->sync_frequency ?? 30) == 5 ? 'selected' : ''); ?>>
                                Every 5 minutes</option>
                            <option value="15" <?php echo e(($settings->sync_frequency ?? 30) == 15 ? 'selected' : ''); ?>>
                                Every 15 minutes</option>
                            <option value="30" <?php echo e(($settings->sync_frequency ?? 30) == 30 ? 'selected' : ''); ?>>
                                Every 30 minutes</option>
                            <option value="60" <?php echo e(($settings->sync_frequency ?? 30) == 60 ? 'selected' : ''); ?>>
                                Every hour</option>
                            <option value="120" <?php echo e(($settings->sync_frequency ?? 30) == 120 ? 'selected' : ''); ?>>
                                Every 2 hours</option>
                            <option value="240" <?php echo e(($settings->sync_frequency ?? 30) == 240 ? 'selected' : ''); ?>>
                                Every 4 hours</option>
                        </select>
                        <p class="text-xs text-slate-500 mt-1.5">How often to fetch new posts</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Cache Duration</label>
                        <select name="cache_duration" id="cache_duration"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm">
                            <option value="300" <?php echo e(($settings->cache_duration ?? 3600) == 300 ? 'selected' : ''); ?>>
                                5 minutes</option>
                            <option value="900" <?php echo e(($settings->cache_duration ?? 3600) == 900 ? 'selected' : ''); ?>>
                                15 minutes</option>
                            <option value="1800"
                                <?php echo e(($settings->cache_duration ?? 3600) == 1800 ? 'selected' : ''); ?>>30 minutes</option>
                            <option value="3600"
                                <?php echo e(($settings->cache_duration ?? 3600) == 3600 ? 'selected' : ''); ?>>1 hour</option>
                            <option value="7200"
                                <?php echo e(($settings->cache_duration ?? 3600) == 7200 ? 'selected' : ''); ?>>2 hours</option>
                        </select>
                        <p class="text-xs text-slate-500 mt-1.5">Cache lifetime for performance</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Auto Sync</label>
                        <div class="h-[42px] flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="auto_sync_enabled" id="auto_sync_enabled"
                                    class="sr-only peer" <?php echo e($settings->auto_sync_enabled ?? true ? 'checked' : ''); ?>>
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-slate-700">Enable</span>
                            </label>
                        </div>
                        <p class="text-xs text-slate-500 mt-1.5">Automatic background sync</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Card -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                    <button type="button" id="testConnectionBtn"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-amber-50 border-2 border-amber-400 hover:bg-amber-100 text-amber-700 font-semibold rounded-lg transition-all">
                        <i class="fas fa-plug mr-2"></i>
                        Test Connection
                    </button>
                    <div class="flex gap-3 w-full sm:w-auto">
                        <button type="button" id="resetFormBtn"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 py-2.5 bg-white border-2 border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold rounded-lg transition-all">
                            <i class="fas fa-undo mr-2"></i>
                            Reset
                        </button>
                        <button type="submit" id="saveSettingsBtn"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all shadow-lg shadow-blue-500/30">
                            <i class="fas fa-save mr-2"></i>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Help Section -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 p-6 mt-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-question-circle text-blue-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-blue-900 mb-1">Need Help?</h3>
                    <p class="text-sm text-blue-700 mb-4">
                        Follow our comprehensive guide for Instagram API integration setup
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <a href="<?php echo e(route('docs.instagram-setup')); ?>"
                            class="inline-flex items-center px-4 py-2 bg-white hover:bg-blue-50 border border-blue-200 text-blue-700 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-book mr-2"></i>
                            Setup Guide
                        </a>
                        <a href="<?php echo e(route('public.kegiatan')); ?>"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-images mr-2"></i>
                            View Feed
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
        <style>
            /* Status pulse animation */
            .status-pulse {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                    transform: scale(1.05);
                }
            }

            /* Smooth transitions for inputs */
            input:focus,
            select:focus,
            textarea:focus {
                outline: none;
            }

            /* Custom scrollbar for better aesthetics */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('🚀 Instagram Settings JS Loaded');

                const form = document.getElementById('instagramSettingsForm');
                const testBtn = document.getElementById('testConnectionBtn');
                const saveBtn = document.getElementById('saveSettingsBtn');
                const syncBtn = document.getElementById('syncBtn');
                const deactivateBtn = document.getElementById('deactivateBtn');
                const resetBtn = document.getElementById('resetFormBtn');

                console.log('📋 Form elements:', {
                    form: !!form,
                    testBtn: !!testBtn,
                    saveBtn: !!saveBtn,
                    syncBtn: !!syncBtn,
                    deactivateBtn: !!deactivateBtn,
                    resetBtn: !!resetBtn
                });

                if (!form) {
                    console.error('❌ Form not found!');
                    return;
                }

                if (!saveBtn) {
                    console.error('❌ Save button not found!');
                    return;
                }

                // Toggle App Secret visibility - Simple & Reliable
                const toggleAppSecretBtn = document.getElementById('toggleAppSecret');
                const appSecretInput = document.getElementById('app_secret');
                const appSecretIcon = document.getElementById('appSecretIcon');

                console.log('🔍 Checking Toggle App Secret elements:', {
                    btn: !!toggleAppSecretBtn,
                    input: !!appSecretInput,
                    icon: !!appSecretIcon
                });

                if (toggleAppSecretBtn && appSecretInput && appSecretIcon) {
                    // Remove any existing listeners
                    const newToggleBtn = toggleAppSecretBtn.cloneNode(true);
                    toggleAppSecretBtn.parentNode.replaceChild(newToggleBtn, toggleAppSecretBtn);

                    const newIcon = appSecretIcon.cloneNode(true);
                    newToggleBtn.innerHTML = '';
                    newToggleBtn.appendChild(newIcon);

                    newToggleBtn.addEventListener('click', function(event) {
                        event.preventDefault();
                        event.stopPropagation();

                        console.log('👁️ Toggle clicked! Current type:', appSecretInput.type);

                        if (appSecretInput.type === 'password') {
                            appSecretInput.type = 'text';
                            newIcon.className = 'fas fa-eye-slash';
                            console.log('✅ Changed to visible (text)');
                        } else {
                            appSecretInput.type = 'password';
                            newIcon.className = 'fas fa-eye';
                            console.log('✅ Changed to hidden (password)');
                        }
                    }, {
                        passive: false
                    });

                    console.log('✅ Toggle App Secret initialized successfully');
                } else {
                    console.error('❌ Toggle App Secret elements not found!', {
                        btn: toggleAppSecretBtn,
                        input: appSecretInput,
                        icon: appSecretIcon
                    });
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

                    fetch('<?php echo e(route('admin.superadmin.instagram-settings.test-connection')); ?>', {
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

                // Save Settings - USE CAPTURE PHASE for priority
                form.addEventListener('submit', function(e) {
                    console.log('📝 Form submit event triggered');

                    // CRITICAL: Prevent default IMMEDIATELY
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();

                    console.log('✅ Default prevented - processing form');
                    console.log('Save Settings form submitted');

                    const accessToken = document.getElementById('access_token').value.trim();
                    const userId = document.getElementById('user_id').value.trim();

                    // Simplified validation
                    // If access_token is provided, user_id must also be provided (manual token setup)
                    if (accessToken && !userId) {
                        showError('Incomplete Manual Setup',
                            'If you provide an Access Token, you must also provide the User ID.'
                        );
                        return;
                    }

                    if (userId && !accessToken) {
                        showError('Incomplete Manual Setup',
                            'If you provide a User ID, you must also provide the Access Token.'
                        );
                        return;
                    }

                    console.log('✅ Validation passed, proceeding to save');

                    saveBtn.disabled = true;
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
                    showLoading('Menyimpan pengaturan...', 'Mohon tunggu');

                    const formData = new FormData(form);

                    // Log form data for debugging
                    console.log('Form data:', {
                        has_access_token: !!accessToken,
                        has_user_id: !!userId,
                        sync_frequency: formData.get('sync_frequency'),
                        cache_duration: formData.get('cache_duration'),
                        auto_sync_enabled: formData.get('auto_sync_enabled')
                    });

                    fetch('<?php echo e(route('admin.superadmin.instagram-settings.store')); ?>', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            console.log('Save response status:', response.status);
                            console.log('Save response headers:', response.headers.get('content-type'));

                            // Check if response is JSON
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json().then(data => ({
                                    status: response.status,
                                    ok: response.ok,
                                    data: data
                                }));
                            } else {
                                // Not JSON, probably redirected to login or error page
                                throw new Error('Response is not JSON. Status: ' + response.status +
                                    '. You may have been logged out.');
                            }
                        })
                        .then(result => {
                            closeLoading();
                            console.log('Save response data:', result.data);

                            // Handle validation errors (422)
                            if (result.status === 422) {
                                const errors = result.data.errors || {};
                                let errorList = '<ul class="text-left">';
                                for (let field in errors) {
                                    errorList += `<li><strong>${field}:</strong> ${errors[field][0]}</li>`;
                                }
                                errorList += '</ul>';

                                showError('Validation Error',
                                    result.data.message + '<br><br>' + errorList);
                                return;
                            }

                            // Handle success response
                            if (result.data.success) {
                                showSuccess('✅ Pengaturan Tersimpan!', result.data.message).then(() => {
                                    // Reload to show updated settings
                                    window.location.href =
                                        '<?php echo e(route('admin.superadmin.instagram-settings')); ?>';
                                });
                            } else {
                                showError('Gagal Menyimpan', result.data.message || 'Terjadi kesalahan');
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
                }, true); // USE CAPTURE PHASE!

                // Sync Data
                if (syncBtn) {
                    syncBtn.addEventListener('click', function() {
                        syncBtn.disabled = true;
                        syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Syncing...';
                        showLoading();

                        fetch('<?php echo e(route('admin.superadmin.instagram-settings.sync')); ?>', {
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

                                fetch('<?php echo e(route('admin.superadmin.instagram-settings.deactivate')); ?>', {
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
    <?php $__env->stopPush(); ?>
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
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/superadmin/instagram-settings.blade.php ENDPATH**/ ?>