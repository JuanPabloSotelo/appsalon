<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders en orden (primero usuarios y servicios, luego citas).
     */
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            ServicioSeeder::class,
            CitaSeeder::class,
        ]);
    }
}