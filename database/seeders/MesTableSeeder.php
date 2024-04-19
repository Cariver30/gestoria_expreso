<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('mes')->insert([
            ['nombre' => 'Enero', 'created_at' => now()],
            ['nombre' => 'Febrero', 'created_at' => now()],
            ['nombre' => 'Marzo', 'created_at' => now()],
            ['nombre' => 'Abril', 'created_at' => now()],
            ['nombre' => 'Mayo', 'created_at' => now()],
            ['nombre' => 'Junio', 'created_at' => now()],
            ['nombre' => 'Julio', 'created_at' => now()],
            ['nombre' => 'Agosto', 'created_at' => now()],
            ['nombre' => 'Septiembre', 'created_at' => now()],
            ['nombre' => 'Octubre', 'created_at' => now()],
            ['nombre' => 'Noviembre', 'created_at' => now()],
            ['nombre' => 'Diciembre', 'created_at' => now()]
        ]);
    }
}
