<?php

namespace App\Repositories;

use App\Models\IngredientTypeRepository;

class IngredientTypeRepository extends BaseRepository
{
    public function model()
    {
        return IngredientType::class;
    }

}
