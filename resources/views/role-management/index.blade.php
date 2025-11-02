<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Role Management') }}</h2>
                <p class="text-sm text-gray-600 mt-1">Kelola roles dengan lengkap: nama, deskripsi, permissions, dan
                    assign users</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>Create New Role
                </a>
                <a href="{{ route('admin.role-permissions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-key mr-2"></i>Permission Manager
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Users Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Permissions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($roles as $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold">{{ $role->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $role->users_count }} users</td>
                                <td class="px-6 py-4">{{ $role->permissions->count() }} permissions</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.roles.edit', $role) }}"
                                            class="text-blue-600 hover:text-blue-900" title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.roles.assign-users', $role) }}"
                                            class="text-green-600 hover:text-green-900" title="Assign Users">
                                            <i class="fas fa-users"></i>
                                        </a>
                                        @if (!in_array($role->name, ['superadmin', 'admin', 'guru', 'siswa', 'sarpras']))
                                            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                                                class="inline"
                                                data-confirm="Apakah Anda yakin ingin menghapus role {{ $role->name }}? Tindakan ini tidak dapat dibatalkan.">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    title="Delete Role">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400" title="Core role tidak dapat dihapus">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    <p class="text-sm">Tidak ada role yang ditemukan.</p>
                                    <a href="{{ route('admin.roles.create') }}"
                                        class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                                        Buat role baru
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Display flash messages
                @if (session('success'))
                    showSuccess('Berhasil!', '{{ session('success') }}');
                @endif

                @if (session('error'))
                    showError('Error!', '{{ session('error') }}');
                @endif
            });
        </script>
    @endpush
</x-app-layout>
