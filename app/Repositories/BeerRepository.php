<?php

namespace App\Repositories;

use App\Models\Beer;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class BeerRepository extends BaseRepository
{
    public function model()
    {
        return Beer::class;
    }

    public function getPaginatedBeers($perPage = 10)
    {
        return $this->getBeersWithRelations()->paginate($perPage);
    }

    public function getAllProperties()
    {
        return $this->getBeersWithRelations()->get();
    }

    public function getBeerById($id)
    {
        return $this->getBeersWithRelations()->findOrfail($id);
    }

    public function getBeerByName($name)
    {
        return $this->getBeersWithRelations()->where('name', $name)->firstOrFail();
    }

    public function getWithLimitAndOffset($limit = 10, $offset = 0, $perPage = 10)
    {
        return $this->getBeersWithRelations()->skip($offset)->take($limit)->paginate($perPage);
    }

    public function getPaginatedData($query, $perPage = 10)
    {
        return $this->getBeersWithRelations()
            ->where(function (Builder $builder) use ($query) {
                $builder->where('name', 'like', '%' . $query . '%')
                    ->orWhere('tagline', 'like', '%' . $query . '%');
            })
            ->paginate($perPage);
    }

    protected function getBeersWithRelations()
    {
        try {
            return Beer::with(['ingredients.type', 'ingredients.unit']);
        } catch (\Throwable $th) {
            throw new Exception('Failed to retrieve beers', 500);
        }
    }
}
