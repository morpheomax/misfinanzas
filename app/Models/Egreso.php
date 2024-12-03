<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Egreso extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = ['categoria', 'nombre', 'monto', 'fecha', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
// Scope para filtrar ingresos por usuario
    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Método de validación (opcional)
    public static function validate($data)
    {
        return Validator::make($data, [
            'categoria' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);
    }
    // Mutador para asegurar que el monto esté en el formato correcto
    public function setMontoAttribute($value)
    {
        $this->attributes['monto'] = number_format($value, 2, '.', ''); // Formatea a dos decimales
    }
}
