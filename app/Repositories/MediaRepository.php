<?php

namespace App\Repositories;

use App\Models\Media;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Support\Facades\DB;
use App\Exceptions\UnknownMediaType;
use Illuminate\Database\Eloquent\Relations\Relation;

class MediaRepository
{
    /**
     * Adds (or updates, if it already exists) a "stub" Media entry
     *
     * This will be put in the DB without any of the "extra" fields like plot summary,
     * duration, episode rows, etc. -- the intent is to save it and queue an API call
     * for the details once it's safely in the DB.
     */
    public function addOrUpdateStub($imdb_id, $title, $type, $poster_url = null, $year_released = null)
    {
        if (array_key_exists($type, Relation::morphMap()) === false) {
            throw new UnknownMediaType(vsprintf("Media type %s cannot be resolved to a model.", [$type]));
        }

        return DB::transaction(function () use ($imdb_id, $title, $type, $poster_url, $year_released) {
            $type_lookup = Relation::morphMap();
            $type_class = $type_lookup[$type];
            $media_subtype = $type_class::create();

            $media = Media::updateOrCreate(['imdb_id' => $imdb_id], [
                'title' => $title,
                'year_released' => $year_released,
                'poster_url' => $poster_url,
                'content_type' => $type,
                'content_id' => $media_subtype->id,
            ]);

            return $media;
        });
    } // end addOrUpdateStub
} // end MediaRepository
