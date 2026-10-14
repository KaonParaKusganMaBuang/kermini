<?php

namespace Database\Factories;

use App\Models\Part;
use App\Models\RepairJob;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Part>
 */
class PartFactory extends Factory
{
    public function definition(): array
    {
        return [
            'repair_job_id' => RepairJob::factory(),
            'name' => fake()->randomElement(['Oil filter', 'Brake pads', 'Spark plugs', 'Air filter', 'Serpentine belt']),
            'part_number' => fake()->bothify('PT-####'),
            'quantity' => fake()->numberBetween(1, 4),
            'unit_price' => fake()->randomFloat(2, 8, 250),
        ];
    }
}
