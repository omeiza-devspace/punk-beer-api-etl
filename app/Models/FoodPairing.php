<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Beer;

class FoodPairing extends Model
{
    use HasFactory;

    protected $fillable = ['beer_id', 'food_pairing'];

    protected $casts = [
        'id' => 'integer',
        'beer_id' => 'integer',
    ];

    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }
}
