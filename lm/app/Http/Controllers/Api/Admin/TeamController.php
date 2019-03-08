<?php

    namespace App\Http\Controllers\Api\Admin;

    use App\Http\Requests\Api\Admin\Schedule\Team\ChangeGroupRequest;
    use App\Http\Requests\Api\Admin\Schedule\Team\TeamStoreRequest;
    use App\Http\Requests\Api\Admin\Schedule\Team\TeamUpdateRequest;
    use App\Http\Resources\Api\Admin\Club\ClubPlayersResource;
    use App\Http\Resources\Api\Admin\Schedule\Team\TeamCreateResouce;
    use App\Http\Resources\Api\Admin\Schedule\Team\TeamShowResource;
    use App\Models\Client\Club;
    use App\Models\Client\Group;
    use App\Models\Client\Player;
    use App\Models\Client\Schedule;
    use App\Models\Client\Team;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class TeamController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            //
        }

        public function create($scheduleUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);
            return new TeamCreateResouce($schedule);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(TeamStoreRequest $request, $scheduleUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);
            $data = $request->all();

            $data['club_id'] = fromArrayWithUuidToId(Club::class, $data['club']);
            $data['schedule_id'] = $schedule->id;
            if (array_key_exists('group', $data) && $data['group']['uuid']) {
                $data['group_id'] = fromArrayWithUuidToId(Group::class, $data['group']);
            }
            else {
                $data['group_id'] = $schedule->groups()
                                             ->first()->id;
            }

            $team = Team::create($data);

            $this->updateRelationships($team, $data);

            return response('team.added', 200);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show($scheduleUuid, $teamUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $team = Team::getByUuid($teamUuid);

            if(!is_object($team)) {
                return response('team.notExists', 404);
            }

            return new TeamShowResource($team);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(TeamUpdateRequest $request, $scheduleUuid, $teamUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $team = Team::getByUuid($teamUuid);

            if(!is_object($team)) {
                return response('team.notExists', 404);
            }

            $data = $request->all();

            $data['club_id'] = fromArrayWithUuidToId(Club::class, $data['club']);
            $data['schedule_id'] = $schedule->id;

            if (array_key_exists('group', $data) && $data['group']['uuid']) {
                $data['group_id'] = fromArrayWithUuidToId(Group::class, $data['group']);
            }

            $team->update($data);

            $this->updateRelationships($team, $data);

            return response('team.updated', 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy($scheduleUuid, $teamUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $team = Team::getByUuid($teamUuid);

            if(!is_object($team)) {
                return response('team.notExists', 404);
            }

            $team->players()->sync([]);
            $team->delete();

            return response('team.deleted', 200);
        }

        public function updateRelationships($item, $data) {
            $playersForSync = convertForSync(Player::class, $data['players']);

            $item->players()
                 ->sync($playersForSync);
        }

        public function getPlayers($scheduleUuid, $clubUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $club = Club::getByUuid($clubUuid);

            if(!is_object($club)) {
                return response('club.notExists', 404);
            }

            return ClubPlayersResource::collection($club->players()
                                                        ->whereDoesntHave('teams', function($q) use ($schedule) {
                                                            $q->where('schedule_id', $schedule->id);
                                                        })
                                                        ->orderBy('lastName')
                                                        ->get());
        }

        public function getEditPlayers($scheduleUuid, $teamUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $team = Team::getByUuid($teamUuid);

            if(!is_object($team)) {
                return response('team.notExists', 404);
            }

            return ClubPlayersResource::collection($team->club->players()
                                                              ->whereDoesntHave('teams', function($q) use ($schedule, $team) {
                                                                  $q->where('schedule_id', $schedule->id)
                                                                    ->where('uuid', '!=', $team->uuid);
                                                              })
                                                              ->orderBy('lastName')
                                                              ->get());
        }

        public function changeGroup(ChangeGroupRequest $request, $scheduleUuid, $teamUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $team = Team::getByUuid($teamUuid);

            if(!is_object($team)) {
                return response('team.notExists', 404);
            }

            if ($team->group->uuid != $request->group['uuid']) {
                $team->gamesAsAway()->delete();
                $team->gamesAsHome()->delete();
            }

            $team->update([
                              'group_id' => Group::getByUuid($request->group['uuid'])->id,
                          ]);

            return response('team.group.changed', 200);
        }
    }
