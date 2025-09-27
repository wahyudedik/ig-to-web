<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Page') }}
            </h2>
            <a href="{{ route('pages.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Pages
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pages.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title
                                        *</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                                        required>
                                    @error('title')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content
                                        *</label>
                                    <textarea name="content" id="content" rows="15"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror"
                                        required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Excerpt -->
                                <div>
                                    <label for="excerpt"
                                        class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                                    <textarea name="excerpt" id="excerpt" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
                                    <p class="text-gray-500 text-xs mt-1">Brief description of the page (max 500
                                        characters)</p>
                                    @error('excerpt')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="space-y-6">
                                <!-- Publish Settings -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Publish Settings</h3>

                                    <!-- Status -->
                                    <div class="mb-4">
                                        <label for="status"
                                            class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                        <select name="status" id="status"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror"
                                            required>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                                                Draft</option>
                                            <option value="published"
                                                {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="archived"
                                                {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                        @error('status')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Featured -->
                                    <div class="mb-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_featured" value="1"
                                                {{ old('is_featured') ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Featured Page</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Page Settings -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Page Settings</h3>

                                    <!-- Template -->
                                    <div class="mb-4">
                                        <label for="template"
                                            class="block text-sm font-medium text-gray-700 mb-1">Template *</label>
                                        <select name="template" id="template"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('template') border-red-500 @enderror"
                                            required>
                                            @foreach ($templates as $key => $name)
                                                <option value="{{ $key }}"
                                                    {{ old('template') == $key ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('template')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-4">
                                        <label for="category"
                                            class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                        <input type="text" name="category" id="category"
                                            value="{{ old('category') }}" list="categories"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category') border-red-500 @enderror">
                                        <datalist id="categories">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category }}">
                                            @endforeach
                                        </datalist>
                                        @error('category')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Featured Image -->
                                    <div class="mb-4">
                                        <label for="featured_image"
                                            class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                                        <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('featured_image') border-red-500 @enderror">
                                        <p class="text-gray-500 text-xs mt-1">Max size: 2MB, Formats: JPEG, PNG, JPG,
                                            GIF</p>
                                        @error('featured_image')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- SEO Settings -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Settings</h3>

                                    <!-- SEO Title -->
                                    <div class="mb-4">
                                        <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-1">SEO
                                            Title</label>
                                        <input type="text" name="seo_title" id="seo_title"
                                            value="{{ old('seo_title') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('seo_title') border-red-500 @enderror">
                                        <p class="text-gray-500 text-xs mt-1">Max 60 characters</p>
                                        @error('seo_title')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- SEO Description -->
                                    <div class="mb-4">
                                        <label for="seo_description"
                                            class="block text-sm font-medium text-gray-700 mb-1">SEO
                                            Description</label>
                                        <textarea name="seo_description" id="seo_description" rows="3"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('seo_description') border-red-500 @enderror">{{ old('seo_description') }}</textarea>
                                        <p class="text-gray-500 text-xs mt-1">Max 160 characters</p>
                                        @error('seo_description')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- SEO Keywords -->
                                    <div class="mb-4">
                                        <label for="seo_keywords"
                                            class="block text-sm font-medium text-gray-700 mb-1">SEO Keywords</label>
                                        <input type="text" name="seo_keywords" id="seo_keywords"
                                            value="{{ old('seo_keywords') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('seo_keywords') border-red-500 @enderror">
                                        <p class="text-gray-500 text-xs mt-1">Comma-separated keywords</p>
                                        @error('seo_keywords')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('pages.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Page
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TinyMCE Script -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 400,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic forecolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }'
        });
    </script>
</x-app-layout>
