<?php

namespace Database\Factories;

use App\Models\Mechanic;
use App\Models\RepairJob;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RepairJob>
 */
class RepairJobFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'in_progress', 'completed']);
        $openedAt = fake()->dateTimeBetween('-3 months', 'now');

        return [
            'vehicle_id' => Vehicle::factory(),
            'mechanic_id' => Mechanic::factory(),
            'description' => fake()->sentence(),
            'status' => $status,
            'labor_cost' => fake()->randomFloat(2, 50, 900),
            'opened_at' => $openedAt->format('Y-m-d'),
            'completed_at' => $status === 'completed' ? fake()->dateTimeBetween($openedAt, 'now')->format('Y-m-d') : null,
        ];
    }
}
