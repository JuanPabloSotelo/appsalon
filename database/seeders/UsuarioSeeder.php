<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Usuarios de prueba: un administrador y un cliente.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'nombre'     => 'Admin',
                'apellido'   => 'AppSalon',
                'email'      => 'admin@appsalon.com',
                'password'   => Hash::make('admin123'),   // contraseña cifrada con bcrypt
                'telefono'   => '3001234567',
                'admin'      => 1,
                'confirmado' => 1,
                'token'      => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Cliente',
                'apellido'   => 'Prueba',
                'email'      => 'cliente@appsalon.com',
                'password'   => Hash::make('cliente123'),
                'telefono'   => '3109876543',
                'admin'      => 0,
                'confirmado' => 1,
                'token'      => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}