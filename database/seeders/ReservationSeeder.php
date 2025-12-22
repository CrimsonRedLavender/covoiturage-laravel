<?php

namespace Database\Seeders;

use App\Models\Proposal;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proposals = Proposal::with(['user', 'trip'])->get();
        $users = User::all();

        foreach ($proposals as $proposal) {

            $trip = $proposal->trip;

            // Skip le proposal s'il n'y a plus de place disponible
            if($trip->available_seats < 1){
                continue;
            }

            // Enleve le model user qui a fait la proposal des passagers potentiels
            $candidates = $users->where('id', '!=', $proposal->user->id);

            $nbReservations = rand(0, $trip->available_seats);

            $passengers = $candidates->random($nbReservations);

            foreach ($passengers as $passenger) {
                Reservation::factory()->create([
                    'trip_id' => $proposal->trip->id,
                    'user_id' => $passenger->id,
                ]);
            }
        }
    }
}

// Ca ça ne marche pas car except() enleve un id et pas un model de la collection
// $candidates = $users->except($proposal->user->id);
