<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Http\Resources\V1\DiseaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PesticideResource extends JsonResource
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
            'name' =>$this->name,
            'description' =>$this->description,
            'activeIngredient' =>$this->activeIngredient,
            'price' =>$this->price,
            'type' =>$this->type,
            'dose' =>$this->dose,
            'image' =>$this->image,
            'diseases' => DiseaseResource::collection($this->diseases)
        ];
    }
}
