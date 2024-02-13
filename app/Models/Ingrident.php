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
        'name', 
        'amount_value',
        'amount_unit_id',
        'add', 
        'attribute',
        'beer_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'amount_value' => 'float',
        'amount_unit_id' => 'integer',
        'beer_id' => 'integer',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'amount_unit_id');
    }

    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }
}
