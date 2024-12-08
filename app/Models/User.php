<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'country',
        'city',
        'role',
        'is_premium',
        'subscription_end_date',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscription_end_date' => 'datetime',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class);
    }

    public function egresos()
    {
        return $this->hasMany(Egreso::class);
    }

    public function metas()
    {
        return $this->hasMany(Meta::class);
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }
    public function hasActiveSubscription(): bool
    {
        return $this->is_premium && $this->subscription_end_date && $this->subscription_end_date->isFuture();
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

}
