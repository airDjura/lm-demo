<?php

    namespace App\Http\Resources\Api\Admin\Schedule;

    use App\Http\Resources\Api\Admin\Schedule\Group\ScheduleGameResource;
    use App\Http\Resources\Api\Admin\Schedule\Group\ScheduleGroupResource;
    use App\Http\Resources\Api\Admin\Schedule\Team\TeamIndexResource;
    use App\Http\Resources\UniversalGetNameUuidResouce;
    use App\Models\Client\Game;
    use Illuminate\Http\Resources\Json\JsonResource;

    class ScheduleShowResource extends JsonResource {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return array
         */
        public function toArray($request) {
            return [
                'uuid' => $this->uuid,
                'name'   => $this->getName(),
                'groups' => ScheduleGroupResource::collection($this->groups),
                'games'  => Game::where('schedule_id', $this->id)
                                ->with('homeTeam.club', 'awayTeam.club', 'group')
                                ->get()
                                ->groupBy('round'),

            ];
        }
    }
