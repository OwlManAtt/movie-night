<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesEpisode extends Model
{
    public function media()
    {
        return $this->morphOne(Media::class, 'content');
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
