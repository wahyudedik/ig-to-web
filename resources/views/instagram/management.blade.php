<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Instagram Management - Website Sekolah</title>

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

        .management-card {
            transition: all 0.3s ease;
        }

        .management-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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
                        <a href="/" class="text-2xl font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                            Website Sekolah
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('public.instagram') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Kegiatan
                    </a>
                    <a href="{{ route('docs.instagram-setup') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Dokumentasi
                    </a>
                    <a href="{{ route('admin.dashboard') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Dashboard
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
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Instagram Management</h1>
                </div>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-6">
                    Kelola konfigurasi, filter, dan jadwal konten Instagram
                </p>
            </div>
        </div>
    </section>

    <!-- Management Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Connection Status -->
            <div class="management-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="p-3 rounded-full {{ $connectionStatus ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900' }}">
                            <i
                                class="fas {{ $connectionStatus ? 'fa-check' : 'fa-times' }} text-{{ $connectionStatus ? 'green' : 'red' }}-600 dark:text-{{ $connectionStatus ? 'green' : 'red' }}-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Instagram Connection</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $connectionStatus ? 'Connected' : 'Disconnected' }}
                            </p>
                        </div>
                    </div>
                    <button id="testConnection"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                        Test Connection
                    </button>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button
                            class="tab-button active py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 dark:text-blue-400"
                            data-tab="config">
                            API Configuration
                        </button>
                        <button
                            class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                            data-tab="filter">
                            Post Filtering
                        </button>
                        <button
                            class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                            data-tab="schedule">
                            Content Scheduling
                        </button>
                        <button
                            class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                            data-tab="insights">
                            Insights
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- API Configuration Tab -->
                    <div id="config-tab" class="tab-content">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Instagram API Configuration
                        </h3>
                        <form id="configForm" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Access
                                        Token</label>
                                    <input type="text" name="access_token"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Enter Instagram Access Token">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">User
                                        ID</label>
                                    <input type="text" name="user_id"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Enter Instagram User ID">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">App
                                        ID</label>
                                    <input type="text" name="app_id"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Enter Instagram App ID">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">App
                                        Secret</label>
                                    <input type="password" name="app_secret"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Enter Instagram App Secret">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Redirect
                                    URI</label>
                                <input type="url" name="redirect_uri"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Enter Redirect URI">
                            </div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                                Update Configuration
                            </button>
                        </form>
                    </div>

                    <!-- Post Filtering Tab -->
                    <div id="filter-tab" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filter Instagram Posts</h3>
                        <form id="filterForm" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Media
                                        Type</label>
                                    <select name="filter_type"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="all">All Media</option>
                                        <option value="images">Images Only</option>
                                        <option value="videos">Videos Only</option>
                                        <option value="carousel">Carousel Only</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keyword</label>
                                    <input type="text" name="keyword"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Search in captions">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date
                                        From</label>
                                    <input type="date" name="date_from"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date
                                        To</label>
                                    <input type="date" name="date_to"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum
                                        Likes</label>
                                    <input type="number" name="min_likes" min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="0">
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum
                                        Comments</label>
                                    <input type="number" name="min_comments" min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="0">
                                </div>
                            </div>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                                Apply Filters
                            </button>
                        </form>
                        <div id="filterResults" class="mt-6"></div>
                    </div>

                    <!-- Content Scheduling Tab -->
                    <div id="schedule-tab" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Schedule Content</h3>
                        <form id="scheduleForm" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content
                                    Description</label>
                                <input type="text" name="content"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Describe your content" required>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Scheduled
                                        Time</label>
                                    <input type="datetime-local" name="scheduled_time"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Media
                                        URL</label>
                                    <input type="url" name="media_url"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="https://example.com/image.jpg">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Caption</label>
                                <textarea name="caption" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Write your Instagram caption here..."></textarea>
                            </div>
                            <button type="submit"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                                Schedule Content
                            </button>
                        </form>
                        <div id="scheduledContent" class="mt-6"></div>
                    </div>

                    <!-- Insights Tab -->
                    <div id="insights-tab" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Instagram Insights</h3>
                        <div id="insightsContent" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Insights will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Website Sekolah. Semua hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- JavaScript -->
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
                        btn.classList.remove('active', 'border-blue-500', 'text-blue-600',
                            'dark:text-blue-400');
                        btn.classList.add('border-transparent', 'text-gray-500',
                            'dark:text-gray-400');
                    });

                    // Add active class to clicked button
                    this.classList.add('active', 'border-blue-500', 'text-blue-600',
                        'dark:text-blue-400');
                    this.classList.remove('border-transparent', 'text-gray-500',
                        'dark:text-gray-400');

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
                fetch('/admin/instagram/management/test-connection')
                    .then(response => response.json())
                    .then(data => {
                        showNotification(data.message, data.success ? 'success' : 'error');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Connection test failed', 'error');
                    });
            });

            // Configuration Form
            document.getElementById('configForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

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
                        showNotification(data.message, data.success ? 'success' : 'error');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Configuration update failed', 'error');
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
                            showNotification(`Found ${data.total_filtered} posts`, 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Filter failed', 'error');
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
                        showNotification(data.message, data.success ? 'success' : 'error');
                        if (data.success) {
                            loadScheduledContent();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Scheduling failed', 'error');
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
                        '<p class="text-gray-500">No posts found matching the criteria.</p>';
                    return;
                }

                posts.forEach(post => {
                    const postElement = document.createElement('div');
                    postElement.className =
                        'flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-2';
                    postElement.innerHTML = `
                        <img src="${post.media_url}" alt="Post" class="w-16 h-16 object-cover rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm text-gray-900 dark:text-white">${post.caption.substring(0, 100)}...</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="text-sm text-gray-500"><i class="fas fa-heart text-red-500 mr-1"></i>${post.like_count}</span>
                                <span class="text-sm text-gray-500"><i class="fas fa-comment text-blue-500 mr-1"></i>${post.comment_count}</span>
                            </div>
                        </div>
                    `;
                    resultsContainer.appendChild(postElement);
                });
            }

            function loadScheduledContent() {
                fetch('/admin/instagram/management/scheduled-content')
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('scheduledContent');
                        container.innerHTML = '<h4 class="text-lg font-semibold mb-4">Scheduled Content</h4>';

                        if (data.data.length === 0) {
                            container.innerHTML += '<p class="text-gray-500">No scheduled content.</p>';
                            return;
                        }

                        data.data.forEach(post => {
                            const postElement = document.createElement('div');
                            postElement.className =
                                'flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-2';
                            postElement.innerHTML = `
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">${post.content}</p>
                                    <p class="text-sm text-gray-500">Scheduled: ${new Date(post.scheduled_time).toLocaleString()}</p>
                                </div>
                                <button onclick="cancelScheduled('${post.id}')" class="text-red-600 hover:text-red-700 text-sm">Cancel</button>
                            `;
                            container.appendChild(postElement);
                        });
                    });
            }

            function loadInsights() {
                fetch('/admin/instagram/management/insights')
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('insightsContent');
                        container.innerHTML = `
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">${data.data.total_posts}</div>
                                <div class="text-sm text-blue-600 dark:text-blue-400">Total Posts</div>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-red-600 dark:text-red-400">${data.data.total_likes}</div>
                                <div class="text-sm text-red-600 dark:text-red-400">Total Likes</div>
                            </div>
                            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">${data.data.total_comments}</div>
                                <div class="text-sm text-green-600 dark:text-green-400">Total Comments</div>
                            </div>
                            <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">${data.data.avg_engagement}</div>
                                <div class="text-sm text-purple-600 dark:text-purple-400">Avg Engagement</div>
                            </div>
                        `;
                    });
            }

            function cancelScheduled(postId) {
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
                        showNotification(data.message, data.success ? 'success' : 'error');
                        if (data.success) {
                            loadScheduledContent();
                        }
                    });
            }

            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-lg text-white ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                }`;
                notification.textContent = message;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });
    </script>
</body>

</html>
