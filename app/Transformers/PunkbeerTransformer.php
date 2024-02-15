<?php
namespace App;

use App\Models\Beer;
use App\Models\Unit;
use App\Models\IngredientType;
use Illuminate\Support\Facades\DB;

class PunkbeerTransformer
{
    public static function transformJsonToModels($beerData)
    {
        $beers = [];
        $ingredients = [];

        DB::beginTransaction();

        try {
            foreach ($beerData as $beerDataItem) {
                $beer = self::createBeer($beerDataItem);
                $beers[] = $beer;

                $ingredients = array_merge(
                    $ingredients,
                    self::createIngredients($beer, $beerDataItem['ingredients']['malt'], 'litres', 'malt'),
                    self::createIngredients($beer, $beerDataItem['ingredients']['hops'], 'grams', 'hops')
                );

                // Create Yeast Ingredient
                $yeast = self::createIngredient($beer, $beerDataItem['ingredients']['yeast'], 1, 'unit', 'yeast');
                $ingredients[] = $yeast;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return [
            'beers' => $beers,
            'ingredients' => $ingredients,
        ];
    }

    public static function createBeer($beerData)
    {
        return Beer::create([
            'name' => $beerData['name'],
            'tagline' => $beerData['tagline'],
            'description' => $beerData['description'],
            'abv' => $beerData['abv'],
            'ibu' => $beerData['ibu'],
            'food_pairing' => json_encode($beerData['food_pairing']),
            'image_url' => $beerData['image_url'],
        ]);
    }

    public static function createIngredients($beer, $ingredientsData, $unitName, $ingredientTypeName)
    {
        $ingredients = [];

        foreach ($ingredientsData as $ingredientData) {
            $ingredient = self::createIngredient(
                $beer,
                $ingredientData['name'],
                $ingredientData['amount']['value'],
                $unitName,
                $ingredientTypeName,
                $ingredientData['add'] ?? null,
                $ingredientData['attribute'] ?? null
            );
            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }

    public static function createIngredient($beer, $name, $amount, $unitName, $ingredientTypeName, $add = null, $attribute = null)
    {
        // Check if Unit exists, if not create
        $unit = Unit::firstOrCreate(['name' => $unitName]);

        // Check if Ingredient Type exists, if not create
        $ingredientType = IngredientType::firstOrCreate(['name' => $ingredientTypeName]);

        // Create Ingredient
        return $beer->ingredients()->create([
            'name' => $name,
            'amount' => $amount,
            'unit_id' => $unit->id,
            'ingredient_type_id' => $ingredientType->id,
            'add' => $add,
            'attribute' => $attribute,
        ]);
    }
}
