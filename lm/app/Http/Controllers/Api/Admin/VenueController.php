<?php

    namespace App\Http\Controllers\Api\Admin;

    use App\Http\Requests\Api\Admin\Venue\VenueStoreRequest;
    use App\Http\Requests\Api\Admin\Venue\VenueUpdateRequest;
    use App\Http\Resources\Api\Admin\Venue\VenueIndexResource;
    use App\Http\Resources\Api\Admin\Venue\VenueShowResource;
    use App\Models\Client\Venue;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class VenueController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request) {
            $q = $request->get('search');
            $search = $q ?? '';

            return VenueIndexResource::collection(Venue::search($search)
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
        public function store(VenueStoreRequest $request) {
            $data = $request->all();

            Venue::create($data);

            return response('venue.created', 200);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show($venueUuid) {
            $venue = Venue::getByUuid($venueUuid);

            return new VenueShowResource($venue);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(VenueUpdateRequest $request, $venueUuid) {
            $data = $request->all();

            $venue = Venue::getByUuid($venueUuid);

            $venue->update($data);

            return response('venue.updated', 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy($venueUuid) {
            $venue = Venue::getByUuid($venueUuid);

            $venue->delete();

            return response('venue.deleted', 200);
        }
    }
