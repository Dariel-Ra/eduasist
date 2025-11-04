<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicYear>
 */
class AcademicYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = fake()->numberBetween(2020, 2025);
        $endYear = $startYear + 1;
        
        $startDate = fake()->dateTimeBetween("{$startYear}-08-01", "{$startYear}-09-30");
        $endDate = fake()->dateTimeBetween("{$endYear}-05-01", "{$endYear}-07-31");

        return [
            'name' => "{$startYear}-{$endYear}",
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_current' => false,
        ];
    }

    /**
     * Indicate that this is the current academic year.
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_current' => true,
        ]);
    }

    /**
     * Indicate that this academic year is active (ongoing).
     */
    public function active(): static
    {
        $now = now();
        
        return $this->state(fn (array $attributes) => [
            'start_date' => $now->copy()->subMonths(3),
            'end_date' => $now->copy()->addMonths(6),
        ]);
    }

    /**
     * Indicate that this academic year has ended.
     */
    public function ended(): static
    {
        $year = now()->year - 1;
        
        return $this->state(fn (array $attributes) => [
            'start_date' => "{$year}-08-01",
            'end_date' => now()->copy()->subMonths(6),
        ]);
    }

    /**
     * Indicate that this academic year hasn't started yet.
     */
    public function pending(): static
    {
        $year = now()->year + 1;
        
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->copy()->addMonths(3),
            'end_date' => "{$year}-07-31",
        ]);
    }

}
