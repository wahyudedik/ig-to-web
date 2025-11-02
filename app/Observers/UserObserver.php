<?php

namespace App\Observers;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserObserver
{
    /**
     * Handle the User "saved" event.
     * Sync user_type with primary role
     */
    public function saved(User $user): void
    {
        // Only sync if roles relationship is loaded (avoid N+1)
        // AND if user_type was not just updated (to prevent infinite loop)
        if ($user->relationLoaded('roles') && !$user->wasRecentlyCreated) {
            $this->syncUserType($user);
        }
    }

    /**
     * Handle the User "created" event.
     * Sync user_type with primary role after creation
     */
    public function created(User $user): void
    {
        // Load roles if not loaded
        if (!$user->relationLoaded('roles')) {
            $user->load('roles');
        }

        // Sync after creation
        $this->syncUserType($user);
    }

    /**
     * Sync user_type column with primary role from Spatie Permission
     * Primary role = first role in user's roles collection
     * 
     * NOTE: This method uses updateQuietly() to prevent infinite loops
     */
    protected function syncUserType(User $user): void
    {
        // Skip if user_type was just manually set (avoid overriding intentional changes)
        // Only sync if roles exist and user_type differs
        $primaryRole = $user->roles->first();

        if ($primaryRole) {
            $roleName = $primaryRole->name;
            // Only update if different AND role name is in valid enum values
            $validUserTypes = ['superadmin', 'admin', 'guru', 'siswa', 'sarpras'];
            if ($user->user_type !== $roleName && in_array($roleName, $validUserTypes)) {
                // Use updateQuietly to prevent infinite loop (no events fired)
                $user->updateQuietly(['user_type' => $roleName]);
            } elseif ($user->user_type !== $roleName && !in_array($roleName, $validUserTypes)) {
                // Custom role not in enum - keep existing user_type or set to first valid role
                // Don't update user_type for custom roles
            }
        } elseif (!$primaryRole && !$user->user_type) {
            // If user has no roles and no user_type, set default
            $user->updateQuietly(['user_type' => 'siswa']); // Default fallback
        }
    }
}
