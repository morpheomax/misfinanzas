<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;

class CategoriaPolicy
{
    /**
     * Determine si el usuario puede ver cualquier categoría.
     */
    public function viewAny(User $user)
    {
        return true; // Permitir que cualquier usuario vea categorías
    }

    /**
     * Determine si el usuario puede ver una categoría específica.
     */
    public function view(User $user, Categoria $categoria)
    {
        // Permitir solo si el usuario es el propietario o la categoría es pública (opcional)
        return $categoria->user_id === $user->id || $categoria->user_id === null;
    }

    /**
     * Determine si el usuario puede crear categorías.
     */
    public function create(User $user)
    {
        // Puedes agregar lógica adicional, como roles o permisos
        return true; // Permitir que todos los usuarios creen categorías
    }

    /**
     * Determine si el usuario puede actualizar una categoría.
     */
    public function update(User $user, Categoria $categoria)
    {
        return $categoria->user_id === $user->id; // Solo el propietario puede actualizar
    }

    /**
     * Determine si el usuario puede eliminar una categoría.
     */
    public function delete(User $user, Categoria $categoria)
    {
        return $categoria->user_id === $user->id; // Solo el propietario puede eliminar
    }
}
