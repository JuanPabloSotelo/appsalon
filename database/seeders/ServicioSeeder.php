<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    /**
     * Catálogo inicial de servicios (precios en pesos colombianos).
     */
    public function run(): void
    {
        $servicios = [
            ['Corte de cabello mujer', 35000, 'Corte y secado', 45],
            ['Corte de cabello hombre', 25000, 'Corte clásico o moderno', 30],
            ['Corte de cabello niño', 18000, 'Corte para menores de 12 años', 30],
            ['Arreglo de barba', 15000, 'Perfilado y arreglo de barba', 20],
            ['Peinado', 40000, 'Peinado para eventos', 60],
            ['Tinte completo', 90000, 'Coloración de todo el cabello', 120],
            ['Manicure', 25000, 'Limpieza y esmaltado de uñas de manos', 45],
            ['Pedicure', 30000, 'Limpieza y esmaltado de uñas de pies', 60],
            ['Tratamiento capilar', 60000, 'Hidratación profunda', 60],
        ];

        foreach ($servicios as [$nombre, $precio, $descripcion, $duracion]) {
            DB::table('servicios')->insert([
                'nombre'      => $nombre,
                'precio'      => $precio,
                'descripcion' => $descripcion,
                'duracion'    => $duracion,
                'activo'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}