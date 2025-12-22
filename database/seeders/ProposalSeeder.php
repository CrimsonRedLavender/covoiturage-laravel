<?php

namespace Database\Seeders;

use App\Models\Proposal;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Charger tous les users avec leurs véhicules
        $users = User::with('vehicles')->get();

        $trips = Trip::all();

        foreach ($trips as $trip) {
            // Choisit au hasard un user avec au moins 1 vehicle
            $user = $users->filter(function ($user) {
                return $user->vehicles->count() > 0;
            })->random();

            // Récupérer le vehicle du user
            $vehicle = $user->vehicles->random();

            Proposal::factory()->create([
                'trip_id' => $trip->id,
                'user_id' => $user->id,
                'vehicle_id' => $vehicle->id,
            ]);

            $trip->available_seats = $vehicle->seats - 1;

            $trip->save(); // penser à save() après toute modification d'un model !
        }
    }
}
