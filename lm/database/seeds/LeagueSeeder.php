<?php

    use Illuminate\Database\Seeder;

    class LeagueSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run() {

            foreach ([1,2,3] as $item) {
                \App\Models\Client\League::create([
                                               'name' => 'League ' . $item,
                                           ]);
            }
        }
    }
