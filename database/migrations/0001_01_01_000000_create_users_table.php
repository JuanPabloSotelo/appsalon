<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de usuarios del sistema AppSalon.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60);
            $table->string('apellido', 60);
            $table->string('email', 100)->unique();
            $table->string('password', 60);              // hash bcrypt (60 caracteres)
            $table->string('telefono', 10)->nullable();
            $table->boolean('admin')->default(false);    // 1 = administrador
            $table->boolean('confirmado')->default(false);
            $table->string('token', 15)->nullable();     // token de confirmación de cuenta
            $table->timestamps();                        // created_at y updated_at
        });

        // Tablas internas de Laravel (recuperación de contraseña y sesiones)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('usuarios');
    }
};