<?php

    namespace App\Http\Controllers\Api\Admin;

    use App\Http\Resources\Api\Admin\AuthUserResource;
    use App\Models\Client\Season;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class UserController extends Controller {
        public function getAuthUser() {
            $user = auth()->user();
            return new AuthUserResource($user);
        }

        public function editSeason(Request $request) {
            $seasonId = Season::getByUuid($request->seasonUuid)->id;

            $user = auth()->user();
            $user->editSeason = $seasonId;
            $user->save();

            return new AuthUserResource($user);
        }
    }
