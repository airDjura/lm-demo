<?php

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Artisan;

    class DatabaseSeeder extends Seeder {
        protected $updatableModels = [
            'App\Models\Client\Club',
            'App\Models\Player',
        ];

        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run() {
            Artisan::call('passport:install');
            $this->updateVueAdminPanelEnv();

            $this->call(ClientSeeder::class);
            $this->call(RoleSeeder::class);

        }

        public function updateSearchableModels() {
            foreach ($this->updatableModels as $modelClass) {
                Artisan::call('scout:import', [
                    'model' => $modelClass,
                ]);
            }
        }

        public function  updateVueAdminPanelEnv () {
            $data = file('../vue-admin-panel/.env.local'); // reads an array of lines
            if ($data) {
                function replace_a_line($data) {
                    if (stristr($data, 'VUE_APP_CLIENT_SECRET')) {
                        $clientCode = DB::table('oauth_clients')->where('password_client', 1)->first()->secret;
                        return "VUE_APP_CLIENT_SECRET=" . $clientCode . "\n";
                    }
                    return $data;
                }
                $data = array_map('replace_a_line',$data);
                file_put_contents('../vue-admin-panel/.env.local', implode('', $data));
            }
        }
    }
