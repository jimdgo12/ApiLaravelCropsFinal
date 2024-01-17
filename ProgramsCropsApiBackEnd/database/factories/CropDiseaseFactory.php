<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\Disease;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CropDisease>
 */
class CropDiseaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'crop_id' => function () {
                return Crop::inRandomOrder()->first()->id;
            },

            'disease_id' => function () {
                return Disease::inRandomOrder()->first()->id;
            }
        ];
    }
}
