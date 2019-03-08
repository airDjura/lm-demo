<?php

namespace App\Http\Resources\Api\Admin\Schedule\Team;

use App\Http\Resources\UniversalUuidResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamCreateResouce extends JsonResource
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
            'name' => $this->getName(),
            'groups' => UniversalUuidResource::collection($this->groups),
        ];
    }
}
