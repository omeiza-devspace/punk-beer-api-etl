<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'amount' => $this->faker->randomFloat(2, 0.1, 10),
            'amount_unit_id' => Unit::factory(),
        ];
    }
}
