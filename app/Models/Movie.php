<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function media()
    {
        return $this->morphOne(Media::class, 'content');
    }
}
