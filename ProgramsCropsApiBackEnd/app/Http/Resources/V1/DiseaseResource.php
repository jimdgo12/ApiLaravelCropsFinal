<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Http\Resources\V1\CropResource;
use App\Http\Resources\V1\PesticideResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DiseaseResource extends JsonResource
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
            'nameCommon' => $this->nameCommon,
            'nameScientific' => $this->nameScientific,
            'description' => $this->description,
            'diagnosis' => $this->diagnosis,
            'symptoms' => $this->symptoms,
            'transmission' => $this->transmission,
            'type' => $this->type,
            'image' => $this->image,
            'crops' => CropResource::collection($this->crops),
            "pesticides" => PesticideResource::collection($this->whenLoaded('pesticides'))
        ];

        // Comenté el bloque de código para evitar errores de sintaxis
        /*
        $resourceArray = [
            'id' => $this->id,
            'nameCommon' => $this->nameCommon,
            'nameScientific' => $this->nameScientific,
            'description' => $this->description,
            'diagnosis' => $this->diagnosis,
            'symptoms' => $this->symptoms,
            'transmission' => $this->transmission,
            'type' => $this->type,
            'image' => $this->image,
        ];

        // Solo incluir los datos específicos de los cultivos si la relación "crops" está cargada
        $resourceArray['crops'] = $this->whenLoaded('crops', function () {
            return $this->crops->map(function ($crop) {
                return [
                    'crop_id' => $crop->id,
                    'crop_name' => $crop->name,
                    // Agrega más campos de cultivo según tus necesidades
                ];
            });
        });

        return $resourceArray;
        */
    }
}
