<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FoodPairing;
use App\Models\Ingredient;

class Beer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'tagline', 'description', 'abv', 'ibu', 'image_url', 'food_pairing_id'];

    protected $casts = [
        'id' => 'integer',
        'abv' => 'float',
        'ibu' => 'integer',
        'food_pairing_id' => 'integer',
    ];

    public function foodPairing()
    {
        return $this->hasOne(FoodPairing::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
