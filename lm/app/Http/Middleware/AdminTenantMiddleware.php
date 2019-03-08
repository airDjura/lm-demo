<?php

namespace App\Http\Middleware;

use airDjura\Landlord\Facades\Landlord;
use App\Models\Client\Season;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminTenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $client = auth()->user()->client;
        $environment = app()->make(\Hyn\Tenancy\Environment::class);


        // Now switch the environment to a new tenant.
        $environment->tenant($client);

        // set database config for DB Facade

        Config::set('database.default', 'tenant');

        //fix enum bug on table column change
        // $platform = Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
        //
        // $platform->registerDoctrineTypeMapping('enum', 'string');

        $user = Auth::user();
        if(!$user->editSeason) {
            $user->editSeason = Season::first()->id;
            $user->save();
        }

        // Landlord::addTenant('season_id', Auth::user()->editSeason);


        return $next($request);
    }
}
