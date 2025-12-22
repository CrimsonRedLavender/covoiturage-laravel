<?php

namespace Database\Seeders;

use App\Models\Proposal;
use App\Models\Stop;
use App\Models\Trip;
use App\Models\User;
use Faker\Core\DateTime;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trip::factory(80)->create(); //create() insert dans la db immédiatement. Pas le cas avec make() mais il faut save() après
    }
}
