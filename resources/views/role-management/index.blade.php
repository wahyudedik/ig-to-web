<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Role Management') }}</h2>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Create New Role</a>
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
                        @foreach ($roles as $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold">{{ $role->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $role->users_count }} users</td>
                                <td class="px-6 py-4">{{ $role->permissions->count() }} permissions</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.roles.edit', $role) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @if (!in_array($role->name, ['superadmin', 'admin', 'guru', 'sarpras']))
                                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                                            class="inline" data-confirm="Delete this role?">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 ml-3">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
