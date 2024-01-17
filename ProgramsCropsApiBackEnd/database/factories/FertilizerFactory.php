<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fertilizer>
 */
class FertilizerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        return [
            'name'=> $this->faker->text(50),
            'description'=> $this->faker->text(300),
            'dose'=> $this->faker->text(150),
            'price' => $this->faker->numberBetween(0, 100),
            'type'=> $this->faker->randomElement(['Tipo 1', 'Tipo 2', 'Tipo 3', 'Tipo 4']),
            'image'=> $faker->imageUrl(800, 600)
        ];
    }
}
