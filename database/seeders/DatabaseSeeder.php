<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Oferta;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos un Tutor Académico
        $tutor = User::create([
            'name' => 'Profesor Tutor',
            'email' => 'tutor@instituto.es',
            'password' => Hash::make('password123'),
            'rol' => 'tutor_academico',
        ]);

        // 2. Creamos una Empresa
        $empresa = User::create([
            'name' => 'Tecnoambiente S.L.',
            'email' => 'rrhh@tecnoambiente.com',
            'password' => Hash::make('password123'),
            'rol' => 'empresa',
        ]);

        // 3. Creamos un Estudiante (Asignado al tutor)
        $estudiante = User::create([
            'name' => 'Badr Belayachi',
            'email' => 'badr@alumno.es',
            'password' => Hash::make('password123'),
            'rol' => 'estudiante',
            'grado' => '2º DAW',
            'tutor_id' => $tutor->id,
        ]);

        // 4. Generamos un par de Ofertas de prueba para la empresa
        Oferta::create([
            'user_id' => $empresa->id,
            'titulo' => 'Desarrollador Backend Laravel / PHP',
            'grado_requerido' => '2º DAW o DAM',
            'descripcion' => 'Buscamos un estudiante en prácticas para unirse a nuestro equipo de desarrollo backend. Trabajarás en la creación de APIs REST y refactorización de código con Laravel.',
            'vacantes' => 2,
            'estado' => true,
        ]);

        Oferta::create([
            'user_id' => $empresa->id,
            'titulo' => 'Frontend Junior (JavaScript, CSS, Bootstrap)',
            'grado_requerido' => '2º DAW',
            'descripcion' => 'Prácticas enfocadas en el diseño e implementación de interfaces limpias tipo SaaS. Necesaria experiencia con Bootstrap y JavaScript moderno.',
            'vacantes' => 1,
            'estado' => true,
        ]);
    }
}