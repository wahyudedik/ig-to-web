<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Role & Permission Manager</h1>
                <p class="text-slate-600 mt-1">Manage user roles and permissions with granular control</p>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="showCreateRoleModal()" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create New Role
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Current Roles Table -->
        <div class="bg-white rounded-xl border border-slate-200 mb-8">
            <div class="px-6 py-4 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-900">Current Roles</h3>
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <input type="text" id="role-search" placeholder="Search roles..."
                                class="form-input pl-10">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Role Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Abbreviation
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Users
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Permissions
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach ($roles as $role)
                            <tr class="role-row" data-role-name="{{ strtolower($role->name) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div
                                                class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-600">
                                                    {{ strtoupper(substr($role->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900">{{ ucfirst($role->name) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800">
                                        {{ strtoupper(substr($role->name, 0, 3)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $role->users_count ?? $role->users->count() }} users
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($role->permissions->take(3) as $permission)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        @if ($role->permissions->count() > 3)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                                +{{ $role->permissions->count() - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="editRole({{ $role->id }})"
                                            class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button onclick="deleteRole({{ $role->id }})"
                                            class="text-red-600 hover:text-red-900">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Permission Groups -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach ($permissions as $group => $groupPermissions)
                <div class="bg-white rounded-xl border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900">{{ ucfirst($group) }} Permissions</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach ($groupPermissions as $permission)
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">{{ $permission->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $permission->name }}</div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @foreach ($roles as $role)
                                            <input type="checkbox"
                                                class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                data-role="{{ $role->id }}"
                                                data-permission="{{ $permission->id }}"
                                                {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Create Role Modal -->
    <div id="createRoleModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Create New Role</h3>
                <form id="createRoleForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
                        <input type="text" id="roleName" name="name" class="form-input"
                            placeholder="Enter role name" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                        <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-md p-2">
                            @foreach ($permissions as $group => $groupPermissions)
                                <div class="mb-2">
                                    <div class="text-sm font-medium text-gray-700 mb-1">{{ ucfirst($group) }}</div>
                                    @foreach ($groupPermissions as $permission)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="permissions[]"
                                                value="{{ $permission->name }}"
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeCreateRoleModal()"
                            class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div id="editRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Role</h3>
                <form id="editRoleForm">
                    <input type="hidden" id="editRoleId" name="role_id">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
                        <input type="text" id="editRoleName" name="name" class="form-input"
                            placeholder="Enter role name" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                        <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-md p-2">
                            @foreach ($permissions as $group => $groupPermissions)
                                <div class="mb-2">
                                    <div class="text-sm font-medium text-gray-700 mb-1">{{ ucfirst($group) }}</div>
                                    @foreach ($groupPermissions as $permission)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="permissions[]"
                                                value="{{ $permission->name }}"
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditRoleModal()"
                            class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('role-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.role-row');

            rows.forEach(row => {
                const roleName = row.dataset.roleName;
                if (roleName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Modal functions
        function showCreateRoleModal() {
            document.getElementById('createRoleModal').classList.remove('hidden');
        }

        function closeCreateRoleModal() {
            document.getElementById('createRoleModal').classList.add('hidden');
            document.getElementById('createRoleForm').reset();
        }

        function closeEditRoleModal() {
            document.getElementById('editRoleModal').classList.add('hidden');
            document.getElementById('editRoleForm').reset();
        }

        // Create role form submission
        document.getElementById('createRoleForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const permissions = Array.from(document.querySelectorAll('input[name="permissions[]"]:checked'))
                .map(input => input.value);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Creating...';
            submitBtn.disabled = true;

            fetch('{{ route('admin.role-permissions.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        name: formData.get('name'),
                        permissions: permissions
                    })
                })
                .then(async response => {
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error(`Unexpected response format. Status: ${response.status}`);
                    }
                    const data = await response.json();
                    return {
                        ok: response.ok,
                        status: response.status,
                        data
                    };
                })
                .then(result => {
                    if (!result.ok) {
                        if (result.status === 422) {
                            const errors = result.data.errors || {};
                            let errorMsg = 'Validation errors:<br>';
                            for (const [field, fieldErrors] of Object.entries(errors)) {
                                errorMsg +=
                                    `<strong>${field}:</strong> ${Array.isArray(fieldErrors) ? fieldErrors.join(', ') : fieldErrors}<br>`;
                            }
                            showError('Error Validasi!', errorMsg);
                        } else if (result.status === 401 || result.status === 403) {
                            showError('Unauthorized!', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
                        } else {
                            showError('Error!', result.data.message || 'Gagal membuat role');
                        }
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                        return;
                    }

                    if (result.data.success) {
                        showSuccess('Berhasil!', 'Role berhasil dibuat').then(() => {
                            location.reload();
                        });
                    } else {
                        showError('Error!', 'Gagal membuat role: ' + (result.data.message || 'Unknown error'));
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorMessage = error.message || 'Unknown error occurred';
                    showError('Error!', 'Gagal membuat role: ' + errorMessage);
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Edit role form submission
        document.getElementById('editRoleForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const roleId = formData.get('role_id');
            const permissions = Array.from(document.querySelectorAll(
                    '#editRoleModal input[name="permissions[]"]:checked'))
                .map(input => input.value);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;

            fetch(`/admin/role-permissions/roles/${roleId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        name: formData.get('name'),
                        permissions: permissions
                    })
                })
                .then(async response => {
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error(`Unexpected response format. Status: ${response.status}`);
                    }
                    const data = await response.json();
                    return {
                        ok: response.ok,
                        status: response.status,
                        data
                    };
                })
                .then(result => {
                    if (!result.ok) {
                        if (result.status === 422) {
                            const errors = result.data.errors || {};
                            let errorMsg = 'Validation errors:<br>';
                            for (const [field, fieldErrors] of Object.entries(errors)) {
                                errorMsg +=
                                    `<strong>${field}:</strong> ${Array.isArray(fieldErrors) ? fieldErrors.join(', ') : fieldErrors}<br>`;
                            }
                            showError('Error Validasi!', errorMsg);
                        } else if (result.status === 401 || result.status === 403) {
                            showError('Unauthorized!', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
                        } else {
                            showError('Error!', result.data.message || 'Gagal mengupdate role');
                        }
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                        return;
                    }

                    if (result.data.success) {
                        showSuccess('Berhasil!', 'Role berhasil diupdate').then(() => {
                            location.reload();
                        });
                    } else {
                        showError('Error!', 'Gagal mengupdate role: ' + (result.data.message ||
                            'Unknown error'));
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorMessage = error.message || 'Unknown error occurred';
                    showError('Error!', 'Gagal mengupdate role: ' + errorMessage);
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Edit role
        function editRole(roleId) {
            // Find the role data
            const roleRow = document.querySelector(`button[onclick="editRole(${roleId})"]`).closest('tr');
            const roleName = roleRow.querySelector('td:first-child').textContent.trim();

            // Get role permissions (this would need to be passed from backend)
            // For now, we'll fetch the role data
            fetch(`/admin/role-permissions/roles/${roleId}/permissions`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(async response => {
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error(`Unexpected response format. Status: ${response.status}`);
                    }
                    const data = await response.json();
                    return {
                        ok: response.ok,
                        status: response.status,
                        data
                    };
                })
                .then(result => {
                    if (!result.ok) {
                        if (result.status === 401 || result.status === 403) {
                            showError('Unauthorized!', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
                        } else {
                            showError('Error!', result.data.message || 'Gagal memuat data role');
                        }
                        return;
                    }

                    if (result.data.success) {
                        // Fill edit modal
                        document.getElementById('editRoleId').value = roleId;
                        document.getElementById('editRoleName').value = roleName;

                        // Clear all checkboxes first
                        document.querySelectorAll('#editRoleModal input[type="checkbox"]').forEach(checkbox => {
                            checkbox.checked = false;
                        });

                        // Check the permissions this role has
                        if (result.data.permissions) {
                            result.data.permissions.forEach(permissionName => {
                                const checkbox = document.querySelector(
                                    `#editRoleModal input[value="${permissionName}"]`);
                                if (checkbox) {
                                    checkbox.checked = true;
                                }
                            });
                        }

                        // Show edit modal
                        document.getElementById('editRoleModal').classList.remove('hidden');
                    } else {
                        showError('Error!', 'Gagal memuat data role: ' + (result.data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Error!', 'Gagal memuat data role: ' + error.message);
                });
        }

        // Delete role
        function deleteRole(roleId) {
            showConfirm(
                'Hapus Role?',
                'Apakah Anda yakin ingin menghapus role ini? Tindakan ini tidak dapat dibatalkan.',
                'Ya, Hapus',
                'Batal'
            ).then((result) => {
                if (result.isConfirmed) {
                    showLoading('Menghapus...', 'Mohon tunggu sebentar');
                    fetch(`/admin/role-permissions/roles/${roleId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => Promise.reject(err));
                            }
                            return response.json();
                        })
                        .then(data => {
                            closeLoading();
                            if (data.success) {
                                showSuccess('Berhasil!', 'Role berhasil dihapus').then(() => {
                                    location.reload();
                                });
                            } else {
                                showError('Error!', 'Gagal menghapus role: ' + data.message);
                            }
                        })
                        .catch(error => {
                            closeLoading();
                            console.error('Error:', error);
                            const errorMessage = error.message || 'Unknown error occurred';
                            showError('Error!', 'Gagal menghapus role: ' + errorMessage);
                        });
                }
            });
        }
    </script>
</x-app-layout>
