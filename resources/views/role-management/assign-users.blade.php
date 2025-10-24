<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign Users to Role: ') . $role->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Roles
                        </a>
                    </div>

                    <form action="{{ route('admin.roles.sync-users', $role) }}" method="POST" id="assignUsersForm">
                        @csrf
                        @method('POST')

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Role Information</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Role Name</label>
                                        <p class="text-sm text-gray-900">{{ $role->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Display Name</label>
                                        <p class="text-sm text-gray-900">{{ $role->display_name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Current Users</label>
                                        <p class="text-sm text-gray-900">{{ $role->users->count() }} users</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Select Users</h3>
                            <div class="max-h-96 overflow-y-auto border border-gray-300 rounded-md p-4">
                                <div class="space-y-2">
                                    @foreach ($users as $user)
                                        <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                                {{ in_array($user->id, $roleUsers) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}
                                                        </p>
                                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                            @if ($user->user_type === 'superadmin') bg-red-100 text-red-800
                                                            @elseif($user->user_type === 'admin') bg-blue-100 text-blue-800
                                                            @elseif($user->user_type === 'guru') bg-green-100 text-green-800
                                                            @elseif($user->user_type === 'sarpras') bg-yellow-100 text-yellow-800
                                                            @elseif($user->user_type === 'siswa') bg-purple-100 text-purple-800
                                                            @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst($user->user_type) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Update User Assignments
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('assignUsersForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const userIds = Array.from(document.querySelectorAll('input[name="user_ids[]"]:checked'))
                .map(input => input.value);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        user_ids: userIds
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showSuccess('User assignments updated successfully!');
                        setTimeout(() => {
                            window.location.href = '{{ route('admin.roles.index') }}';
                        }, 1500);
                    } else {
                        showError('Error updating user assignments: ' + data.message);
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorMessage = error.message || 'Unknown error occurred';
                    showError('Error updating user assignments: ' + errorMessage);
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });
    </script>
</x-app-layout>
