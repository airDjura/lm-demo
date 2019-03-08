<?php

namespace App\Http\Resources\Api\Admin\League;

use Illuminate\Http\Resources\Json\JsonResource;

class LeagueShowResource extends JsonResource
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
        ];
    }
}
