<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    public function media()
    {
        return $this->morphOne(Media::class, 'content');
    }
}
