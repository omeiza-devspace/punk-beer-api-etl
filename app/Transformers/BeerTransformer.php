<?php

namespace App\Transformers;

use App\Models\Beer;

class BeerTransformer
{
    public static function objectToArray(Beer $beer)
    {
        return [
            'id'          => $beer->id,
            'name'        => $beer->name,
            'tagline'     => $beer->tagline,
            'description' => $beer->description,
            'abv'         => $beer->abv,
            'ibu'         => $beer->ibu,
            'food_pairing' => $beer->food_pairing,
            'image'       => $beer->image,
            'ingredients' => self::transformIngredients($beer->ingredients),
        ];
    }

    protected static function transformIngredients($ingredients)
    {
        return $ingredients->map(function ($ingredient) {
            return [
                'name'  => $ingredient->name,
                'amount' => $ingredient->pivot->amount,
                'unit'   => $ingredient->pivot->unit,
            ];
        });
    }

    public static function jsonToArray($jsonData)
    {
        $beerData = json_decode($jsonData, true);

        // Transform beer data
        $transformedBeer = [
            'name' => $beerData['name'],
            'tagline' => $beerData['tagline'],
            'description' => $beerData['description'],
            'abv' => $beerData['abv'],
            'ibu' => $beerData['ibu'],
        ];

        // Transform ingredients data
        $transformedIngredients = [];
        foreach ($beerData['ingredients'] as $ingredient) {
            $transformedIngredients[] = [
                'name' => $ingredient['name'],
                'amount' => $ingredient['amount'],
                'amount_unit' => $ingredient['amount_unit'],
            ];
        }

        $transformunits = [];
        foreach ($beerData['ingredients'] as $ingredient) {
            $transformedIngredients[] = [ 
                'name' => $ingredient['amount_unit'],
            ];
        }

        $transformuingridienttypes = [];
        foreach ($beerData['ingredients'] as $ingredient) {
            $transformedIngredients[] = [ 
                'name' => $ingredient['amount_unit'],
            ];
        }

        return [
            'beer' => $transformedBeer,
            'ingredients' => $transformedIngredients,
            'units' => $transformunits,
            'ingredient_types' => $transformuingridienttypes,
        ];
    }
}

