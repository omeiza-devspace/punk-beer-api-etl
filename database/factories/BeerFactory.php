<?php

namespace Database\Factories;

use App\Models\Beer;
use App\Models\FoodPairing;
use App\Models\Ingredient;

use Illuminate\Database\Eloquent\Factories\Factory;

class BeerFactory extends Factory
{
    protected $model = Beer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'tagline' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'abv' => $this->faker->randomFloat(1, 1, 10),
            'ibu' => $this->faker->randomFloat(1, 1, 100),
            'food_pairing' => FoodPairing::factory(),
            'image_url' => $this->faker->imageUrl(),
            'ingredients_id' => Ingredient::factory(),
        ];
    }
}
