<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('sedes')->insert([
            ['nombre' => 'Todas', 'acceso_panel' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Inspección Vb', 'acceso_panel' => 1, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Gestoría Ciales', 'acceso_panel' => 2, 'estatus_id' => 1, 'created_at' => now()]
        ]);
    }
}