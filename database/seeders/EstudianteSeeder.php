<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estudiante;

class EstudianteSeeder extends Seeder
{
    public function run()
    {
        Estudiante::create([
            'dni' => '12345678',
            'nombres' => 'Juan',
            'apellidos' => 'Pérez',
            'grado_seccion' => '5A',
        ]);

        Estudiante::create([
            'dni' => '87654321',
            'nombres' => 'María',
            'apellidos' => 'López',
            'grado_seccion' => '4B',
        ]);

        Estudiante::create([
            'dni' => '11223344',
            'nombres' => 'Carlos',
            'apellidos' => 'Ramírez',
            'grado_seccion' => '3C',
        ]);

        // Agrega más registros si es necesario
    }
}
