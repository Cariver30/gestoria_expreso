<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert([
            ['nombre' => 'Administrador', 'primer_apellido' => 'Principal', 'segundo_apellido' => null, 'dob'=>'2000-10-10' ,'email' => 'admin@admin.com', 'password' => '$2y$10$mnRM6j.t1ExJv/Lrg3wPmOuPhpIBJJdgm2XiugvU7fJqIrwNolHHe', 'pin'=> 'asdf', 'estatus_id' => 1,'email_verified_at'=> '2022-01-02 17:04:58', 'avatar' => 'images/avatar-1.jpg', 'rol_id' => 1,'created_at' => now()]
        ]);
    }
}
