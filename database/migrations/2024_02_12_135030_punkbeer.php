<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline');
            $table->text('description');
            $table->float('abv');
            $table->float('ibu');
            $table->json('food_pairing');
            $table->string('image_url');
            $table->timestamps();
        });

        Schema::create('ingredient_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beer_id')->constrained();
            $table->foreignId('ingredient_type_id')->constrained();
            $table->string('name');
            $table->float('amount_value');
            $table->foreignId('unit_id')->constrained('units');
            $table->timestamps();
        });
  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('ingredient_types');
        Schema::dropIfExists('beers');
        Schema::dropIfExists('units');
    }
};

