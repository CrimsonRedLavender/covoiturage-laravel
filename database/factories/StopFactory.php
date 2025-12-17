<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stop>
 */
class StopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "order" => fake()->numberBetween(1,5), // A ecraser dans le Seeder
            "departure_time" => fake()->dateTimeBetween('-1 year', '-1 week'),
            "arrival_time" => fake()->dateTimeBetween(),
            "address" => fake()->address(),
            "trip_id" => Trip::Factory(),
        ];
    }
}
