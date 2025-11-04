<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
    {
        $schoolTypes = ['Elementary', 'High', 'Middle', 'Primary', 'Secondary'];
        $schoolType = fake()->randomElement($schoolTypes);
        
        return [
            'name' => fake()->company() . ' ' . $schoolType . ' School',
            'code' => strtoupper(fake()->unique()->bothify('SCH###??')),
            'address' => fake()->streetAddress(),
            'district' => fake()->city(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }

    /**
     * Indicate that the school is in a specific district.
     */
    public function inDistrict(string $district): static
    {
        return $this->state(fn (array $attributes) => [
            'district' => $district,
        ]);
    }
}
