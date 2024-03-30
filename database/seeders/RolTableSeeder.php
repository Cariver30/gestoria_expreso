<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('roles')->insert([
            ['nombre' => 'Administrador', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Supervisor', 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Operador', 'estatus_id' => 1, 'created_at' => now()]
        ]);
    }
}
