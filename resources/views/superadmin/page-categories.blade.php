<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Categories - Superadmin Dashboard</title>

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
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Page Categories</h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        Manage page categories for better organization
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('superadmin.page-management') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Pages
                    </a>
                    <button onclick="openCreateModal()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                        <i class="fas fa-plus mr-2"></i>
                        Add Category
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Categories List -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Categories</h3>
                </div>

                @if ($categories->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Slug
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Pages
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                        <i class="fas fa-folder text-blue-600 dark:text-blue-400"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $category->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $category->slug }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                            {{ Str::limit($category->description, 50) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $category->pages_count ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button
                                                    onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}', {{ $category->is_active ? 'true' : 'false' }})"
                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="deleteCategory({{ $category->id }})"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-folder-open text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No categories found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by creating your first category.
                        </p>
                        <button onclick="openCreateModal()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                            <i class="fas fa-plus mr-2"></i>
                            Create Category
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Create/Edit Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalTitle">Create Category</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="categoryForm" method="POST">
                    @csrf
                    <div id="methodField"></div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="categoryName" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Enter category name">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="categoryDescription" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Enter category description"></textarea>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="categoryActive" value="1" checked
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="categoryActive" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                            <i class="fas fa-save mr-2"></i>
                            Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2024 Website Sekolah. Semua hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Create Category';
            document.getElementById('categoryForm').action = '{{ route('superadmin.page-categories-store') }}';
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('categoryName').value = '';
            document.getElementById('categoryDescription').value = '';
            document.getElementById('categoryActive').checked = true;
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function openEditModal(id, name, description, isActive) {
            document.getElementById('modalTitle').textContent = 'Edit Category';
            document.getElementById('categoryForm').action = '{{ route('superadmin.page-categories-update', ':id') }}'
                .replace(':id', id);
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('categoryName').value = name;
            document.getElementById('categoryDescription').value = description;
            document.getElementById('categoryActive').checked = isActive;
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        function deleteCategory(id) {
            if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('superadmin.page-categories-destroy', ':id') }}'.replace(':id', id);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                const tokenField = document.createElement('input');
                tokenField.type = 'hidden';
                tokenField.name = '_token';
                tokenField.value = '{{ csrf_token() }}';

                form.appendChild(methodField);
                form.appendChild(tokenField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('categoryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>

</html>
