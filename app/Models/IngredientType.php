<?php 

use Illuminate\Database\Eloquent\Model;

class IngredientType extends Model
{
    protected $fillable = ['name'];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}

