<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\Beer;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'amount', 'add', 'attribute'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function ingredientType()
    {
        return $this->belongsTo(IngredientType::class);
    }
}
