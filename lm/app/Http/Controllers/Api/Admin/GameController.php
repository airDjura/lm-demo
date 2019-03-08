<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Resources\Api\Admin\Schedule\Game\GameShowResource;
use App\Models\Client\Game;
use App\Models\Client\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($scheduleUuid, $gameUuid)
    {

        $schedule = Schedule::getByUuid($scheduleUuid);

        if(!is_object($schedule)) {
            return response('schedule.notExists', 404);
        }

        $game = Game::getByUuid($gameUuid);

        if(!is_object($game)) {
            return response('game.notExists', 404);
        }

        return new GameShowResource($game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($scheduleUuid, $gameUuid)
    {

        $schedule = Schedule::getByUuid($scheduleUuid);

        if(!is_object($schedule)) {
            return response('schedule.notExists', 404);
        }

        $game = Game::getByUuid($gameUuid);

        if(!is_object($game)) {
            return response('game.notExists', 404);
        }

        $game->delete();

        return response('Game deleted', 200);
    }
}
