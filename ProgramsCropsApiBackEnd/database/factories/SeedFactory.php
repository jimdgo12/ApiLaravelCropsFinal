<?php

namespace Database\Factories;

use App\Models\Crop;
use Faker\Factory as ImageFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seed>
 */
class SeedFactory extends Factory
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
            'nameScientific' => $this->faker->text(150),
            'origin' => $this->faker->text(50),
            'morphology' => $this->faker->text(150),
            'type' => $this->faker->randomElement(['Tipo I', 'Tipo II', 'Tipo III', 'Tipo IV']),
            'quality' => $this->faker->text(50),
            'spreading' => $this->faker->text(50),
            'image' => $faker->imageUrl(800, 600),
            'crop_id' => function () {
                return Crop::inRandomOrder()->first()->id;
            }
        ];
    }
}
