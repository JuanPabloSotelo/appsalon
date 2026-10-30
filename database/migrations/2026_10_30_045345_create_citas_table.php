<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Citas reservadas por los clientes.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            // FK a usuarios: si se borra el usuario, la cita queda con usuarioId = NULL
            $table->foreignId('usuarioId')->nullable()
                  ->constrained('usuarios')->nullOnDelete();
            $table->decimal('total', 10, 2)->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'completada', 'cancelada'])
                  ->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};