<?php

namespace App\Repositories;

use App\Models\Unit;

class UnitRepository extends BaseRepository
{
    public function model()
    {
        return Unit::class;
    }

}
