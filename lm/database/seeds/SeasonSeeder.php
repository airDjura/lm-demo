<?php

    use Illuminate\Database\Seeder;

    class SeasonSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run() {
            \App\Models\Client\Season::create([
                                           'name' => '2018/19',
                                       ]);
        }
    }
