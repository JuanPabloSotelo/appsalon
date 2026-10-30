<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Usuario del sistema (cliente o administrador).
 * Tabla: usuarios
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    /**
     * Campos que se pueden llenar desde un formulario.
     * 'admin' y 'confirmado' NO están aquí a propósito: así nadie puede
     * volverse administrador enviando un campo extra en el registro.
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'token',
    ];

    /** Campos que nunca se muestran al convertir el modelo a array/JSON. */
    protected $hidden = [
        'password',
        'token',
    ];

    protected function casts(): array
    {
        return [
            'password'   => 'hashed',   // cifra automáticamente con bcrypt al guardar
            'admin'      => 'boolean',
            'confirmado' => 'boolean',
        ];
    }

    /**
     * La tabla usuarios no tiene columna remember_token,
     * así que se desactiva la función "recordarme" de Laravel.
     */
    public function getRememberTokenName()
    {
        return '';
    }

    /** Un usuario tiene muchas citas. */
    public function citas(): HasMany
    {
        return $this->hasMany(Appointment::class, 'usuarioId');
    }

    /** Indica si el usuario es administrador. */
    public function esAdmin(): bool
    {
        return (bool) $this->admin;
    }

    /** Nombre completo para mostrar en las vistas. */
    public function nombreCompleto(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}