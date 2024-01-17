<?php

namespace Database\Factories;


use Faker\Factory as ImageFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pesticide>
 */
class PesticideFactory extends Factory
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
            'name'=> $this->faker->text(50),
            'description'=> $this->faker->text(300),
            'activeIngredient'=> $this->faker->text(150),
            'price' => $this->faker->numberBetween(1, 300000),//error
            'type'=> $this->faker->randomElement(['Tipo I', 'Tipo II', 'Tipo III', 'Tipo IV']),
            'dose'=> $this->faker->text(150),
            'image'=> $faker->imageUrl(800, 600)
        ];
    }
}
