<?php

namespace Database\Factories;

use App\Models\Stop;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Stop>
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
        $departure = fake()->dateTimeBetween('-1 year', '-1 week');
        $arrival = fake()->dateTimeBetween($departure, '+1 week');

        return [
            "order" => fake()->numberBetween(1,5), // A ecraser dans le Seeder
            "departure_time" => $departure,
            "arrival_time" => $arrival,
            "address" => fake()->address(),
        ];
    }
}
