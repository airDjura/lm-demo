<?php

namespace App\Http\Resources\Api\Admin\Player;

use App\Http\Resources\UniversalUuidResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerShowResource extends JsonResource
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
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'middleName' => $this->middleName,
            'email' => $this->email,
            'name' => $this->name,
            'birthDate' => $this->birthDate->format('Y-m-d'),
            'club' => new UniversalUuidResource($this->club),
        ];
    }
}
