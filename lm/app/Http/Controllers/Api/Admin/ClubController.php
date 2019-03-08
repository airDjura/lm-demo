<?php

    namespace App\Http\Controllers\Api\Admin;

    use App\Http\Requests\Api\Admin\Club\ClubStoreRequest;
    use App\Http\Requests\Api\Admin\Club\ClubUpdateRequest;
    use App\Http\Resources\Api\Admin\Club\ClubIndexResource;
    use App\Http\Resources\Api\Admin\Club\ClubPlayersResource;
    use App\Http\Resources\Api\Admin\Club\ClubShowResource;
    use App\Http\Resources\UniversalUuidResource;
    use App\Models\Client\Club;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class ClubController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request) {
            $q = $request->get('search');
            $search = $q ?? '';

            return UniversalUuidResource::collection(Club::search($search)
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
        public function store(ClubStoreRequest $request) {
            $data = $request->all();

            Club::create($data);

            return response('club.created', 200);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show($clubUuid) {
            $club = Club::getByUuid($clubUuid);

            if(!is_object($club)) {
                return response('club.notExists', 404);
            }

            return new ClubShowResource($club);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(ClubUpdateRequest $request, $clubUuid) {
            $club = Club::getByUuid($clubUuid);

            if(!is_object($club)) {
                return response('club.notExists', 404);
            }

            $data = $request->all();

            $club->update($data);

            return response('club.updated', 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy($clubUuid) {
            $club = Club::getByUuid($clubUuid);

            if(!is_object($club)) {
                return response('club.notExists', 404);
            }

            $club->delete();

            return response('club.deleted', 200);
        }

        public function getPlayers($clubUuid) {
            $club = Club::getByUuid($clubUuid);

            if(!is_object($club)) {
                return response('club.notExists', 404);
            }

            return ClubPlayersResource::collection($club->players()->orderBy('lastName')->get());
        }
    }
