<?php

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run()
    {
        factory(Media::class, 1000)->states('imdb-data')->create();
    } // end run

} // end MediaSeeder
