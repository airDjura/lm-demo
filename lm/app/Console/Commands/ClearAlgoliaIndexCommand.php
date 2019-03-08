<?php

    namespace App\Console\Commands;

    use airDjura\Landlord\Facades\Landlord;
    use Illuminate\Console\Command;
    use AlgoliaSearch\Client;

    class ClearAlgoliaIndexCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'scout:clear {model}';
        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Clear all data in search index, regardless of database';
        /**
         * Execute the console command.
         *
         * @return void
         */
        public function handle()
        {
            $clients = [1,2];
            $class = $this->argument('model');
            $model = new $class;
            $algolia = new Client(config('scout.algolia.id'), config('scout.algolia.secret'));
            foreach ($clients as $client) {
                Landlord::addTenant('client_id', $client);
                $index = $algolia->initIndex($model->searchableAs());
                // Remember this is an asynchronous operation in Algolia
                $index->clearIndex();
                $this->info('Index '.$model->searchableAs().' clearing.');
            }

        }
    }
