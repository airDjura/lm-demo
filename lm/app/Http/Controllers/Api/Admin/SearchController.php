<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Resources\UniversalUuidResource;
use App\Models\Client\Club;
use App\Models\Client\League;
use App\Models\Client\Season;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function club(Request $request) {
        $q = $request->get('search');
        $search = $q ?? '';
        return UniversalUuidResource::collection(Club::search($search)->take(20)->get());
    }

    public function season(Request $request) {
        $q = $request->get('search');
        $search = $q ?? '';
        return UniversalUuidResource::collection(Season::search($search)->take(10)->get());
    }

    public function league(Request $request) {
        $q = $request->get('search');
        $search = $q ?? '';
        return UniversalUuidResource::collection(League::search($search)->take(10)->get());
    }
}
