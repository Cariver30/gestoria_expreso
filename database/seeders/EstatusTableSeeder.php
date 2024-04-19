<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('estatus')->insert([
            ['nombre' => "Activo"],
            ['nombre' => "Inactivo"],
            ['nombre' => "En curso"],
            ['nombre' => "Finalizado"],
            ['nombre' => "Pendiente"],
            ['nombre' => "Cancelado"]
        ]);
    }
}
