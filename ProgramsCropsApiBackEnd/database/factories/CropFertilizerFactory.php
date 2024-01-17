<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\Fertilizer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CropFertilizer>
 */
class CropFertilizerFactory extends Factory
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

            'fertilizer_id' => function () {
                return Fertilizer::inRandomOrder()->first()->id;
            }
        ];
    }
}
