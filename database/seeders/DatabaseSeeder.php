<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CustomersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            EstatusTableSeeder::class,
            RolTableSeeder::class,
            EntidadTableSeeder::class,
            UsuarioTableSeeder::class,
            ServicioTableSeeder::class,
            SeguroTableSeeder::class,
            MesTableSeeder::class,
            UsuarioEntidadTableSeeder::class,
            GestoriaTableSeeder::class,
            GestoriaServiciosTableSeeder::class,
            GestoriaSubServiciosTableSeeder::class
        ]);
    }
}
