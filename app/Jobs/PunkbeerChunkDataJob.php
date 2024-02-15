<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransformBeerChunkToModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $beerChunk;

    public function __construct($beerChunk)
    {
        $this->beerChunk = $beerChunk;
    }

    public function handle()
    {
        foreach ($this->beerChunk as $beerData) {
            dispatch(new PunkbeerDataJob($beerData));
        }
    }
}