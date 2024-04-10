<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeguroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('sub_servicios')->insert([
            ['nombre' => 'Seguro Privado', 'estatus_id' => 1, 'servicio_id' => 7, 'created_at' => now()]
        ]);
    }
}
