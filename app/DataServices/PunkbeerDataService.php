<?php

namespace App\DataServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\ProcessBeerDataJob;
use App\Dataservices\DataServiceInterface;
use App\Transformers\BeerTransformer;

class PunkbeerDataService implements DataServiceInterface
{
    private $beertransformer;
    
    public function __construct(Beertransformer $beer_transformer)
    {
        $this->beertransformer = $beer_transformer;
    }
    
    public function getData($apiEndpoint)
    {
        try {

            $response = Http::get($apiEndpoint);

            if (!$response->successful()) {

                throw new \Exception('Failed to fetch data from the API');
            } 

            return $response;
            
        } catch (\Exception $e) {

           throw $e;
        }
    }

    public function transformData($modelData)
    {
        try {
           return $this->beertransformer($modelData);
        } catch (\Exception $e) {
            throw new \Exception('Failed to transform data from the API');
        }
    }

    public function processData($modelData)
    {
        try {
            // Dispatch the job for background processing
            PunkbeerDataJob::dispatch($modelData);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
