<?php

namespace Database\Seeders;

use App\Models\User;
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

        // Attention : Il faut que les références soient cohérentes
        $this->call([
            UserSeeder::class,
            TripSeeder::class, // Doit créer stops + proposals
        ]);
    }
}
