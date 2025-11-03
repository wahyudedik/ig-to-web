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
        // Skip if user was just created (created() method will handle it)
        // But allow sync if roles are loaded and user_type differs (e.g., after role assignment)
        if ($user->relationLoaded('roles')) {
            // Only skip if user was just created AND has no roles yet (to avoid premature sync)
            // If roles are loaded and user exists, allow sync
            if (!$user->wasRecentlyCreated || $user->roles->isNotEmpty()) {
                $this->syncUserType($user);
            }
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
            // Now that user_type is VARCHAR (not ENUM), we can sync ANY role name
            // This supports both core roles and custom roles (e.g., 'osis', 'bendahara', etc.)
            if ($user->user_type !== $roleName) {
                // Use updateQuietly to prevent infinite loop (no events fired)
                $user->updateQuietly(['user_type' => $roleName]);
            }
        } elseif (!$primaryRole && !$user->user_type) {
            // If user has no roles and no user_type, set default
            $user->updateQuietly(['user_type' => 'siswa']); // Default fallback
        }
    }
}
