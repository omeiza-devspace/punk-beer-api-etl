<?php

namespace App\Http\Controllers;

use App\Repositories\BeerRepository;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Exception;

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
        return $this->handleRequest(function () {
            $beers = $this->beerRepository->getAll();
            return $this->successResponse('Beers retrieved successfully', $beers);
        });
    }

    public function show($id)
    {
        return $this->handleRequest(function () use ($id) {
            $beer = $this->beerRepository->getById($id);
            return $this->successResponse('Beer retrieved successfully', $beer);
        });
    }

    public function getAllProperties()
    {
        return $this->handleRequest(function () {
            // Retrieve beers from the cache or repository
            $beers = Cache::remember('all_beers', 60, function () {
                return $this->beerRepository->getAllProperties();
            });

            return $this->successResponse('Beers retrieved successfully', $beers);
        });
    }

    public function getBeerById($id)
    {
        return $this->handleRequest(function () use ($id) {
            // Retrieve beer from the cache or repository
            $beer = Cache::remember("beer_{$id}", 60, function () use ($id) {
                return $this->beerRepository->getBeerById($id);
            });

            return $this->successResponse('Beer retrieved successfully', $beer);
        });
    }

    public function getBeerByName($name)
    {
        return $this->handleRequest(function () use ($name) {
            // Retrieve beer from the cache or repository
            $beer = Cache::remember("beer_name_{$name}", 60, function () use ($name) {
                return $this->beerRepository->getBeerByName($name);
            });

            return $this->successResponse('Beer retrieved successfully', $beer);
        });
    }

    public function getPunkbeerAPIData(Request $request)
    {
        return $this->handleRequest(function () {
            $apiUrl = Config::get('api-punkbeer.apiUrl');

            // Check if data is already cached
            $cachedData = Cache::remember('punkbeer_api_data', 60, function () use ($apiUrl) {
                $jsonData = $this->punkbeerDataService->getData($apiUrl);
                $transformedData = $this->punkbeerDataService->transformData($jsonData);
                return $this->punkbeerDataService->processData($transformedData);
            });

            return $this->successResponse('Data retrieved successfully', ['data' => $cachedData]);
        });
    }

    public function getWithLimitAndOffset($limit = 10, $offset = 0, $perPage)
    {
        return $this->handleRequest(function () use ($limit, $offset, $perPage) {
            // Create a unique cache key based on parameters
            $cacheKey = "beer_with_limit_offset_{$limit}_{$offset}_{$perPage}";

            // Retrieve data from the cache or repository
            $cachedData = Cache::remember($cacheKey, 60, function () use ($limit, $offset, $perPage) {
                return $this->beerRepository->getWithLimitAndOffset($limit, $offset, $perPage);
            });

            return $this->successResponse('Data retrieved successfully', $cachedData);
        });
    }

    public function getPaginatedData($query, $perPage = 10)
    {
        return $this->handleRequest(function () use ($query, $perPage) {
            // Create a unique cache key based on parameters
            $cacheKey = "beer_paginated_data_{$query}_{$perPage}";

            // Retrieve data from the cache or repository
            $cachedData = Cache::remember($cacheKey, 60, function () use ($query, $perPage) {
                return $this->beerRepository->getPaginatedData($query, $perPage);
            });

            return $this->successResponse('Data retrieved successfully', $cachedData);
        });
    }

    protected function handleRequest($callback)
    {
        try {
            return $callback();
        } catch (\Exception $e) {
            return $this->coreResponse('An error occurred', null, 500, false);
        }
    }
}
