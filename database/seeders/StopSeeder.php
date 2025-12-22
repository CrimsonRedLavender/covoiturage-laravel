<?php

namespace Database\Seeders;

use App\Models\Stop;
use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Générer le nombre d'étapes (stops) des trajets (trips)


        $trips = Trip::all();

        foreach ($trips as $trip) {
            $nbStops = rand(1, 4);

            $departure = fake()->dateTimeBetween('-1 year', '-1 week');

            for ($i = 1; $i <= $nbStops; $i++) {

                $arrival = (clone $departure)->modify('+' . rand(15, 180) . ' minutes');

                Stop::factory()->create([
                    'trip_id' => $trip->id,
                    'order' => $i,
                    'departure_time' => $departure, //attention a bien avoir cloner quand ajoute du temps à departure ou arrival
                    'arrival_time' => $arrival,
                ]);

                $departure = (clone $arrival)->modify('+' . (rand(0, 3) * 15) . ' minutes');
            }
        }
    }
}
