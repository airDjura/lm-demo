<?php

namespace App\Http\Resources\Api\Admin\Schedule\Group;

use App\Http\Resources\Api\Admin\Schedule\Team\TeamIndexResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'teams' => TeamIndexResource::collection($this->teams),
        ];
    }
}
