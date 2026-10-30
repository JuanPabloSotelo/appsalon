<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Registro de la tabla intermedia entre citas y servicios.
 * Tabla: citasServicios
 */
class AppointmentService extends Model
{
    protected $table = 'citasServicios';

    /** La tabla intermedia no tiene created_at / updated_at. */
    public $timestamps = false;

    protected $fillable = [
        'citaId',
        'servicioId',
    ];

    public function cita(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'citaId');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'servicioId');
    }
}