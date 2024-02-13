<?php

namespace App\Jobs;

use App\Repositories\BeerRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;
use App\Transformers\BeerTransformer;

class ProcessBeerData implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $jsonData;

    public function __construct($jsonData)
    {
        $this->jsonData = $jsonData;
    }

    public function handle(BeerRepository $beerRepository)
    {
        try {

            DB::beginTransaction();

            foreach ($modelData as $beerData) {
                ProcessBeerDataJob::dispatch($beerData);
            }
            
            $transformedData = BeerTransformer::jsonToArray($this->jsonData);

            // Insert or retrieve units and ingredient types
            $unitIds = $beerRepository->insertOrUpdateUnits($transformedData['units']);
            $ingredientTypeIds = $beerRepository->insertOrUpdateIngredientTypes($transformedData['ingredient_types']);

            // Insert the transformed beer data into the database
            $beerData = $transformedData['beer'];
            $beerData['unit_id'] = $unitIds[$beerData['unit']];
            $beerData['ingredient_type_id'] = $ingredientTypeIds[$beerData['ingredient_type']];
            $beerId = $beerRepository->createBeer($beerData);

            // Associate ingredients with the created beer
            foreach ($transformedData['ingredients'] as $ingredient) {
                $ingredient['unit_id'] = $unitIds[$ingredient['unit']];
                $ingredient['ingredient_type_id'] = $ingredientTypeIds[$ingredient['ingredient_type']];
                $beerRepository->associateIngredient($beerId, $ingredient);
            }

            DB::commit();

            return true;

        } catch (\Throwable $e) {

            DB::rollBack();
            throw $e;
        }
        
    }
}
