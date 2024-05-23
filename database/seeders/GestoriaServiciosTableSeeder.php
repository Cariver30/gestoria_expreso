<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GestoriaServiciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('gestoria_servicios')->insert([
            ['nombre' => 'Identificación', 'gestoria_id' => 1, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Rotulo Removible', 'gestoria_id' => 1, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Renovación', 'gestoria_id' => 2, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Aprendizaje', 'gestoria_id' => 2, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Escuela de conducir', 'gestoria_id' => 2, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cambio de dirección', 'gestoria_id' => 2, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Traspasos', 'gestoria_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Con Venta Condicional', 'gestoria_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Gravámenes', 'gestoria_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Registros', 'gestoria_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Notificaciones', 'gestoria_id' => 3, 'estatus_id' => 1, 'created_at' => now()]
        ]);
    }
}
