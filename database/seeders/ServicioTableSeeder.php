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
            ['nombre' => 'Inspección de Vehículos', 'costo' => 100, 'created_at' => now()],
            ['nombre' => 'Venta de Marbetes', 'costo' => 100, 'created_at' => now()],
            ['nombre' => 'Impresión de Licencias', 'costo' => 100, 'created_at' => now()],
            ['nombre' => 'Notificaciones', 'costo' => 100, 'created_at' => now()],
            ['nombre' => 'Costo por servicio', 'costo' => 100, 'created_at' => now()],
            ['nombre' => 'Certificación de Venta o Multa', 'costo' => 100, 'created_at' => now()],
            ['nombre' => 'Seguro', 'costo' => 100, 'created_at' => now()],
            ['nombre' => 'Extras', 'costo' => 100, 'created_at' => now()],
            ['nombre' => 'Multas de Ley', 'costo' => 100, 'created_at' => now()]
        ]);
    }
}
