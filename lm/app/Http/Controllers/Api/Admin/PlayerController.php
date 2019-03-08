<?php

    namespace App\Http\Controllers\Api\Admin;

    use App\Http\Requests\Api\Admin\Player\PlayerStoreRequest;
    use App\Http\Requests\Api\Admin\Player\PlayerUpdateRequest;
    use App\Http\Resources\Api\Admin\Player\PlayerShowResource;
    use App\Http\Resources\Api\Admin\PlayerIndexResource;
    use App\Models\Client\Club;
    use App\Models\Client\Player;
    use Carbon\Carbon;
    use airDjura\Landlord\Facades\Landlord;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class PlayerController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request) {
            $q = $request->get('search');
            $search = $q ?? '';

            return PlayerIndexResource::collection(Player::search($search)
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
        public function store(PlayerStoreRequest $request) {
            $data = $request->all();

            $data['club_id'] = fromArrayWithUuidToId(Club::class, $data['club']);

            Player::create($data);

            return response('player.created', 200);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show($playerUuid) {
            $player = Player::getByUuid($playerUuid);

            if(!is_object($player)) {
                return response('player.notExists', 404);
            }

            return new PlayerShowResource($player);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(PlayerUpdateRequest $request, $playerUuid) {
            $player = Player::getByUuid($playerUuid);

            if(!is_object($player)) {
                return response('player.notExists', 404);
            }

            $data = $request->all();

            $data['club_id'] = fromArrayWithUuidToId(Club::class, $data['club']);

            $player->update($data);

            return response('player.updated', 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy($playerUuid) {
            $player = Player::getByUuid($playerUuid);

            if(!is_object($player)) {
                return response('player.notExists', 404);
            }

            $player->delete();

            return response('player.deleted', 200);
        }
    }
