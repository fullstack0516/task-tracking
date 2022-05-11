<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Team;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::all()->each(function ($team) {
            Client::factory()->create([
                'team_id' => $team->id,
            ]);
        });
    }
}
