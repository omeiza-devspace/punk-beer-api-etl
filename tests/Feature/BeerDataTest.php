<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Beer;
use App\Models\Ingredient;
use App\Models\Unit;
use App\Models\FoodPairing;

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BeerDataTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_get_all_beers()
    {
        // Arrange
        $beers = \App\Models\Beer::factory(5)->create();

        // Act
        $response = $this->get('/api/beers');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'tagline',
                    'description',
                    'abv',
                    'ibu',
                    'food_pairing' => [
                        '*' => ['pairing'],
                    ],
                    'image_url',
                    'ingredients' => [
                        '*' => [
                            'name',
                            'amount',
                            'unit' => [
                                'name',
                                'abbreviation',
                            ],
                        ],
                    ],
                ],
            ])
            ->assertJsonCount(5, '*');
    }

    public function test_can_get_beer_by_id()
    {
        // Arrange
        $beer = \App\Models\Beer::factory()->create();

        // Act
        $response = $this->get("/api/beers/{$beer->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'tagline',
                'description',
                'abv',
                'ibu',
                'food_pairing' => [
                    '*' => ['pairing'],
                ],
                'image_url',
                'ingredients' => [
                    '*' => [
                        'name',
                        'amount',
                        'unit' => [
                            'name',
                            'abbreviation',
                        ],
                    ],
                ],
            ]);
    }

    public function test_can_get_beer_by_name()
    {
        // Arrange
        $beer = \App\Models\Beer::factory()->create();

        // Act
        $response = $this->get("/api/beers?name={$beer->name}");

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'tagline',
                    'description',
                    'abv',
                    'ibu',
                    'food_pairing' => [
                        '*' => ['pairing'],
                    ],
                    'image_url',
                    'ingredients' => [
                        '*' => [
                            'name',
                            'amount',
                            'unit' => [
                                'name',
                                'abbreviation',
                            ],
                        ],
                    ],
                ],
            ]);
    }


}

