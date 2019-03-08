<?php

namespace App\Http\Resources\Api\Admin\Season;

use Illuminate\Http\Resources\Json\JsonResource;

class SeasonIndexResource extends JsonResource
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
            'isCurrent' => $this->isCurrent,
        ];
    }
}
