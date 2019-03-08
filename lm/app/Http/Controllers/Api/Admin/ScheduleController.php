<?php

    namespace App\Http\Controllers\Api\Admin;

    use App\Actions\Api\Admin\Schedule\ScheduleAct;
    use App\Http\Requests\Api\Admin\Schedule\Group\ScheduleGroupRequest;
    use App\Http\Requests\Api\Admin\Schedule\ScheduleGenerateRequest;
    use App\Http\Requests\Api\Admin\Schedule\ScheduleStoreRequest;
    use App\Http\Resources\Api\Admin\Schedule\ScheduleIndexResource;
    use App\Http\Resources\Api\Admin\Schedule\ScheduleShowResource;
    use App\Http\Resources\UniversalUuidResource;
    use App\Models\Client\Game;
    use App\Models\Client\Group;
    use App\Models\Client\League;
    use App\Models\Client\Schedule;
    use App\Http\Controllers\Controller;
    use App\Models\Client\Team;
    use Illuminate\Support\Facades\DB;

    class ScheduleController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            return ScheduleIndexResource::collection(Schedule::all());
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(ScheduleStoreRequest $request) {
            $data = $request->all();
            $data['league_id'] = fromArrayWithUuidToId(League::class, $data['league']);

            Schedule::create($data);

            return response('schedule.created', 200);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show($scheduleUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            return new ScheduleShowResource($schedule);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(ScheduleStoreRequest $request, $scheduleUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $data = $request->all();

            $schedule->update($data);

            return response('schedule.updated', 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy($scheduleUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $schedule->delete();

            return response('schedule.deleted', 200);
        }

        public function addGroup(ScheduleGroupRequest $request, $scheduleUuid) {

            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $lastGroupName = $schedule->groups()
                                      ->orderBy('id', 'desc')
                                      ->first()->name;

            $lastGroupName++;

            $group = new Group([
                                   'name' => $lastGroupName,
                               ]);
            $schedule->groups()
                     ->save($group);

            return response('group.added', 200);
        }

        public function deleteGroup($scheduleUuid, $groupUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $group = Group::getByUuid($groupUuid);

            if(!is_object($group)) {
                return response('group.notExists', 404);
            }

            $defaultGroup = $schedule->groups()
                                     ->where('name', 'A')
                                     ->first();
            $teams = Team::where('group_id', $group->id);

            $teams->update([
                               'group_id' => $defaultGroup->id,
                           ]);

            $group->delete();

            return response('group.deleted', 200);
        }

        public function getGroups($scheduleUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            return UniversalUuidResource::collection($schedule->groups);
        }

        public function generate(ScheduleGenerateRequest $request, $scheduleUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $schedule->generateGames($request->get('cycles'));

            return response('schedule.games.generated', 200);
        }

        public function deleteAllGames($scheduleUuid) {
            $schedule = Schedule::getByUuid($scheduleUuid);

            if(!is_object($schedule)) {
                return response('schedule.notExists', 404);
            }

            $schedule->games()->delete();
            return response('schedule.games.deleted', 200);
        }
    }
