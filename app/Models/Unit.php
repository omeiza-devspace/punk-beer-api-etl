<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ingredient;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['unit'];

    protected $casts = [
        'id' => 'integer',
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
