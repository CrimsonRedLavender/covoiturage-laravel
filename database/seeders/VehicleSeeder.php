<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les users
        $users = User::all();

        foreach ($users as $user) {
            Vehicle::factory(rand(0,3))->for($user)->create();
            // The for() method allows you to specify a parent model when creating a factory instance
        }
    }
}

/*
Ce code ne choisit pas un id random pour chaque nouveau vehicle, il n'en choisit qu'un et l'utilise pour tous les vehicles !

Vehicle::factory(50)->create([
     'user_id' => $users->random()->id,
]);
 */
