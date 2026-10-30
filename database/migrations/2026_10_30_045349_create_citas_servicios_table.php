<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla intermedia: qué servicios incluye cada cita (relación muchos a muchos).
     */
    public function up(): void
    {
        Schema::create('citasServicios', function (Blueprint $table) {
            $table->id();
            // Si se borra la cita o el servicio, se borra el registro intermedio
            $table->foreignId('citaId')->constrained('citas')->cascadeOnDelete();
            $table->foreignId('servicioId')->constrained('servicios')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citasServicios');
    }
};