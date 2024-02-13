<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Beer;
use App\Models\Ingredient;
use App\Models\FoodPairing;
use App\Models\Unit;
use Illuminate\Validation\Rule;

class xBeerController extends Controller
{
    
    public function index()
    {
        // Retrieve all beers
        $beers = Beer::all();

        // You can modify the response as needed (e.g., transform to JSON)
        return response()->json($beers);
    }

    public function getExternalPaginatedData($perPage = 10)
    {
        // Replace with the actual API URL
        $externalApiUrl = 'https://example.com/api/beers';

        $response = Http::get($externalApiUrl);

        if ($response->successful()) {
            $externalData = $response->json();

            // Validate the external data before processing
            $this->validateExternalData($externalData);

            // Paginate the external data
            $paginatedData = collect($externalData)->paginate($perPage);

            return response()->json($paginatedData);
        } else {
            return response()->json(['error' => 'Failed to fetch external data'], $response->status());
        }
    }

  
    public function getPaginatedBeers($perPage = 10)
    {
        $beers = Beer::with(['foodPairing', 'ingredients.unit'])->paginate($perPage);

        return response()->json($beers);
    }



    public function getAllBeers()
    {
        $beers = Beer::with(['foodPairing', 'ingredients.unit'])->get();

        return response()->json($beers);
    }

 
    public function getBeerById($id)
    {
        $beer = Beer::with(['foodPairing', 'ingredients.unit'])->find($id);

        if (!$beer) {
            return response()->json(['error' => 'Beer not found'], 404);
        }

        return response()->json($beer);
    }

   
    public function getBeerByName($name)
    {
        $beer = Beer::with(['foodPairing', 'ingredients.unit'])->where('name', $name)->first();

        if (!$beer) {
            return response()->json(['error' => 'Beer not found'], 404);
        }

        return response()->json($beer);
    }

    public function getExternalData()
    {
        // Replace with the actual API URL
        $externalApiUrl = 'https://example.com/api/beers';

        $response = Http::get($externalApiUrl);

        if ($response->successful()) {
            $externalData = $response->json();

            // Validate the external data before processing
            $this->validateExternalData($externalData);

            // Process or save the external data as needed
            // You can also return the external data directly
            return response()->json($externalData);
        } else {
            return response()->json(['error' => 'Failed to fetch external data'], $response->status());
        }
    }

    /**
     * Validate the external data against the expected data models.
     *
     * @param array $externalData
     * @return void
     */
    private function validateExternalData(array $externalData)
    {
        // Example validation rules, adjust as needed
        $rules = [
            '*' => [
                'id' => 'required|integer',
                'name' => 'required|string',
                'tagline' => 'required|string',
                'description' => 'required|string',
                'abv' => 'required|numeric',
                'ibu' => 'required|integer',
                'food_pairing' => 'required|array',
                'image_url' => 'required|url',
                'ingredients' => 'required|array',
            ],
            'ingredients.*' => [
                'name' => 'required|string',
                'amount_value' => 'required|numeric',
                'amount_unit_id' => 'required|exists:units,id',
                'add' => 'required|string',
                'attribute' => 'required|string',
            ],
            'food_pairing.*' => [
                'food_pairing' => 'required|string',
            ],
        ];

        $validator = \Validator::make($externalData, $rules);

        if ($validator->fails()) {
            abort(422, $validator->errors());
        }
    }
}
