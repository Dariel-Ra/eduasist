<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\School;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );


        // Crear escuelas de ejemplo
        if (School::count() === 0) {
            School::create([
                'name' => 'Instituto Educativo San José',
                'code' => 'IESJ001',
                'address' => 'Calle Principal #123',
                'district' => 'Monseñor Nouel',
                'phone' => '809-555-0001',
                'email' => 'info@iesj.edu.do',
            ]);

            School::create([
                'name' => 'Colegio Nuestra Señora de la Paz',
                'code' => 'CNSP002',
                'address' => 'Avenida Central #456',
                'district' => 'Santiago',
                'phone' => '809-555-0002',
                'email' => 'contacto@cnsp.edu.do',
            ]);

            School::factory(8)->create();
        }

        // Crear años académicos
        if (AcademicYear::count() === 0) {
            // Año académico actual
            AcademicYear::create([
                'name' => '2024-2025',
                'start_date' => '2024-08-15',
                'end_date' => '2025-06-30',
                'is_current' => true,
            ]);

            // Año académico anterior
            AcademicYear::create([
                'name' => '2023-2024',
                'start_date' => '2023-08-15',
                'end_date' => '2024-06-30',
                'is_current' => false,
            ]);

            // Año académico siguiente
            AcademicYear::create([
                'name' => '2025-2026',
                'start_date' => '2025-08-15',
                'end_date' => '2026-06-30',
                'is_current' => false,
            ]);
        }

        // Crear cursos de ejemplo
        if (Course::count() === 0) {
            $courses = [
                [
                    'name' => 'Matemáticas',
                    'code' => 'MAT101',
                    'description' => 'Curso básico de matemáticas para primer grado',
                    'grade_level' => '1st Grade',
                ],
                [
                    'name' => 'Lengua Española',
                    'code' => 'LEN101',
                    'description' => 'Curso de lengua y literatura española',
                    'grade_level' => '1st Grade',
                ],
                [
                    'name' => 'Ciencias Naturales',
                    'code' => 'CNA101',
                    'description' => 'Introducción a las ciencias naturales',
                    'grade_level' => '1st Grade',
                ],
                [
                    'name' => 'Ciencias Sociales',
                    'code' => 'CSO101',
                    'description' => 'Estudios sociales y cívica',
                    'grade_level' => '1st Grade',
                ],
                [
                    'name' => 'Educación Física',
                    'code' => 'EDF101',
                    'description' => 'Desarrollo físico y deportivo',
                    'grade_level' => '1st Grade',
                ],
                [
                    'name' => 'Educación Artística',
                    'code' => 'ART101',
                    'description' => 'Expresión artística y creatividad',
                    'grade_level' => '1st Grade',
                ],
            ];

            foreach ($courses as $course) {
                Course::create($course);
            }

            // Crear más cursos aleatorios
            Course::factory(20)->create();
        }

    }
}
