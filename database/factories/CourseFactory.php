<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $subjects = [
            'Matemáticas', 'Ciencias', 'Inglés', 'Historia', 'Geografía',
            'Física', 'Química', 'Biología', 'Literatura', 'Arte',
            'Música', 'Educación Física', 'Informática', 'Español',
            'Francés', 'Estudios Sociales', 'Economía', 'Filosofía'
        ];

        $gradeLevels = [
            '1.º Grado', '2.º Grado', '3.º Grado', '4.º Grado', '5.º Grado',
            '6.º Grado', '7.º Grado', '8.º Grado', '9.º Grado', '10.º Grado',
            '11.º Grado', '12.º Grado'
        ];

        $subject = fake()->randomElement($subjects);
       
        return [
            'name' => $subject,
            'code' => strtoupper(substr($subject, 0, 3)) . fake()->unique()->numberBetween(100, 999),
            'description' => fake()->paragraph(3),
            'grade_level' => fake()->randomElement($gradeLevels),
            'active' => true,
        ];
    }

    /**
     * Indicate that the course is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    /**
     * Indicate that the course is for a specific grade level.
     */
    public function forGradeLevel(string $gradeLevel): static
    {
        return $this->state(fn (array $attributes) => [
            'grade_level' => $gradeLevel,
        ]);
    }

    /**
     * Indicate that the course has no description.
     */
    public function withoutDescription(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => null,
        ]);
    }
    
}
