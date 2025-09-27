<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Pages - {{ config('app.name') }}</title>

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
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="text-2xl font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                            {{ config('app.name') }}
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Home
                    </a>
                    <a href="/kegiatan"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Kegiatan
                    </a>
                    <a href="/about"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        About
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="bg-white dark:bg-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    All Pages
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    Explore all pages on our website
                </p>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <form method="GET" class="flex flex-wrap gap-4 items-center">
                    <div class="flex-1 min-w-64">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search pages..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <select name="category"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="sort"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First
                            </option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First
                            </option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                        <i class="fas fa-search mr-2"></i>
                        Filter
                    </button>
                    <a href="{{ route('pages.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Clear
                    </a>
                </form>
            </div>
        </div>
    </section>

    <!-- Pages Grid -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($pages->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($pages as $page)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            @if ($page->featured_image)
                                <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-file-alt text-4xl text-gray-400"></i>
                                </div>
                            @endif

                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    @if ($page->category)
                                        <span
                                            class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
                                            {{ $page->category->name }}
                                        </span>
                                    @endif
                                    @if ($page->is_featured)
                                        <span
                                            class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-2 py-1 rounded-full text-xs">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                    <a href="{{ route('pages.show', $page->slug) }}"
                                        class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        {{ $page->title }}
                                    </a>
                                </h3>

                                @if ($page->excerpt)
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ Str::limit($page->excerpt, 120) }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $page->updated_at->format('M d, Y') }}
                                    </span>
                                    <a href="{{ route('pages.show', $page->slug) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                                        Read More <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($pages->hasPages())
                    <div class="mt-8">
                        {{ $pages->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <i class="fas fa-file-alt text-6xl text-gray-400 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">No pages found</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        @if (request()->hasAny(['search', 'category', 'sort']))
                            Try adjusting your search criteria.
                        @else
                            No pages have been published yet.
                        @endif
                    </p>
                    <a href="/"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
                        <i class="fas fa-home mr-2"></i>
                        Go Home
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ config('app.name') }}</h3>
                    <p class="text-gray-300">
                        Sistem Informasi Sekolah Terintegrasi untuk manajemen sekolah yang lebih baik.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                        <li><a href="/kegiatan" class="text-gray-300 hover:text-white transition-colors">Kegiatan</a>
                        </li>
                        <li><a href="/about" class="text-gray-300 hover:text-white transition-colors">About</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <p class="text-gray-300">
                        Email: info@sekolah.com<br>
                        Phone: (021) 123-4567
                    </p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; 2024 {{ config('app.name') }}. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>
</body>

</html>
