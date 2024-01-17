<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nameScientific' => $this->nameScientific,
            'origin' => $this->origin,
            'morphology' => $this->morphology,
            'type' => $this->type,
            'quality' => $this->quality,
            'spreading' => $this->spreading,
            'image' => $this->image,
            'crop' => [
                'id' => $this->crop->id,
                'name' => $this->crop->name,

            ]


        ];
    }
}
