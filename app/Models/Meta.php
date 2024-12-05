<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Meta extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = ['nombre', 'monto', 'monto_ahorrado', 'fecha', 'estado', 'user_id'];
    //
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
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'monto_ahorrado' => 'required|numeric',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,cumplida',
            'user_id' => 'required|exists:users,id', // Asegura que el 'user_id' exista en la tabla 'users'
        ]);
    }
    // Mutador para asegurar que el monto esté en el formato correcto
    public function setMontoAttribute($value)
    {
        $this->attributes['monto'] = intval($value); // Entero

    }
    // Mutador para asegurar que el monto esté en el formato correcto
    public function setMontoAhorradoAttribute($value)
    {

        $this->attributes['monto_ahorrado'] = intval($value); // Entero
    }
    // Atributo calculado para el progreso de la meta
    public function getProgresoAttribute()
    {
        return $this->monto > 0 ? ($this->monto_ahorrado / $this->monto) * 100 : 0;
    }

// Reutilizar lógica con scopes
    public function scopeCompletadas($query)
    {
        return $query->whereColumn('monto_ahorrado', '>=', 'monto');
    }

    public function scopePendientes($query)
    {
        return $query->whereColumn('monto_ahorrado', '<', 'monto');
    }

}
