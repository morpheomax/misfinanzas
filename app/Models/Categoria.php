<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    /**
     * Los campos que pueden ser rellenados de forma masiva.
     */
    protected $fillable = [
        'nombre',
        'tipo',
        'user_id',
    ];

    /**
     * Relación con el modelo User.
     * Indica que la categoría pertenece a un usuario (opcional para categorías generales).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
