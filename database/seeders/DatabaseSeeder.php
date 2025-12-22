<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Les données sont insérées en base dès que create() ou save() sont appellées dans les seeders !
        $this->call([
            UserSeeder::class,
            VehicleSeeder::class,
            TripSeeder::class,
            StopSeeder::class,
            ProposalSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
