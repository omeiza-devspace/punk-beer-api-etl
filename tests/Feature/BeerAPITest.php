<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BeerAPITest extends TestCase
{
    /**
     * Test retrieving all beers.
     *
     * @return void
     */
    public function testGetAllBeers()
    {
        $response = $this->get('/api/beers');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Beers retrieved successfully',
            ]);
    }

    /**
     * Test retrieving a specific beer by ID.
     *
     * @return void
     */
    public function testGetBeerById()
    {
        $beerId = 1; // replace with an actual beer ID
        $response = $this->get("/api/beers/{$beerId}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Beer retrieved successfully',
            ]);
    }

    /**
     * Test retrieving a specific beer by name.
     *
     * @return void
     */
    public function testGetBeerByName()
    {
        $beerName = 'Sample Beer'; // replace with an actual beer name
        $response = $this->get("/api/beers/name/{$beerName}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Beer retrieved successfully',
            ]);
    }

    /**
     * Test fetching external beer data.
     *
     * @return void
     */
    public function testGetExternalData()
    {
        $response = $this->get('/api/external-beers');

        $response->assertStatus(202)
            ->assertJson([
                'message' => 'Data processing job dispatched successfully',
            ]);
    }
}
