<?php

namespace App\Http\Resources\Api\Admin\Club;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubPlayersResource extends JsonResource
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
            'name' => $this->getFullName() . ' - ' . $this->birthDate->format('Y')
        ];
    }
}
