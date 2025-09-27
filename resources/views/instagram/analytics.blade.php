<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instagram Analytics - Website Sekolah</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .metric-card {
            transition: all 0.3s ease;
        }

        .metric-card:hover {
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
                    <a href="/kegiatan"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Kegiatan
                    </a>
                    <a href="/dashboard" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
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
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Instagram Analytics</h1>
                </div>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-6">
                    Analisis performa dan engagement Instagram sekolah
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <button id="refreshAnalytics"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i>
                        <span id="refreshText">Perbarui Analytics</span>
                    </button>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock mr-1"></i>
                        Terakhir diperbarui: <span
                            id="lastUpdated">{{ $analytics['last_updated']->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Analytics Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Metrics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Posts -->
                <div class="metric-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                            <i class="fas fa-images text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Posts</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $analytics['total_posts'] }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Likes -->
                <div class="metric-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                            <i class="fas fa-heart text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Likes</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($analytics['total_likes']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Comments -->
                <div class="metric-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <i class="fas fa-comment text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Comments</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($analytics['total_comments']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Engagement Rate -->
                <div class="metric-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                            <i class="fas fa-chart-line text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Engagement Rate</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $analytics['engagement_rate'] }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Posts by Day Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Posts by Day of Week</h3>
                    <canvas id="postsByDayChart" width="400" height="200"></canvas>
                </div>

                <!-- Engagement Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Engagement Metrics</h3>
                    <canvas id="engagementChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Top Performing Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Performing Posts</h3>
                <div class="space-y-4">
                    @foreach ($analytics['top_posts'] as $index => $post)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-shrink-0">
                                <img src="{{ $post['media_url'] }}" alt="Post {{ $index + 1 }}"
                                    class="w-16 h-16 object-cover rounded-lg">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900 dark:text-white font-medium truncate">
                                    {{ Str::limit($post['caption'], 80) }}
                                </p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-heart text-red-500 mr-1"></i>
                                        {{ number_format($post['like_count']) }}
                                    </span>
                                    <span class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-comment text-blue-500 mr-1"></i>
                                        {{ number_format($post['comment_count']) }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $post['timestamp']->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ $post['permalink'] }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                    View Post
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $accountInfo['followers_count'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Followers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $accountInfo['media_count'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Media Count</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $accountInfo['following_count'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Following</div>
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
            // Posts by Day Chart
            const postsByDayCtx = document.getElementById('postsByDayChart').getContext('2d');
            const postsByDayData = @json($analytics['posts_by_day']);

            new Chart(postsByDayCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(postsByDayData),
                    datasets: [{
                        label: 'Posts',
                        data: Object.values(postsByDayData),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Engagement Chart
            const engagementCtx = document.getElementById('engagementChart').getContext('2d');

            new Chart(engagementCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Likes', 'Comments'],
                    datasets: [{
                        data: [{{ $analytics['total_likes'] }},
                            {{ $analytics['total_comments'] }}],
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.5)',
                            'rgba(59, 130, 246, 0.5)'
                        ],
                        borderColor: [
                            'rgba(239, 68, 68, 1)',
                            'rgba(59, 130, 246, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Refresh Analytics
            document.getElementById('refreshAnalytics').addEventListener('click', function() {
                const btn = this;
                const text = document.getElementById('refreshText');
                const lastUpdated = document.getElementById('lastUpdated');

                btn.disabled = true;
                text.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui...';

                fetch('/instagram/analytics/refresh')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            lastUpdated.textContent = new Date().toLocaleString('id-ID', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            showNotification('Analytics berhasil diperbarui!', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Gagal memperbarui analytics', 'error');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        text.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Perbarui Analytics';
                    });
            });

            // Notification function
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
