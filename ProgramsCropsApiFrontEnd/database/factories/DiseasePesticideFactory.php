<?php

namespace Database\Factories;

use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiseasePesticide>
 */
class DiseasePesticideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pesticide_id' => function () {
                return Pesticide::inRandomOrder()->first()->id;
            },

            'disease_id' => function () {
                return Disease::inRandomOrder()->first()->id;
            }
        ];
    }
}
