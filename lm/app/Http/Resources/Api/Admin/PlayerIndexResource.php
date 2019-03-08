<?php

    namespace App\Http\Resources\Api\Admin;

    use App\Http\Resources\UniversalUuidResource;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Spatie\MediaLibrary\Models\Media;

    class PlayerIndexResource extends JsonResource {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return array
         */
        public function toArray($request) {
            return [
                'uuid'      => $this->uuid,
                'name'      => $this->getFullName(),
                'birthDate' => $this->birthDate->format('Y'),
                'club'      => new UniversalUuidResource($this->club),
                'profile'   => is_object($this->getMedia('profile')
                                              ->first()) ? $this->getMedia('profile')
                                                                ->first()
                                                                ->getFullUrl('thumb') : "",
            ];
        }
    }
