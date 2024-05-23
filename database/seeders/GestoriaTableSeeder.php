<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GestoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('gestorias')->insert([
            ['nombre' => 'Transacción', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Licencias', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Vehículos', 'estatus_id' => 1, 'created_at' => now()]
        ]);
    }
}
