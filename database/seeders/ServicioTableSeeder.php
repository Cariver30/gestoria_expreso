<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('servicios')->insert([
            ['nombre' => 'Inspección de Vehículos', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Venta de Marbetes', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Impresión de Licencias', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Notificaciones', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Costo por servicio', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Certificación de Venta o Multa', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Seguro', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Extras', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Multas de Ley', 'estatus_id' => 1, 'created_at' => now()]
        ]);
    }
}
