<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\SystemNotification;
use App\Models\User;
use App\Models\AuditLog;

class NotificationController extends Controller
{
    /**
     * Send system-wide notification
     */
    public function sendSystemNotification(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,error,success',
            'target_users' => 'nullable|array',
            'target_roles' => 'nullable|array',
        ]);

        $users = collect();

        // Get target users
        if ($request->target_users) {
            $users = $users->merge(User::whereIn('id', $request->target_users)->get());
        }

        // Get users by roles
        if ($request->target_roles) {
            $roleUsers = User::role($request->target_roles)->get();
            $users = $users->merge($roleUsers);
        }

        // If no specific targets, send to all users
        if ($users->isEmpty()) {
            $users = User::all();
        }

        $notification = [
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'created_at' => now(),
        ];

        $sentCount = 0;
        foreach ($users as $user) {
            try {
                // Send notification
                if ($user->email) {
                    $user->notify(new SystemNotification($notification));
                }

                $sentCount++;
            } catch (\Exception $e) {
                Log::error("Failed to send notification to user {$user->id}: " . $e->getMessage());
            }
        }

        // Log the action
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'notification_sent',
            'description' => "Sent system notification: {$request->title}",
            'metadata' => [
                'notification_type' => $request->type,
                'target_count' => $sentCount,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => "Notification sent to {$sentCount} users",
            'sent_count' => $sentCount,
        ]);
    }

    /**
     * Get user notifications
     */
    public function getUserNotifications(Request $request): JsonResponse
    {
        $user = Auth::user();
        $perPage = $request->get('per_page', 15);
        $unreadOnly = $request->get('unread_only', false);

        $query = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', 'App\Models\User')
            ->orderBy('created_at', 'desc');

        if ($unreadOnly) {
            $query->whereNull('read_at');
        }

        $notifications = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $request->validate([
            'notification_id' => 'required|string'
        ]);

        $user = Auth::user();
        $notification = DB::table('notifications')
            ->where('id', $request->notification_id)
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', 'App\Models\User')
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        // Mark as read
        DB::table('notifications')
            ->where('id', $request->notification_id)
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $user = Auth::user();

        $updated = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', 'App\Models\User')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => "Marked {$updated} notifications as read"
        ]);
    }

    /**
     * Delete notification
     */
    public function deleteNotification(Request $request, $id): JsonResponse
    {
        $user = Auth::user();

        $deleted = DB::table('notifications')
            ->where('id', $id)
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', 'App\Models\User')
            ->delete();

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted'
        ]);
    }

    /**
     * Get notification statistics
     */
    public function getNotificationStats(Request $request): JsonResponse
    {
        $user = Auth::user();

        $total = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', 'App\Models\User')
            ->count();

        $unread = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', 'App\Models\User')
            ->whereNull('read_at')
            ->count();

        $read = $total - $unread;

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'unread' => $unread,
                'read' => $read,
            ]
        ]);
    }

    /**
     * Get notification templates
     */
    public function getNotificationTemplates(Request $request): JsonResponse
    {
        $templates = [
            'welcome' => [
                'title' => 'Welcome to the System',
                'message' => 'Welcome! You have successfully joined our platform.',
                'type' => 'success',
            ],
            'maintenance' => [
                'title' => 'System Maintenance',
                'message' => 'The system will be under maintenance from {start_time} to {end_time}.',
                'type' => 'warning',
            ],
            'update' => [
                'title' => 'System Update',
                'message' => 'A new system update is available. Please check the changelog for details.',
                'type' => 'info',
            ],
            'security' => [
                'title' => 'Security Alert',
                'message' => 'Please update your password for security reasons.',
                'type' => 'error',
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $templates
        ]);
    }

    /**
     * Send bulk notifications
     */
    public function sendBulkNotifications(Request $request): JsonResponse
    {
        $request->validate([
            'notifications' => 'required|array|min:1',
            'notifications.*.title' => 'required|string|max:255',
            'notifications.*.message' => 'required|string',
            'notifications.*.type' => 'required|in:info,warning,error,success',
            'target_users' => 'nullable|array',
            'target_roles' => 'nullable|array',
        ]);

        $users = collect();

        // Get target users
        if ($request->target_users) {
            $users = $users->merge(User::whereIn('id', $request->target_users)->get());
        }

        // Get users by roles
        if ($request->target_roles) {
            $roleUsers = User::role($request->target_roles)->get();
            $users = $users->merge($roleUsers);
        }

        // If no specific targets, send to all users
        if ($users->isEmpty()) {
            $users = User::all();
        }

        $results = [];
        $totalSent = 0;

        foreach ($request->notifications as $notificationData) {
            $sentCount = 0;

            foreach ($users as $user) {
                try {
                    $notification = [
                        'title' => $notificationData['title'],
                        'message' => $notificationData['message'],
                        'type' => $notificationData['type'],
                        'created_at' => now(),
                    ];

                    // Store in database
                    DB::table('notifications')->insert([
                        'id' => \Illuminate\Support\Str::uuid(),
                        'type' => SystemNotification::class,
                        'notifiable_type' => 'App\Models\User',
                        'notifiable_id' => $user->id,
                        'data' => json_encode($notification),
                        'read_at' => null,
                    ]);
                    $sentCount++;
                } catch (\Exception $e) {
                    Log::error("Failed to send bulk notification to user {$user->id}: " . $e->getMessage());
                }
            }

            $results[] = [
                'notification' => $notificationData,
                'sent_count' => $sentCount,
            ];

            $totalSent += $sentCount;
        }

        // Log the action
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'bulk_notification_sent',
            'description' => "Sent bulk notifications: {$totalSent} total",
            'metadata' => [
                'notification_count' => count($request->notifications),
                'total_sent' => $totalSent,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => "Bulk notifications sent successfully",
            'data' => [
                'total_sent' => $totalSent,
                'results' => $results,
            ]
        ]);
    }
}
