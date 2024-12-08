<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can view a specific model.
     */
    // public function view(User $currentUser, User $user): bool
    // {
    //     return $currentUser->id === $user->id || $currentUser->is_admin;
    // }
    public function view(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id;
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id || $currentUser->is_admin;
    }

    /**
     * Determine if the user can deactivate the model.
     */
    public function deactivate(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id;
    }

    // Deactivate the user account.
    public function changePassword(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id;
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id || $currentUser->is_admin;
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $currentUser, User $user): bool
    {
        return $currentUser->is_admin;
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $currentUser, User $user): bool
    {
        return $currentUser->is_admin;
    }
}
