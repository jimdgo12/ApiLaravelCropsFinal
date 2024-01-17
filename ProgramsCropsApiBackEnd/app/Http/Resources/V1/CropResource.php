<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Http\Resources\V1\SeedResource;
use App\Http\Resources\V1\DiseaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CropResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "nameScientific" => $this->nameScientific,
            "history" => $this->history,
            "phaseFertilizer" => $this->phaseFertilizer,
            "phaseHarvest" => $this->phaseHarvest,
            "spreading" => $this->spreading,
            "image" => $this->image,
            "seeds" => SeedResource::collection($this->seeds),
            "diseases" => DiseaseResource::collection($this->whenLoaded('diseases'))



        ];
    }
}
