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
            ['nombre' => 'Identificación', 'costo' => 50.00, 'gestoria_servicio_id' => 1, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Identificación REAL ID', 'costo' => 80.00, 'gestoria_servicio_id' => 1, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Título Removible (Certificado por médico)', 'costo' => 30.00, 'gestoria_servicio_id' => 2, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cat. 3 & 4 (Sin vencer, antes o menos de 30 días vencidas)', 'costo' => 120.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cat. 3 & 4 (Sin vencer, antes o menos de 30 días vencidas) REAL ID', 'costo' => 140.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => '(Más de 30 días de vencida, pero menos de 3 años)', 'costo' => 140.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => '(Más de 30 días de vencida, pero menos de 3 años) REAL ID', 'costo' => 160.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Charla de alcohol y drogas', 'costo' => 20.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cambio de Licencia Extranjera (Reciprocidad)', 'costo' => 120.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cambio de Licencia Extranjera (Reciprocidad) REAL ID', 'costo' => 140.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Sustitución de REAL ID', 'costo' => 70.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Duplicado de Licencia', 'costo' => 80.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Duplicado de Licencia REAL ID', 'costo' => 100.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Récord Choferil', 'costo' => 30.00, 'gestoria_servicio_id' => 3, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Nuevo (18 ó más)', 'costo' => 120.00, 'gestoria_servicio_id' => 4, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Nuevo (18 ó más) REAL ID', 'costo' => 140.00, 'gestoria_servicio_id' => 4, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Nuevo (16/17 años)', 'costo' => 140.00, 'gestoria_servicio_id' => 4, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Nuevo (16/17 años) REAL ID', 'costo' => 0.00, 'gestoria_servicio_id' => 4, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Aprendizaje (Subir categoría)', 'costo' => 150.00, 'gestoria_servicio_id' => 4, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Aprendizaje (Subir categoría) REAL ID', 'costo' => 170.00, 'gestoria_servicio_id' => 4, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Exámen', 'costo' => 150.00, 'gestoria_servicio_id' => 5, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Exámen REAL ID', 'costo' => 150.00, 'gestoria_servicio_id' => 5, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Re-Exámen', 'costo' => 75.00, 'gestoria_servicio_id' => 5, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Práctica', 'costo' => 30.00, 'gestoria_servicio_id' => 5, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cambio de Dirección', 'costo' => 40.00, 'gestoria_servicio_id' => 6, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Ya juramentado (Sólo completar en CESCO) con sellos', 'costo' => 30.00, 'gestoria_servicio_id' => 7, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Ya juramentado (Sólo completar en CESCO) sin sellos', 'costo' => 60.00, 'gestoria_servicio_id' => 7, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Ambas personas firman en oficina en el título', 'costo' => 100.00, 'gestoria_servicio_id' => 7, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Traspaso con ID no Presencial', 'costo' => 130.00, 'gestoria_servicio_id' => 8, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Duplicado de Título, Licencia, Tablilla o Marbete', 'costo' => 80.00, 'gestoria_servicio_id' => 8, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Traspaso Ex Parte (Venta condicional sin título)', 'costo' => 250.00, 'gestoria_servicio_id' => 8, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'De ser vendedor o comprador una corporación (adicional)', 'costo' => 20.00, 'gestoria_servicio_id' => 8, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Gravamen de Litigio', 'costo' => 100.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Gravamen de Chatarra, Hipoteca y Venta Condicional (Todo)', 'costo' => 40.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Gravamen de Chatarra, Hipoteca y Venta Condicional (Duplicado)', 'costo' => 100.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cambio de Tablilla Deterioro', 'costo' => 40.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cambio de Tablilla Deterioro (Europea)', 'costo' => 90.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Cambio de Color, Millaje, Peso, Etc.', 'costo' => 50.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Certificación No Multa y Registro (cada una)', 'costo' => 30.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Reporte de Multa o Informe de Vehículo', 'costo' => 10.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Tablilla Retenida', 'costo' => 50.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Asignar Título', 'costo' => 50.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Poner Gravamen Pentágono', 'costo' => 40.00, 'gestoria_servicio_id' => 9, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Privados', 'costo' => 430.00, 'gestoria_servicio_id' => 10, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Carga', 'costo' => 530.00, 'gestoria_servicio_id' => 10, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Motoras', 'costo' => 480.00, 'gestoria_servicio_id' => 10, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'H', 'costo' => 630.00, 'gestoria_servicio_id' => 10, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Dueños Registral', 'costo' => 20.00, 'gestoria_servicio_id' => 11, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Con ID del dueño Registral', 'costo' => 20.00, 'gestoria_servicio_id' => 11, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Sin Identificación', 'costo' => 40.00, 'gestoria_servicio_id' => 11, 'estatus_id' => 1, 'created_at' => now()],
            ['nombre' => 'Con gravamen (Difunto, Hipoteca)', 'costo' => 60.00, 'gestoria_servicio_id' => 11, 'estatus_id' => 1, 'created_at' => now()],
        ]);
    }
}
