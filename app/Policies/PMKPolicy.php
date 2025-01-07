<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PMK;
use Illuminate\Auth\Access\HandlesAuthorization;

class PMKPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_p::m::k');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PMK $pMK): bool
    {
        return $user->can('view_p::m::k');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_p::m::k');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PMK $pMK): bool
    {
        return $user->can('update_p::m::k');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PMK $pMK): bool
    {
        return $user->can('delete_p::m::k');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_p::m::k');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PMK $pMK): bool
    {
        return $user->can('force_delete_p::m::k');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_p::m::k');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PMK $pMK): bool
    {
        return $user->can('restore_p::m::k');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_p::m::k');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PMK $pMK): bool
    {
        return $user->can('replicate_p::m::k');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_p::m::k');
    }
}
