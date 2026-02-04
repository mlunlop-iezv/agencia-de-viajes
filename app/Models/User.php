<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    function reservas(): HasMany {
        return $this->hasMany('App\Models\Reserva', 'iduser');
    }

    function comentarios(): HasMany {
        return $this->hasMany('App\Models\Comentario', 'iduser');
    }

    function isRol($rol): bool {
        return $this->rol == $rol;
    }

    function isAdmin(): bool {
        return $this->isRol('admin');
    }

    function isAdvanced(): bool {
        return $this->isRol('advanced');
    }

    function isUser(): bool {
        return $this->isRol('user');
    }

    // Verificar si tiene reserva en una vacación específica
    function tieneReserva($idvacacion): bool {
        return $this->reservas()->where('idvacacion', $idvacacion)->exists();
    }
}