<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kegiatan Sekolah - Instagram Feed</title>

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
            /* ... existing styles ... */
        </style>
    @endif

    <style>
        .instagram-gradient {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        .post-card {
            transition: all 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
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
                        <a href="/" class="text-2xl font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                            Website Sekolah
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Home</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Halaman</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Galeri</a>
                    <a href="/kegiatan" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Kegiatan
                    </a>
                    <div class="relative group">
                        <button
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center focus:outline-none">
                            Modul
                            <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.085l3.71-3.855a.75.75 0 1 1 1.08 1.04l-4.24 4.4a.75.75 0 0 1-1.08 0l-4.24-4.4a.75.75 0 0 1 .02-1.06z" />
                            </svg>
                        </button>
                        <div
                            class="absolute left-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-focus:opacity-100 transition-opacity duration-200 z-50">
                            <a class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 text-sm font-medium transition duration-300"
                                href="">E-Lulus</a>
                            <a class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 text-sm font-medium transition duration-300"
                                href="">E-OSIS</a>
                            <a class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 text-sm font-medium transition duration-300"
                                href="">Sarpras</a>
                        </div>
                    </div>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Tenaga Pendidik</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Data Siswa</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Kontak</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-300">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                                Login
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="pt-20 pb-8 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-4">
                    {{-- <i class="fab fa-instagram text-3xl instagram-gradient mr-3"></i> --}}
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Kegiatan Sekolah</h1>
                </div>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-6">
                    Update terbaru kegiatan dan aktivitas sekolah dari Instagram
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <button id="refreshBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i>
                        <span id="refreshText">Perbarui Data</span>
                    </button>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock mr-1"></i>
                        Terakhir diperbarui: <span id="lastUpdated">{{ now()->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Message -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Instagram Feed -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Loading State -->
            <div id="loadingState" class="hidden text-center py-12">
                <div class="loading-spinner mx-auto mb-4"></div>
                <p class="text-gray-600 dark:text-gray-300">Memuat data Instagram...</p>
            </div>

            <!-- Posts Grid -->
            <div id="postsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <article class="post-card bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <!-- Post Image -->
                        <div class="relative">
                            <img src="{{ $post['media_url'] }}" alt="Kegiatan Sekolah" class="w-full h-64 object-cover">
                            <div class="absolute top-4 right-4">
                                <a href="{{ $post['permalink'] }}" target="_blank"
                                    class="bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm hover:bg-opacity-70 transition duration-300">
                                    <i class="fab fa-instagram mr-1"></i>
                                    Lihat
                                </a>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="p-6">
                            <!-- Post Caption -->
                            <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">
                                {{ $post['caption'] }}
                            </p>

                            <!-- Post Stats -->
                            <div
                                class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <i class="fas fa-heart text-red-500 mr-1"></i>
                                        {{ number_format($post['like_count']) }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-comment text-blue-500 mr-1"></i>
                                        {{ number_format($post['comment_count']) }}
                                    </span>
                                </div>
                                <span class="text-xs">
                                    {{ $post['timestamp']->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Post Actions -->
                            <div
                                class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ $post['permalink'] }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium transition duration-300">
                                    Lihat di Instagram
                                </a>
                                <button
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition duration-300">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-12">
                <i class="fas fa-instagram text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                    Belum ada kegiatan
                </h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Kegiatan sekolah akan muncul di sini setelah terhubung dengan Instagram
                </p>
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
            const refreshBtn = document.getElementById('refreshBtn');
            const refreshText = document.getElementById('refreshText');
            const loadingState = document.getElementById('loadingState');
            const postsContainer = document.getElementById('postsContainer');
            const emptyState = document.getElementById('emptyState');
            const lastUpdated = document.getElementById('lastUpdated');

            // Refresh button functionality
            refreshBtn.addEventListener('click', function() {
                // Show loading state
                refreshBtn.disabled = true;
                refreshText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui...';

                // Fetch new data
                fetch('/kegiatan/posts')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update last updated time
                            lastUpdated.textContent = new Date().toLocaleString('id-ID', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            // Show success message
                            showNotification('Data berhasil diperbarui!', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Gagal memperbarui data', 'error');
                    })
                    .finally(() => {
                        // Reset button state
                        refreshBtn.disabled = false;
                        refreshText.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Perbarui Data';
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

            // Auto refresh every 30 minutes
            setInterval(() => {
                fetch('/kegiatan/posts')
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
                        }
                    })
                    .catch(error => console.error('Auto refresh error:', error));
            }, 30 * 60 * 1000); // 30 minutes
        });
    </script>
</body>

</html>
