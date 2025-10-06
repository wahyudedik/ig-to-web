<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Notification Center</h1>
                <p class="text-slate-600 mt-1">Manage system notifications and alerts</p>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="sendTestNotification()" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12 7H4.828z" />
                    </svg>
                    Send Test
                </button>
                <button onclick="markAllAsRead()" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Mark All Read
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
        <!-- Notification Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12 7H4.828z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Total Sent</p>
                        <p class="text-2xl font-bold text-slate-900" id="total-sent">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Delivered</p>
                        <p class="text-2xl font-bold text-slate-900" id="delivered">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Pending</p>
                        <p class="text-2xl font-bold text-slate-900" id="pending">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Failed</p>
                        <p class="text-2xl font-bold text-slate-900" id="failed">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Send Notification Form -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Send Notification</h3>
            <form id="notification-form" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Title</label>
                        <input type="text" id="notification-title" class="form-input"
                            placeholder="Notification title" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Type</label>
                        <select id="notification-type" class="form-select" required>
                            <option value="">Select type</option>
                            <option value="info">Info</option>
                            <option value="success">Success</option>
                            <option value="warning">Warning</option>
                            <option value="error">Error</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Message</label>
                    <textarea id="notification-message" class="form-textarea" rows="3" placeholder="Notification message"
                        required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Target Users</label>
                        <select id="notification-target" class="form-select" required>
                            <option value="">Select target</option>
                            <option value="all">All Users</option>
                            <option value="role">By Role</option>
                            <option value="specific">Specific Users</option>
                        </select>
                    </div>
                    <div id="role-selection" class="hidden">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
                        <select id="notification-role" class="form-select">
                            <option value="">Select role</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="admin">Admin</option>
                            <option value="guru">Guru</option>
                            <option value="siswa">Siswa</option>
                            <option value="sarpras">Sarpras</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="clearForm()" class="btn btn-secondary">Clear</button>
                    <button type="submit" class="btn btn-primary">Send Notification</button>
                </div>
            </form>
        </div>

        <!-- Notification History -->
        <div class="bg-white rounded-xl border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Notification History</h3>
            </div>

            <div class="divide-y divide-slate-200">
                <div id="notifications-list">
                    <!-- Notifications will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load notifications on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            loadNotificationStats();

            // Auto-refresh every 30 seconds
            setInterval(loadNotifications, 30000);
        });

        // Handle target selection change
        document.getElementById('notification-target').addEventListener('change', function() {
            const roleSelection = document.getElementById('role-selection');
            if (this.value === 'role') {
                roleSelection.classList.remove('hidden');
            } else {
                roleSelection.classList.add('hidden');
            }
        });

        // Handle form submission
        document.getElementById('notification-form').addEventListener('submit', function(e) {
            e.preventDefault();
            sendNotification();
        });

        function loadNotifications() {
            fetch('{{ route('api.notifications.list') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayNotifications(data.data);
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                });
        }

        function loadNotificationStats() {
            fetch('{{ route('api.notifications.stats') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStats(data.data);
                    }
                })
                .catch(error => {
                    console.error('Error loading notification stats:', error);
                });
        }

        function displayNotifications(notifications) {
            const container = document.getElementById('notifications-list');

            if (notifications.length === 0) {
                container.innerHTML = `
                    <div class="px-6 py-8 text-center">
                        <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12 7H4.828z" />
                        </svg>
                        <p class="text-slate-600">No notifications found</p>
                    </div>
                `;
                return;
            }

            const notificationsHtml = notifications.map(notification => `
                <div class="px-6 py-4 flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center ${getNotificationIconClass(notification.type)}">
                            ${getNotificationIcon(notification.type)}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-medium text-slate-900">${notification.title}</h4>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full ${getStatusBadgeClass(notification.status)}">
                                    ${notification.status}
                                </span>
                                <span class="text-xs text-slate-500">${formatDate(notification.created_at)}</span>
                            </div>
                        </div>
                        <p class="text-sm text-slate-600 mt-1">${notification.message}</p>
                        <div class="mt-2 text-xs text-slate-500">
                            <span>Target: ${notification.target_type}</span>
                            <span class="mx-2">•</span>
                            <span>Sent: ${notification.sent_count}</span>
                            <span class="mx-2">•</span>
                            <span>Delivered: ${notification.delivered_count}</span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <button onclick="deleteNotification('${notification.id}')" class="text-red-600 hover:text-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            `).join('');

            container.innerHTML = notificationsHtml;
        }

        function updateStats(stats) {
            document.getElementById('total-sent').textContent = stats.total_sent;
            document.getElementById('delivered').textContent = stats.delivered;
            document.getElementById('pending').textContent = stats.pending;
            document.getElementById('failed').textContent = stats.failed;
        }

        function sendNotification() {
            const formData = {
                title: document.getElementById('notification-title').value,
                message: document.getElementById('notification-message').value,
                type: document.getElementById('notification-type').value,
                target_type: document.getElementById('notification-target').value,
                target_value: document.getElementById('notification-target').value === 'role' ?
                    document.getElementById('notification-role').value :
                    null
            };

            fetch('{{ route('api.notifications.send') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Notification sent successfully!');
                        clearForm();
                        loadNotifications();
                        loadNotificationStats();
                    } else {
                        alert('Error sending notification: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error sending notification');
                });
        }

        function sendTestNotification() {
            const formData = {
                title: 'Test Notification',
                message: 'This is a test notification to verify the system is working correctly.',
                type: 'info',
                target_type: 'all'
            };

            fetch('{{ route('api.notifications.send') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Test notification sent successfully!');
                        loadNotifications();
                        loadNotificationStats();
                    } else {
                        alert('Error sending test notification: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error sending test notification');
                });
        }

        function markAllAsRead() {
            fetch('{{ route('api.notifications.mark-all-read') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('All notifications marked as read!');
                        loadNotifications();
                    } else {
                        alert('Error marking notifications as read: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error marking notifications as read');
                });
        }

        function deleteNotification(notificationId) {
            if (confirm('Are you sure you want to delete this notification?')) {
                fetch(`{{ route('api.notifications.delete', '') }}/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadNotifications();
                            loadNotificationStats();
                        } else {
                            alert('Error deleting notification: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting notification');
                    });
            }
        }

        function clearForm() {
            document.getElementById('notification-form').reset();
            document.getElementById('role-selection').classList.add('hidden');
        }

        function getNotificationIcon(type) {
            const icons = {
                info: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                success: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                warning: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                error: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
            };
            return icons[type] || icons.info;
        }

        function getNotificationIconClass(type) {
            const classes = {
                info: 'bg-blue-100 text-blue-600',
                success: 'bg-green-100 text-green-600',
                warning: 'bg-yellow-100 text-yellow-600',
                error: 'bg-red-100 text-red-600'
            };
            return classes[type] || classes.info;
        }

        function getStatusBadgeClass(status) {
            const classes = {
                sent: 'bg-green-100 text-green-800',
                pending: 'bg-yellow-100 text-yellow-800',
                failed: 'bg-red-100 text-red-800',
                delivered: 'bg-blue-100 text-blue-800'
            };
            return classes[status] || classes.pending;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
        }
    </script>
</x-app-layout>
