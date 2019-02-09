<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    public function media()
    {
        return $this->morphOne(Media::class, 'content');
    }

    public function episodes()
    {
        return $this->hasMany(SeriesEpisode::class);
    }
}
