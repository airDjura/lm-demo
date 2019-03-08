<?php

namespace App\Http\Resources\Api\Admin\Schedule\Game;

use App\Http\Resources\UniversalGetNameUuidResouce;
use Illuminate\Http\Resources\Json\JsonResource;

class GameShowResource extends JsonResource
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
            'round' => $this->round,
            'homeTeam' => $this->homeTeam ? $this->homeTeam->getName() : null,
            'awayTeam' => $this->awayTeam ? $this->awayTeam->getName() : null,
            'schedule' => new UniversalGetNameUuidResouce($this->schedule)
        ];
    }
}
