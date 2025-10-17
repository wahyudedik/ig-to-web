<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ruang;
use Illuminate\Auth\Access\HandlesAuthorization;

class RuangPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('sarpras.view') || $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ruang $ruang): bool
    {
        return $user->can('sarpras.view') || $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('sarpras.create') || $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ruang $ruang): bool
    {
        return $user->can('sarpras.edit') || $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ruang $ruang): bool
    {
        return $user->can('sarpras.delete') || $user->hasRole(['superadmin', 'admin']);
    }
}
