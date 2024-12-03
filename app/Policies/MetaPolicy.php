<?php

namespace App\Policies;

use App\Models\Meta;
use App\Models\User;

class MetaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Meta $meta): bool
    {
        // Lógica más específica para verificar si el usuario puede ver el ingreso
        return $meta->project->users->contains($user) || $user->is_admin;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Meta $meta): bool
    {
        //
        return $user->id === $meta->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Meta $meta): bool
    {
        //
        return $this->canUpdateOrDelete($user, $meta);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Meta $meta): bool
    {
        // El usuario puede restaurar el modelo si es el propietario o un administrador
        return $user->is_admin || $meta->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Meta $meta): bool
    {
        //
        return $this->canUpdateOrDelete($user, $meta);
    }
    private function canUpdateOrDelete(User $user, Meta $meta)
    {
        return $user->is_admin || $meta->user_id === $user->id;
    }
}
