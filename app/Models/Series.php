<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    public function media()
    {
        return $this->morphOne(Media::class, 'content');
    }

    public function episodes()
    {
        return $this->hasMany(SeriesEpisode::class);
    }
}
