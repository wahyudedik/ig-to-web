<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $page->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('pages.edit', $page) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Page
                </a>
                <a href="{{ route('pages.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Pages
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Page Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if ($page->status === 'published') bg-green-100 text-green-800
                                    @elseif($page->status === 'draft') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($page->status) }}
                                </span>

                                @if ($page->is_featured)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        Featured
                                    </span>
                                @endif

                                <span class="text-sm text-gray-500">
                                    Template: {{ ucfirst($page->template) }}
                                </span>
                            </div>

                            <div class="flex space-x-2">
                                @if ($page->status === 'published')
                                    <form method="POST" action="{{ route('pages.unpublish', $page) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                            Unpublish
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('pages.publish', $page) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Publish
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('pages.duplicate', $page) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                        Duplicate
                                    </button>
                                </form>
                            </div>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $page->title }}</h1>

                        @if ($page->excerpt)
                            <p class="text-lg text-gray-600 mb-4">{{ $page->excerpt }}</p>
                        @endif

                        <div class="flex items-center text-sm text-gray-500 space-x-4">
                            <span>By {{ $page->user->name }}</span>
                            <span>•</span>
                            <span>Created {{ $page->created_at->format('M d, Y') }}</span>
                            @if ($page->published_at)
                                <span>•</span>
                                <span>Published {{ $page->published_at->format('M d, Y') }}</span>
                            @endif
                            @if ($page->category)
                                <span>•</span>
                                <span>Category: {{ $page->category }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if ($page->featured_image)
                        <div class="mb-8">
                            <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}"
                                class="w-full h-64 object-cover rounded-lg">
                        </div>
                    @endif

                    <!-- Page Content -->
                    <div class="prose max-w-none">
                        {!! $page->content !!}
                    </div>

                    <!-- SEO Information -->
                    @if (
                        $page->seo_meta &&
                            (isset($page->seo_meta['title']) ||
                                isset($page->seo_meta['description']) ||
                                isset($page->seo_meta['keywords'])))
                        <div class="mt-12 bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>
                            <div class="space-y-3">
                                @if (isset($page->seo_meta['title']) && $page->seo_meta['title'])
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">SEO Title:</label>
                                        <p class="text-sm text-gray-900">{{ $page->seo_meta['title'] }}</p>
                                    </div>
                                @endif

                                @if (isset($page->seo_meta['description']) && $page->seo_meta['description'])
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">SEO Description:</label>
                                        <p class="text-sm text-gray-900">{{ $page->seo_meta['description'] }}</p>
                                    </div>
                                @endif

                                @if (isset($page->seo_meta['keywords']) && $page->seo_meta['keywords'])
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">SEO Keywords:</label>
                                        <p class="text-sm text-gray-900">{{ $page->seo_meta['keywords'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Page Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                Last updated: {{ $page->updated_at->format('M d, Y H:i') }}
                            </div>

                            <div class="flex space-x-4">
                                <a href="{{ route('pages.edit', $page) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Page
                                </a>

                                <form method="POST" action="{{ route('pages.destroy', $page) }}" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this page?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Delete Page
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
