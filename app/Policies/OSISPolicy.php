<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Calon;
use Illuminate\Auth\Access\HandlesAuthorization;

class OSISPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('osis.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Calon $calon): bool
    {
        return $user->can('osis.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('osis.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Calon $calon): bool
    {
        return $user->can('osis.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Calon $calon): bool
    {
        return $user->can('osis.delete');
    }

    /**
     * Determine whether the user can vote.
     */
    public function vote(User $user): bool
    {
        return $user->can('osis.vote');
    }

    /**
     * Determine whether the user can view results.
     */
    public function viewResults(User $user): bool
    {
        return $user->can('osis.results');
    }

    /**
     * Determine whether the user can manage voters.
     */
    public function manageVoters(User $user): bool
    {
        return $user->can('osis.edit');
    }

    /**
     * Determine whether the user can import candidates.
     */
    public function import(User $user): bool
    {
        return $user->can('osis.create');
    }

    /**
     * Determine whether the user can export data.
     */
    public function export(User $user): bool
    {
        return $user->can('osis.view');
    }
}