<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Cita reservada por un cliente.
 * Tabla: citas
 */
class Appointment extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'fecha',
        'hora',
        'usuarioId',
        'total',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'total' => 'decimal:2',
        ];
    }

    /** La cita pertenece a un usuario. */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuarioId');
    }

    /** La cita incluye uno o varios servicios (relación muchos a muchos). */
    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'citasServicios', 'citaId', 'servicioId');
    }
}