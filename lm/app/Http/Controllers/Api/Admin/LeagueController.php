<?php

    namespace App\Http\Controllers\Api\Admin;

    use App\Http\Requests\Api\Admin\League\LeagueStoreRequest;
    use App\Http\Requests\Api\Admin\League\LeagueUpdateRequest;
    use App\Http\Requests\Api\Admin\League\SeasonStoreRequest;
    use App\Http\Requests\Api\Admin\League\SeasonUpdateRequest;
    use App\Http\Resources\Api\Admin\League\LeagueIndexResource;
    use App\Http\Resources\Api\Admin\League\LeagueShowResource;
    use App\Models\Client\League;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class LeagueController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request) {
            $q = $request->get('search');
            $search = $q ?? '';

            return LeagueIndexResource::collection(League::search($search)
                                                         ->take(20)
                                                         ->get());
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(LeagueStoreRequest $request) {
            $data = $request->all();

            League::create($data);

            return response('league.created', 200);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show($leagueUuid) {
            $league = League::getByUuid($leagueUuid);

            if(!is_object($league)) {
                return response('league.notExists', 404);
            }

            return new LeagueShowResource($league);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(LeagueUpdateRequest $request, $leagueUuid) {
            $league = League::getByUuid($leagueUuid);

            if(!is_object($league)) {
                return response('league.notExists', 404);
            }

            $data = $request->all();

            $league->update($data);

            return response('league.updated', 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(League $league) {
            $league->delete();

            return response('league.deleted', 200);
        }
    }
