<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialties = [
            'Mathematics',
            'Science',
            'English',
            'History',
            'Geography',
            'Physics',
            'Chemistry',
            'Biology',
            'Physical Education',
            'Arts',
            'Music',
            'Computer Science',
            'Spanish',
            'French',
        ];

        return [
            'user_id' => User::factory(),
            'employee_code' => strtoupper(fake()->unique()->bothify('TCH####??')),
            'specialty' => fake()->randomElement($specialties),
        ];
    }

    /**
     * Indicate that the teacher has a specific specialty.
     */
    public function withSpecialty(string $specialty): static
    {
        return $this->state(fn (array $attributes) => [
            'specialty' => $specialty,
        ]);
    }

    /**
     * Indicate that the teacher is associated with an existing user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
