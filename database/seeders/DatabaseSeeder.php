<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\Part;
use App\Models\RepairJob;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::factory(12)->create();
        $mechanics = Mechanic::factory(5)->create();

        $customers->each(function (Customer $customer): void {
            $customer->vehicles()->saveMany(Vehicle::factory(fake()->numberBetween(1, 2))->make());
        });

        Vehicle::all()->each(function (Vehicle $vehicle) use ($mechanics): void {
            $jobs = RepairJob::factory(fake()->numberBetween(1, 2))
                ->for($vehicle)
                ->for($mechanics->random())
                ->create();

            $jobs->each(function (RepairJob $job): void {
                Part::factory(fake()->numberBetween(1, 3))->for($job)->create();
            });
        });
    }
}
