<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Servicio ofrecido por el salón.
 * Tabla: servicios
 */
class Service extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'duracion',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'precio'   => 'decimal:2',
            'duracion' => 'integer',
            'activo'   => 'boolean',
        ];
    }

    /** Un servicio puede estar en muchas citas (a través de citasServicios). */
    public function citas(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class, 'citasServicios', 'servicioId', 'citaId');
    }

    /** Filtro reutilizable: solo servicios activos. Uso: Service::activos()->get() */
    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('activo', true);
    }
}