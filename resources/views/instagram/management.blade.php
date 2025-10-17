<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    <i class="fab fa-instagram mr-2"
                        style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    Instagram Management
                </h1>
                <p class="text-slate-600 mt-1">Kelola konfigurasi dan konten Instagram</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('public.instagram') }}" class="btn btn-secondary">
                    <i class="fab fa-instagram mr-2"></i>
                    Lihat Galeri
                </a>
                <a href="{{ route('docs.instagram-setup') }}" class="btn btn-secondary">
                    <i class="fas fa-book mr-2"></i>
                    Dokumentasi
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
        <!-- Connection Status -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div
                        class="w-12 h-12 {{ $connectionStatus ? 'bg-green-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                        <i
                            class="fas {{ $connectionStatus ? 'fa-check' : 'fa-times' }} text-{{ $connectionStatus ? 'green' : 'red' }}-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-slate-900">Instagram Connection</h3>
                        <p class="text-sm text-slate-600">
                            Status: <span
                                class="{{ $connectionStatus ? 'text-green-600' : 'text-red-600' }} font-medium">{{ $connectionStatus ? 'Connected' : 'Disconnected' }}</span>
                        </p>
                    </div>
                </div>
                <button id="testConnection" class="btn btn-primary">
                    <i class="fas fa-plug mr-2"></i>
                    Test Connection
                </button>
            </div>
        </div>

        <!-- Management Tabs -->
        <div class="bg-white rounded-xl border border-slate-200">
            <div class="border-b border-slate-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button
                        class="tab-button active py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600"
                        data-tab="config">
                        API Configuration
                    </button>
                    <button
                        class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-slate-500 hover:text-slate-700"
                        data-tab="filter">
                        Post Filtering
                    </button>
                    <button
                        class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-slate-500 hover:text-slate-700"
                        data-tab="schedule">
                        Content Scheduling
                    </button>
                    <button
                        class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-slate-500 hover:text-slate-700"
                        data-tab="insights">
                        Insights
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- API Configuration Tab -->
                <div id="config-tab" class="tab-content">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Instagram API Configuration</h3>
                    <form id="configForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Access Token</label>
                                <input type="text" name="access_token" class="form-input"
                                    placeholder="Enter Instagram Access Token">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">User ID</label>
                                <input type="text" name="user_id" class="form-input"
                                    placeholder="Enter Instagram User ID">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">App ID</label>
                                <input type="text" name="app_id" class="form-input"
                                    placeholder="Enter Instagram App ID">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">App Secret</label>
                                <input type="password" name="app_secret" class="form-input"
                                    placeholder="Enter Instagram App Secret">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Redirect URI</label>
                            <input type="url" name="redirect_uri" class="form-input"
                                placeholder="Enter Redirect URI">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Update Configuration
                        </button>
                    </form>
                </div>

                <!-- Post Filtering Tab -->
                <div id="filter-tab" class="tab-content hidden">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Filter Instagram Posts</h3>
                    <form id="filterForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Media Type</label>
                                <select name="filter_type" class="form-select">
                                    <option value="all">All Media</option>
                                    <option value="images">Images Only</option>
                                    <option value="videos">Videos Only</option>
                                    <option value="carousel">Carousel Only</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Keyword</label>
                                <input type="text" name="keyword" class="form-input"
                                    placeholder="Search in captions">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Date From</label>
                                <input type="date" name="date_from" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Date To</label>
                                <input type="date" name="date_to" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Minimum Likes</label>
                                <input type="number" name="min_likes" min="0" class="form-input"
                                    placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Minimum Comments</label>
                                <input type="number" name="min_comments" min="0" class="form-input"
                                    placeholder="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter mr-2"></i>
                            Apply Filters
                        </button>
                    </form>
                    <div id="filterResults" class="mt-6"></div>
                </div>

                <!-- Content Scheduling Tab -->
                <div id="schedule-tab" class="tab-content hidden">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Schedule Content</h3>
                    <form id="scheduleForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Content Description</label>
                            <input type="text" name="content" class="form-input"
                                placeholder="Describe your content" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Scheduled Time</label>
                                <input type="datetime-local" name="scheduled_time" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Media URL</label>
                                <input type="url" name="media_url" class="form-input"
                                    placeholder="https://example.com/image.jpg">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Caption</label>
                            <textarea name="caption" rows="3" class="form-input" placeholder="Write your Instagram caption here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Schedule Content
                        </button>
                    </form>
                    <div id="scheduledContent" class="mt-6"></div>
                </div>

                <!-- Insights Tab -->
                <div id="insights-tab" class="tab-content hidden">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Instagram Insights</h3>
                    <div id="insightsContent" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <div class="text-sm text-slate-600 mb-1">Loading...</div>
                            <div class="text-xs text-slate-500">Insights akan muncul di sini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tab functionality
                const tabButtons = document.querySelectorAll('.tab-button');
                const tabContents = document.querySelectorAll('.tab-content');

                tabButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const targetTab = this.getAttribute('data-tab');

                        // Remove active class from all buttons
                        tabButtons.forEach(btn => {
                            btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                            btn.classList.add('border-transparent', 'text-slate-500');
                        });

                        // Add active class to clicked button
                        this.classList.add('active', 'border-blue-500', 'text-blue-600');
                        this.classList.remove('border-transparent', 'text-slate-500');

                        // Hide all tab contents
                        tabContents.forEach(content => {
                            content.classList.add('hidden');
                        });

                        // Show target tab content
                        document.getElementById(targetTab + '-tab').classList.remove('hidden');
                    });
                });

                // Test Connection
                document.getElementById('testConnection').addEventListener('click', function() {
                    const btn = this;
                    const originalHTML = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Testing...';

                    fetch('/admin/instagram/management/test-connection')
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Connection test failed');
                        })
                        .finally(() => {
                            btn.disabled = false;
                            btn.innerHTML = originalHTML;
                        });
                });

                // Configuration Form
                document.getElementById('configForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalHTML = submitBtn.innerHTML;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';

                    fetch('/admin/instagram/management/update-config', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Configuration update failed');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalHTML;
                        });
                });

                // Filter Form
                document.getElementById('filterForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    fetch('/admin/instagram/management/filter-posts', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                displayFilterResults(data.data);
                                alert(`Found ${data.total_filtered} posts`);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Filter failed');
                        });
                });

                // Schedule Form
                document.getElementById('scheduleForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    fetch('/admin/instagram/management/schedule-content', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            if (data.success) {
                                loadScheduledContent();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Scheduling failed');
                        });
                });

                // Load insights when tab is clicked
                document.querySelector('[data-tab="insights"]').addEventListener('click', function() {
                    loadInsights();
                });

                // Load scheduled content when tab is clicked
                document.querySelector('[data-tab="schedule"]').addEventListener('click', function() {
                    loadScheduledContent();
                });

                // Helper functions
                function displayFilterResults(posts) {
                    const resultsContainer = document.getElementById('filterResults');
                    resultsContainer.innerHTML = '<h4 class="text-lg font-semibold mb-4">Filtered Results</h4>';

                    if (posts.length === 0) {
                        resultsContainer.innerHTML +=
                            '<p class="text-slate-500">No posts found matching the criteria.</p>';
                        return;
                    }

                    posts.forEach(post => {
                        const postElement = document.createElement('div');
                        postElement.className = 'flex items-center space-x-4 p-4 bg-slate-50 rounded-lg mb-2';
                        postElement.innerHTML = `
                        <img src="${post.media_url}" alt="Post" class="w-16 h-16 object-cover rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm text-slate-900">${post.caption.substring(0, 100)}...</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="text-sm text-slate-500"><i class="fas fa-heart text-red-500 mr-1"></i>${post.like_count}</span>
                                <span class="text-sm text-slate-500"><i class="fas fa-comment text-blue-500 mr-1"></i>${post.comment_count}</span>
                            </div>
                        </div>
                    `;
                        resultsContainer.appendChild(postElement);
                    });
                }

                function loadScheduledContent() {
                    const container = document.getElementById('scheduledContent');
                    container.innerHTML = '<p class="text-slate-500">Loading scheduled content...</p>';

                    fetch('/admin/instagram/management/scheduled-content')
                        .then(response => response.json())
                        .then(data => {
                            container.innerHTML = '<h4 class="text-lg font-semibold mb-4">Scheduled Content</h4>';

                            if (data.data.length === 0) {
                                container.innerHTML += '<p class="text-slate-500">No scheduled content.</p>';
                                return;
                            }

                            data.data.forEach(post => {
                                const postElement = document.createElement('div');
                                postElement.className =
                                    'flex items-center justify-between p-4 bg-slate-50 rounded-lg mb-2';
                                postElement.innerHTML = `
                                <div>
                                    <p class="font-medium text-slate-900">${post.content}</p>
                                    <p class="text-sm text-slate-500">Scheduled: ${new Date(post.scheduled_time).toLocaleString()}</p>
                                </div>
                                <button onclick="cancelScheduled('${post.id}')" class="text-red-600 hover:text-red-700 text-sm">Cancel</button>
                            `;
                                container.appendChild(postElement);
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            container.innerHTML = '<p class="text-red-500">Failed to load scheduled content</p>';
                        });
                }

                function loadInsights() {
                    const container = document.getElementById('insightsContent');
                    container.innerHTML = '<p class="text-slate-500 col-span-4 text-center">Loading insights...</p>';

                    fetch('/admin/instagram/management/insights')
                        .then(response => response.json())
                        .then(data => {
                            container.innerHTML = `
                            <div class="bg-blue-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-blue-600">${data.data.total_posts}</div>
                                <div class="text-sm text-slate-600">Total Posts</div>
                            </div>
                            <div class="bg-red-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-red-600">${data.data.total_likes}</div>
                                <div class="text-sm text-slate-600">Total Likes</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-green-600">${data.data.total_comments}</div>
                                <div class="text-sm text-slate-600">Total Comments</div>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-purple-600">${data.data.avg_engagement}</div>
                                <div class="text-sm text-slate-600">Avg Engagement</div>
                            </div>
                        `;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            container.innerHTML =
                                '<p class="text-red-500 col-span-4 text-center">Failed to load insights</p>';
                        });
                }

                window.cancelScheduled = function(postId) {
                    fetch('/admin/instagram/management/cancel-scheduled', {
                            method: 'POST',
                            body: JSON.stringify({
                                post_id: postId
                            }),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            if (data.success) {
                                loadScheduledContent();
                            }
                        });
                };
            });
        </script>
    @endpush
</x-app-layout>
