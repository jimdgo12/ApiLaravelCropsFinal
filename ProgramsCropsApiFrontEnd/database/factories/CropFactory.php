<?php

namespace Database\Factories;

use App\Models\Disease;
use Faker\Factory as ImageFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crop>
 */
class CropFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = ImageFactory::create();
        $faker->addProvider(new FakerPicsumImagesProvider($faker));

        return [
            'name' => $this->faker->text(50),
            'description' => $this->faker->text(300),
            'nameScientific' => $this->faker->text(150),
            'history' => $this->faker->text(250),
            'phaseFertilizer' => $this->faker->text(200),
            'phaseHarvest' => $this->faker->text(200),
            'spreading' => $this->faker->text(100),
            'image' => $faker->imageUrl(800, 600)
        ];
    }
}
