<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'make' => fake()->randomElement(['Toyota', 'Honda', 'Ford', 'Nissan', 'Mazda']),
            'model' => fake()->word(),
            'year' => fake()->numberBetween(2000, 2026),
            'license_plate' => fake()->unique()->bothify('???-####'),
            'vin' => fake()->unique()->regexify('[A-HJ-NPR-Z0-9]{17}'),
        ];
    }
}
