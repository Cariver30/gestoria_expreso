<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioEntidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('usuario_sedes')->insert([
            ['usuario_id' => 1, 'sede_id' => 1, 'created_at' => now()]
        ]);
    }
}
