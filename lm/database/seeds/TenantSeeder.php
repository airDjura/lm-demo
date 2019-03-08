<?php

use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SeasonSeeder::class);
        $this->call(LeagueSeeder::class);
        $this->call(ClubSeeder::class);
        $this->call(VenueSeeder::class);
    }
}
