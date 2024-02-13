<?php

namespace App\Repositories;

use App\Models\Beer;
use Illuminate\Support\Facades\DB;
use Exception;

class BeerRepository extends BaseRepository
{

    public function model()
    {
        return Beer::class;
    }

    public function getPaginatedBeers($perPage = 10)
    {
        try {
            // Retrieve paginated beers
            $beers = Beer::with(['foodPairing', 'ingredients.unit'])->paginate($perPage);
            return $beers;
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve beers', 500);
        }
    }

    public function getAllProperties()
    {
        try {
            // Retrieve all beers
            $beers = Beer::with(['foodPairing', 'ingredients.unit'])->get();
            return $beers;
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve beers', 500);
        }
    }

    public function getBeerById($id)
    {
        try {
            // Retrieve a beer by ID
            $beer = Beer::with(['foodPairing', 'ingredients.unit'])->find($id);

            if (!$beer) {
                throw new Exception('Beer not found', 404);
            }

            return $beer;
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve beer', 500);
        }
    }

    public function getBeerByName($name)
    {
        try {
            // Retrieve a beer by name
            $beer = Beer::with(['foodPairing', 'ingredients.unit'])->where('name', $name)->first();

            if (!$beer) {
                throw new Exception('Beer not found', 404);
            }

            return $beer;
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve beer', 500);
        }
    }

    public function getWithLimitAndOffset($limit = 10, $offset = 0, $perPage = 10)
    {
        try {
            $beers = Beer::with(['foodPairing', 'ingredients.unit'])
                    ->skip($offset)->take($limit)->get()
                    ->paginate($perPage);

            return $beers;
        } catch (\Throwable $th) {
            throw new Exception('Failed to retrieve beer', 500);
        }
    }


    public function getPaginatedData($query, $perPage = 10 )
    {
        try {

            $beers = Beer::where('name', 'like', '%' . $query . '%')
            ->orWhere('tagline', 'like', '%' . $query . '%')
            ->paginate($perPage);

            return $beers;

        } catch (\Throwable $th) {
            throw new Exception('Failed to retrieve beer', 500);
        }
        
    }
}
