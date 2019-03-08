<?php

namespace App\Http\Resources\Api\Admin;

use App\Http\Resources\UniversalUuidResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
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
            'name' => $this->getFullName(),
            'currentSeason' => new UniversalUuidResource(\App\Models\Client\Season::getCurrentAdminSeason()),
        ];
    }
}
