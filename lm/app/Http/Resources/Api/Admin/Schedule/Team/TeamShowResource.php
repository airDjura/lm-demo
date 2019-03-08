<?php

namespace App\Http\Resources\Api\Admin\Schedule\Team;

use App\Http\Resources\Api\Admin\Club\ClubPlayersResource;
use App\Http\Resources\UniversalGetNameUuidResouce;
use App\Http\Resources\UniversalUuidResource;
use App\Models\Client\Group;
use App\Models\Client\Schedule;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $schedule = $this->schedule;

        return [
            'name' => $this->getName(),
            'suffix' => $this->suffix,
            'schedule' => new UniversalGetNameUuidResouce($schedule),
            'club' => new UniversalUuidResource($this->club),
            'group' => new UniversalUuidResource($this->group),
            'groups' => UniversalUuidResource::collection(Group::where('schedule_id', $schedule->id)->get()),
            'out_of_competition' => $this->out_of_competition,
            'players' => ClubPlayersResource::collection($this->players),
        ];
    }
}
