<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GestoriaSubServiciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('gestoria_sub_servicios')->insert([
            ['nombre' => 'Identificación', 'costo' => 50, 'gestoria_servicio_id' => 1, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Identificación REAL ID', 'costo' => 80, 'gestoria_servicio_id' => 1, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Título Removible (Certificado por médico)', 'costo' => 30, 'gestoria_servicio_id' => 2, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cat. 3 & 4 (Sin vencer, antes o menos de 30 días vencidas)', 'costo' => 120, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cat. 3 & 4 (Sin vencer, antes o menos de 30 días vencidas) REAL ID', 'costo' => 140, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => '(Más de 30 días de vencida, pero menos de 3 años)', 'costo' => 140, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => '(Más de 30 días de vencida, pero menos de 3 años) REAL ID', 'costo' => 160, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Charla de alcohol y drogas', 'costo' => 20, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cambio de Licencia Extranjera (Reciprocidad)', 'costo' => 120, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cambio de Licencia Extranjera (Reciprocidad) REAL ID', 'costo' => 140, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Sustitución de REAL ID', 'costo' => 70, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Duplicado de Licencia', 'costo' => 80, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Duplicado de Licencia REAL ID', 'costo' => 100, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Récord Choferil', 'costo' => 30, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            
            
            // ['nombre' => 'Nuevo (18 ó más)', 'costo' => 120, 'costo_real' => 140, 'gestoria_servicio_id' => 4, 'estatus_id' => 1, 'created_at' => now()],
            // ['nombre' => 'Nuevo (16/17 años)', 'costo' => 140, 'costo_real' => 0, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            // ['nombre' => 'Aprendizaje (Subir categoría)', 'costo' => 170, 'costo_real' => 190, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()]
        ]);
    }
}
