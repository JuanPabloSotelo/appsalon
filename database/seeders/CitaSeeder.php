<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitaSeeder extends Seeder
{
    /**
     * Cita de ejemplo del cliente de prueba con dos servicios.
     */
    public function run(): void
    {
        $clienteId  = DB::table('usuarios')->where('email', 'cliente@appsalon.com')->value('id');
        $servicios  = DB::table('servicios')->whereIn('id', [1, 7])->get(); // corte mujer + manicure

        $citaId = DB::table('citas')->insertGetId([
            'fecha'      => now()->addDays(3)->toDateString(),
            'hora'       => '10:00:00',
            'usuarioId'  => $clienteId,
            'total'      => $servicios->sum('precio'),
            'estado'     => 'pendiente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($servicios as $servicio) {
            DB::table('citasServicios')->insert([
                'citaId'     => $citaId,
                'servicioId' => $servicio->id,
            ]);
        }
    }
}