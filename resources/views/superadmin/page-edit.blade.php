<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Page - Superadmin Dashboard</title>

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
        .editor-container {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            min-height: 300px;
        }

        .editor-toolbar {
            background-color: #f9fafb;
            border-bottom: 1px solid #d1d5db;
            padding: 0.5rem;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .editor-button {
            padding: 0.25rem 0.5rem;
            border: 1px solid #d1d5db;
            background-color: white;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .editor-button:hover {
            background-color: #f3f4f6;
        }

        .editor-button.active {
            background-color: #3b82f6;
            color: white;
        }

        .editor-content {
            padding: 1rem;
            min-height: 250px;
            outline: none;
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
                    <a href="/superadmin/page-management"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Pages
                    </a>
                    <a href="/superadmin/instagram-settings"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Instagram
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="pt-20 pb-8 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Edit Page</h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        Edit "{{ $page->title }}"
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('superadmin.page-management') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Pages
                    </a>
                    <a href="{{ route('pages.show', $page->slug) }}" target="_blank"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        View Page
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('superadmin.page-update', $page->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Page Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ $page->title }}" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter page title">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Slug
                            </label>
                            <input type="text" name="slug" id="slug" value="{{ $page->slug }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="page-url-slug">
                            <p class="text-xs text-gray-500 mt-1">Leave empty to auto-generate from title</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Template
                            </label>
                            <select name="template" id="template" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @foreach ($templates as $key => $template)
                                    <option value="{{ $key }}" {{ $page->template == $key ? 'selected' : '' }}>
                                        {{ $template }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Excerpt
                        </label>
                        <textarea name="excerpt" id="excerpt" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Brief description of the page">{{ $page->excerpt }}</textarea>
                    </div>
                </div>

                <!-- Content Editor -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Page Content</h3>

                    <div class="editor-container">
                        <div class="editor-toolbar">
                            <button type="button" class="editor-button" onclick="formatText('bold')">
                                <i class="fas fa-bold"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('italic')">
                                <i class="fas fa-italic"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('underline')">
                                <i class="fas fa-underline"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('strikeThrough')">
                                <i class="fas fa-strikethrough"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('justifyLeft')">
                                <i class="fas fa-align-left"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('justifyCenter')">
                                <i class="fas fa-align-center"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('justifyRight')">
                                <i class="fas fa-align-right"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('justifyFull')">
                                <i class="fas fa-align-justify"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('insertUnorderedList')">
                                <i class="fas fa-list-ul"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('insertOrderedList')">
                                <i class="fas fa-list-ol"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('createLink')">
                                <i class="fas fa-link"></i>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('insertImage')">
                                <i class="fas fa-image"></i>
                            </button>
                        </div>
                        <div class="editor-content" contenteditable="true" id="content-editor"
                            oninput="updateContent()">
                            {!! $page->content !!}
                        </div>
                    </div>
                    <textarea name="content" id="content" style="display: none;" required>{{ $page->content }}</textarea>
                </div>

                <!-- Media & Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Media & Settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Featured Image
                            </label>
                            @if ($page->featured_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($page->featured_image) }}" alt="Current featured image"
                                        class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                            <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category
                            </label>
                            <select name="category_id" id="category_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">No Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $page->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status
                            </label>
                            <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="draft" {{ $page->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ $page->status == 'published' ? 'selected' : '' }}>
                                    Published</option>
                                <option value="archived" {{ $page->status == 'archived' ? 'selected' : '' }}>Archived
                                </option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                {{ $page->is_featured ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Featured Page
                            </label>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">SEO Settings</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                SEO Title
                            </label>
                            <input type="text" name="seo_title" id="seo_title" value="{{ $page->seo_title }}"
                                maxlength="60"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="SEO optimized title">
                            <p class="text-xs text-gray-500 mt-1">Recommended: 50-60 characters</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                SEO Description
                            </label>
                            <textarea name="seo_description" id="seo_description" rows="3" maxlength="160"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="SEO meta description">{{ $page->seo_description }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Recommended: 150-160 characters</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                SEO Keywords
                            </label>
                            <input type="text" name="seo_keywords" id="seo_keywords"
                                value="{{ $page->seo_keywords }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="keyword1, keyword2, keyword3">
                            <p class="text-xs text-gray-500 mt-1">Separate keywords with commas</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('superadmin.page-management') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <div class="flex space-x-3">
                        <button type="submit" name="status" value="draft"
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                            <i class="fas fa-save mr-2"></i>
                            Save as Draft
                        </button>
                        <button type="submit" name="status" value="published"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                            <i class="fas fa-eye mr-2"></i>
                            Publish
                        </button>
                    </div>
                </div>
            </form>
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
        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            document.getElementById('slug').value = slug;
        });

        // Update content textarea
        function updateContent() {
            document.getElementById('content').value = document.getElementById('content-editor').innerHTML;
        }

        // Format text in editor
        function formatText(command) {
            document.execCommand(command, false, null);
            document.getElementById('content-editor').focus();
        }

        // Initialize content
        document.addEventListener('DOMContentLoaded', function() {
            updateContent();
        });
    </script>
</body>

</html>
