<?php

namespace App\Repositories;

use App\Models\FoodPairing;

class FoodPairingRepository extends BaseRepository
{
    public function model()
    {
        return FoodPairing::class;
    }

}
