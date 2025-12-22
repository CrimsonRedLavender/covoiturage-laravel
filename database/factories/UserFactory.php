<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $email  = $firstName . '.' . $lastName . '@bestmeds.com';
        $email = strtolower($email);

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => static::$password ??= Hash::make('1234'), //Static property of the class and null coalescing
            'mobile' => fake()->phoneNumber(),
            'address' => fake()->address(),
        ];
    }
}
