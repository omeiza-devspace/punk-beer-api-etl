<?php 
namespace Database\Factories;

use App\Models\FoodPairing;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodPairingFactory extends Factory
{
    protected $model = FoodPairing::class;

    public function definition()
    {
        return [
            'pairing' => $this->faker->paragraph,
        ];
    }
}