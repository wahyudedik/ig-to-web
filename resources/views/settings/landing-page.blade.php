<x-app-layout>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Landing Page Settings</h1>
                <p class="text-gray-600 mt-2">Kelola tampilan, logo, hero section, dan menu website</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.landing-page.update') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <!-- Site Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Site Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Site Name
                                *</label>
                            <input type="text" id="site_name" name="site_name"
                                value="{{ cache('site_setting_site_name', 'MAUDU REJOSO') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Site
                                Description</label>
                            <textarea id="site_description" name="site_description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ cache('site_setting_site_description') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label for="site_keywords" class="block text-sm font-medium text-gray-700 mb-2">Keywords
                                (comma
                                separated)</label>
                            <input type="text" id="site_keywords" name="site_keywords"
                                value="{{ cache('site_setting_site_keywords') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="sekolah, pendidikan, madrasah">
                        </div>
                    </div>
                </div>

                <!-- Logo & Favicon -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Logo & Favicon</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                            <input type="file" id="logo" name="logo" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @if (cache('site_setting_logo'))
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600">Current logo:</p>
                                    <img src="{{ Storage::url(cache('site_setting_logo')) }}" alt="Current Logo"
                                        class="h-16 w-auto mt-1">
                                </div>
                            @endif
                        </div>
                        <div>
                            <label for="favicon" class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                            <input type="file" id="favicon" name="favicon" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @if (cache('site_setting_favicon'))
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600">Current favicon:</p>
                                    <img src="{{ Storage::url(cache('site_setting_favicon')) }}" alt="Current Favicon"
                                        class="h-8 w-8 mt-1">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Hero Section -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Hero Section</h2>
                    <div class="space-y-6">
                        <div>
                            <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-2">Hero
                                Title</label>
                            <input type="text" id="hero_title" name="hero_title"
                                value="{{ cache('site_setting_hero_title') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Selamat Datang di MAUDU REJOSO">
                        </div>
                        <div>
                            <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 mb-2">Hero
                                Subtitle</label>
                            <textarea id="hero_subtitle" name="hero_subtitle" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Membangun generasi yang berakhlak mulia dan berprestasi">{{ cache('site_setting_hero_subtitle') }}</textarea>
                        </div>
                        <div>
                            <label for="hero_images" class="block text-sm font-medium text-gray-700 mb-2">Hero Images
                                (Multiple)</label>
                            <input type="file" id="hero_images" name="hero_images[]" accept="image/*" multiple
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">Pilih multiple gambar untuk hero carousel (max 5
                                gambar)</p>

                            @php
                                $heroImages = cache('site_setting_hero_images');
                                if ($heroImages) {
                                    $heroImages = json_decode($heroImages, true);
                                }
                            @endphp

                            @if ($heroImages && count($heroImages) > 0)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 mb-2">Current hero images:</p>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach ($heroImages as $index => $image)
                                            <div class="relative">
                                                <img src="{{ Storage::url($image) }}"
                                                    alt="Hero Image {{ $index + 1 }}"
                                                    class="h-24 w-full object-cover rounded">
                                                <div
                                                    class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                                                    {{ $index + 1 }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_email"
                                class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="contact_email" name="contact_email"
                                value="{{ cache('site_setting_contact_email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="contact_phone"
                                class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="text" id="contact_phone" name="contact_phone"
                                value="{{ cache('site_setting_contact_phone') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="contact_address"
                                class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <textarea id="contact_address" name="contact_address" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Jl. Contoh No. 123, Kota, Provinsi">{{ cache('site_setting_contact_address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Footer</h2>
                    <div>
                        <label for="footer_text" class="block text-sm font-medium text-gray-700 mb-2">Footer
                            Text</label>
                        <textarea id="footer_text" name="footer_text" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="© 2024 MAUDU REJOSO. All rights reserved.">{{ cache('site_setting_footer_text') }}</textarea>
                    </div>
                </div>

                <!-- Menu Management -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Menu Management</h2>

                    <!-- Header Menus -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Header Menus</h3>
                        @if ($headerMenus->count() > 0)
                            <div class="space-y-2">
                                @foreach ($headerMenus as $menu)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <span class="font-medium">{{ $menu->title }}</span>
                                            <span class="text-sm text-gray-500 ml-2">({{ $menu->slug }})</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.pages.edit', $menu->id) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                            <span class="text-gray-300">|</span>
                                            <span class="text-sm text-gray-500">Order:
                                                {{ $menu->menu_sort_order }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No header menus found. <a href="{{ route('admin.pages.create') }}"
                                    class="text-blue-600 hover:text-blue-800">Create a new page</a></p>
                        @endif
                    </div>

                    <!-- Footer Menus -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Footer Menus</h3>
                        @if ($footerMenus->count() > 0)
                            <div class="space-y-2">
                                @foreach ($footerMenus as $menu)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <span class="font-medium">{{ $menu->title }}</span>
                                            <span class="text-sm text-gray-500 ml-2">({{ $menu->slug }})</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.pages.edit', $menu->id) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                            <span class="text-gray-300">|</span>
                                            <span class="text-sm text-gray-500">Order:
                                                {{ $menu->menu_sort_order }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No footer menus found. <a href="{{ route('admin.pages.create') }}"
                                    class="text-blue-600 hover:text-blue-800">Create a new page</a></p>
                        @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.pages.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Create New Page/Menu
                        </a>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-between">
                    <form action="{{ route('admin.settings.landing-page.reset') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                            onclick="return confirm('Apakah Anda yakin ingin mengembalikan semua setting ke default? Tindakan ini tidak dapat dibatalkan.')">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Reset to Default
                        </button>
                    </form>

                    <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Limit hero images to maximum 5
        document.getElementById('hero_images').addEventListener('change', function(e) {
            const files = e.target.files;
            if (files.length > 5) {
                alert('Maksimal 5 gambar untuk hero carousel');
                e.target.value = '';
                return;
            }

            // Show preview of selected images
            const previewContainer = document.createElement('div');
            previewContainer.className = 'mt-4';
            previewContainer.innerHTML =
                '<p class="text-sm text-gray-600 mb-2">Preview gambar yang dipilih:</p><div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="preview-images"></div>';

            // Remove existing preview
            const existingPreview = document.getElementById('preview-images');
            if (existingPreview) {
                existingPreview.parentElement.remove();
            }

            // Add new preview
            this.parentElement.appendChild(previewContainer);

            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('div');
                        img.className = 'relative';
                        img.innerHTML = `
                            <img src="${e.target.result}" alt="Preview ${index + 1}" class="h-24 w-full object-cover rounded">
                            <div class="absolute top-1 right-1 bg-blue-500 bg-opacity-75 text-white text-xs px-1 rounded">
                                ${index + 1}
                            </div>
                        `;
                        document.getElementById('preview-images').appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</x-app-layout>
