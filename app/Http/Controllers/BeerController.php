<?php

namespace App\Http\Controllers;

use App\Repositories\BeerRepository;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BeerController extends Controller
{
    use APIResponse;

    protected $beerRepository;

    public function __construct(BeerRepository $beerRepository)
    {
        $this->beerRepository = $beerRepository;
    }

    public function index()
    {
        try {
            $beers = $this->beerRepository->getAll();
            return $this->successResponse('Beers retrieved successfully', $beers);
        } catch (\Exception $e) {
            return $this->coreResponse('An error occurred while retrieving Beers', null, 500, false);
        }
    }

    public function show($id)
    {
        try {
            $beer = $this->beerRepository->getById($id);
            return $this->successResponse('Beer retrieved successfully', $beer);
        } catch (\Exception $e) {
            return $this->coreResponse('An error occurred while retrieving Beer', null, 500, false);
        }
    }

    public function getAllProperties()
    {
        try {
            // Attempt to retrieve beers from the cache
            $beers = Cache::remember('all_beers', 60, function () {
                // Cache key 'all_beers' will be stored for 60 minutes (adjust as needed)
                return $this->beerRepository->getAllProperties();
            });

            return $this->successResponse('Beers retrieved successfully', $beers);
        } catch (Exception $e) {
            return $this->coreResponse('Failed to retrieve beers', null, 500, false);
        }
    }

    public function getBeerById($id)
    {
        try {
            $beer = Cache::remember("beer_{$id}", 60, function () use ($id) {
                return $this->beerRepository->getBeerById($id);
            });

            return $beer;
        } catch (Exception $e) {
            return $this->coreResponse('Failed to retrieve beer', null, 500, false);
        }
    }


    public function getBeerByName($name)
    {
        try {
            $beer = Cache::remember("beer_name_{$name}", 60, function () use ($name) {
                return $this->beerRepository->getBeerByName($name);
            });
    
            return $beer;
        } catch (Exception $e) {
            return $this->coreResponse('Failed to retrieve beer', null, 500, false);
        }
    }

    public function getPunkbeerAPIData(Request $request)
    {
        try {
            $apiUrl = Config::get('api-punkbeer.apiUrl');

            // Check if data is already cached
            $cachedData = Cache::remember('punkbeer_api_data', 60, function () use ($apiUrl) {
                $jsonData = $this->punkbeerDataService->getData($apiUrl);
                $transformedData = $this->punkbeerDataService->transformData($jsonData);
                return $this->punkbeerDataService->processData($transformedData);
            });

            return response()->json(['data' => $cachedData, 'message' => 'Data retrieved successfully'], 200);

        } catch (\Exception $e) {
            return $this->coreResponse('Failed to fetch external data', null, 500, false);
        }
    }

    public function getWithLimitAndOffset($limit = 10, $offset = 0, $perPage)
    {
        try {
            // Create a unique cache key based on parameters
            $cacheKey = "beer_with_limit_offset_{$limit}_{$offset}_{$perPage}";

            // Check if data is already cached
            $cachedData = Cache::remember($cacheKey, 60, function () use ($limit, $offset, $perPage) {
                return $this->beerRepository->getWithLimitAndOffset($limit, $offset, $perPage);
            });

            return $cachedData;

        } catch (\Throwable $th) {
            return $this->coreResponse('Failed to retrieve beer', null, 500, false);
        }
    }

    public function getPaginatedData($query, $perPage = 10)
    {
        try {
            // Create a unique cache key based on parameters
            $cacheKey = "beer_paginated_data_{$query}_{$perPage}";

            // Check if data is already cached
            $cachedData = Cache::remember($cacheKey, 60, function () use ($query, $perPage) {
                return $this->beerRepository->getPaginatedData($query, $perPage);
            });

            return $cachedData;

        } catch (\Throwable $th) {
            return $this->coreResponse('Failed to retrieve beer', null, 500, false);
        }
    }
   
}
