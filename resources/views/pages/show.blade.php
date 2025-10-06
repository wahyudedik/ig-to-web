<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->seo_title ?: $page->title }} - {{ config('app.name') }}</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $page->seo_description ?: $page->excerpt }}">
    <meta name="keywords" content="{{ $page->seo_keywords }}">
    <meta name="author" content="{{ config('app.name') }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $page->seo_title ?: $page->title }}">
    <meta property="og:description" content="{{ $page->seo_description ?: $page->excerpt }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($page->featured_image)
        <meta property="og:image" content="{{ Storage::url($page->featured_image) }}">
    @endif

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

    <!-- Page Header -->
    <section class="bg-white dark:bg-gray-800 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ $page->title }}
                </h1>
                @if ($page->excerpt)
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-6">
                        {{ $page->excerpt }}
                    </p>
                @endif
                <div class="flex items-center justify-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                    <span>
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $page->updated_at->format('M d, Y') }}
                    </span>
                    @if ($page->category)
                        <span>
                            <i class="fas fa-folder mr-1"></i>
                            {{ $page->category->name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Image -->
    @if ($page->featured_image)
        <section class="py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}"
                    class="w-full h-64 md:h-96 object-cover rounded-xl shadow-lg">
            </div>
        </section>
    @endif

    <!-- Page Content -->
    <section class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                <div class="prose prose-lg max-w-none dark:prose-invert">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>

    <!-- Related Pages -->
    @if ($relatedPages->count() > 0)
        <section class="py-8 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                    Related Pages
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($relatedPages as $relatedPage)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            @if ($relatedPage->featured_image)
                                <img src="{{ Storage::url($relatedPage->featured_image) }}"
                                    alt="{{ $relatedPage->title }}" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                    <a href="{{ route('pages.public.show', $relatedPage->slug) }}"
                                        class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        {{ $relatedPage->title }}
                                    </a>
                                </h3>
                                @if ($relatedPage->excerpt)
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ Str::limit($relatedPage->excerpt, 100) }}
                                    </p>
                                @endif
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <span>{{ $relatedPage->updated_at->format('M d, Y') }}</span>
                                    @if ($relatedPage->category)
                                        <span
                                            class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
                                            {{ $relatedPage->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

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
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>
</body>

</html>
