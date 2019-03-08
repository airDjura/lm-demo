<?php

    use Illuminate\Database\Seeder;

    class RoleSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run() {
            $items = [
                [
                    'name' => 'Administrator',
                    'code' => 'admin',
                ],
                [
                    'name' => 'Member',
                    'code' => 'member',
                ],
            ];

            foreach ($items as $item) {
                \App\Models\Role::create($item);
            }
        }
    }
