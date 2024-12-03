<?php

namespace App\Policies;

use App\Models\Egreso;
use App\Models\User;

class EgresoPolicy
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
    public function view(User $user, Egreso $egreso): bool
    {
        //
        // Lógica más específica para verificar si el usuario puede ver el ingreso
        return $egreso->project->users->contains($user) || $user->is_admin;
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
    public function update(User $user, Egreso $egreso): bool
    {
        //
        return $user->id === $egreso->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Egreso $egreso): bool
    {
        //
        return $this->canUpdateOrDelete($user, $egreso);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Egreso $egreso): bool
    {
        // El usuario puede restaurar el modelo si es el propietario o un administrador
        return $user->is_admin || $egreso->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Egreso $egreso): bool
    {
        //
        return $this->canUpdateOrDelete($user, $egreso);
    }
    private function canUpdateOrDelete(User $user, Egreso $egreso)
    {
        return $user->is_admin || $egreso->user_id === $user->id;
    }
}
