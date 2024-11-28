<?php

namespace App\Policies;

use App\Models\Ingreso;
use App\Models\User;

class IngresoPolicy
{

    public function viewAny(User $user): bool
    {
        // Si deseas permitir que cualquier usuario vea los ingresos, retorna true
        return true;
    }

    public function create(User $user): bool
    {
        // Si deseas permitir que cualquier usuario cree ingresos, retorna true
        return true;
    }

    public function restore(User $user, Ingreso $ingreso): bool
    {
        // El usuario puede restaurar el modelo si es el propietario o un administrador
        return $user->is_admin || $ingreso->user_id === $user->id;
    }

    public function view(User $user, Ingreso $ingreso)
    {
        // Lógica más específica para verificar si el usuario puede ver el ingreso
        return $ingreso->project->users->contains($user) || $user->is_admin;
    }

    public function update(User $user, Ingreso $ingreso)
    {
        return $user->id === $ingreso->user_id;
    }

    public function delete(User $user, Ingreso $ingreso)
    {
        return $this->canUpdateOrDelete($user, $ingreso);
    }

    public function forceDelete(User $user, Ingreso $ingreso)
    {
        return $this->canUpdateOrDelete($user, $ingreso);
    }

    private function canUpdateOrDelete(User $user, Ingreso $ingreso)
    {
        return $user->is_admin || $ingreso->user_id === $user->id;
    }

}
