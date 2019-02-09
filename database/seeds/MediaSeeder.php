<?php

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run()
    {
        factory(Media::class, 125)->states('movie', 'imdb-data')->create();
        factory(Media::class, 125)->states('series', 'imdb-data')->create();
    } // end run
} // end MediaSeeder
