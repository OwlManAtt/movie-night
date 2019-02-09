<?php

namespace App\Models;

use App\Events;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $dispatchesEvents = [
        'created' => Events\MediaChanged::class,
    ];

    public function content()
    {
        return $this->morphTo('content');
    }
} // end Media
