<?php

    namespace App\Http\Controllers\Api\Admin;

    use App\Http\Requests\Api\Admin\Season\SeasonStoreRequest;
    use App\Http\Requests\Api\Admin\Season\SeasonUpdateRequest;
    use App\Http\Resources\Api\Admin\Season\SeasonIndexResource;
    use App\Http\Resources\Api\Admin\Season\SeasonShowResource;
    use App\Models\Client\Season;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class SeasonController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request) {
            $q = $request->get('search');
            $search = $q ?? '';

            return SeasonIndexResource::collection(Season::search($search)
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
        public function store(SeasonStoreRequest $request) {
            $data = $request->all();

            $season = Season::create($data);

            $user = auth()->user();

            if ($user->editSeason == null) {
                $user->editSeason = $season->id;
                $user->save();
            }

            return response('season.created', 200);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Season $season) {
            if (!is_object($season)) {
                return response('Season not found', 404);
            }

            return new SeasonShowResource($season);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(SeasonUpdateRequest $request, $seasonUuid) {
            $data = $request->all();

            $season = Season::getByUuid($seasonUuid);

            if (!is_object($season)) {
                return response('Season not found', 404);
            }

            $season->update($data);

            return response('season.updated', 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Season $season) {
            if (!is_object($season)) {
                return response('Season not found', 404);
            }

            $season->delete();

            return response('season.deleted', 200);
        }
    }
