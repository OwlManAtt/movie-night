<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Media;
use App\Models\Movie;
use App\Models\Series;
use App\Models\SeriesEpisode;
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
    public function addOrUpdateStub($imdb_id, $title, $type, $poster_url = null, $year_released = null, $series_id = null)
    {
        if (array_key_exists($type, Relation::morphMap()) === false) {
            throw new UnknownMediaType(vsprintf("Media type %s cannot be resolved to a model.", [$type]));
        }

        return DB::transaction(function () use ($imdb_id, $title, $type, $poster_url, $year_released, $series_id) {
            $type_class = Relation::morphMap()[$type];

            $subtype_required_fields = [];
            if ($series_id !== null) {
                $subtype_required_fields['series_id'] = $series_id;
            }

            $media_subtype = $type_class::create($subtype_required_fields);

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

    public function updateMovie(Movie $movie, $info)
    {
        return $this->updateMediaAndSyncTime($movie->media, $info);
    }

    public function updateSeries(Series $series, $info, $total_seasons, $episodes)
    {
        return DB::transaction(function () use ($series, $info, $total_seasons, $episodes) {
            $media = $this->updateMediaAndSyncTime($series->media, $info);

            // Series model
            $series->update([
                'season_count' => $total_seasons,
                'episode_count' => count($episodes),
            ]);

            foreach ($episodes as $episode_data) {
                $episode = $this->addOrUpdateEpisode($series, $episode_data);
            }

            // Refresh Media w/ updated relationship info
            $media->load('content');
            return $media;
        });
    }

    public function addOrUpdateEpisode(Series $series, $info, $details = false)
    {
        $media = $this->addOrUpdateStub($info['imdb_id'], $info['title'], 'episode', null, null, $series->id);

        $media->content->update([
            'series_id' => $series->id,
            'season' => $info['season_number'],
            'episode' => $info['episode_number'],
            'episode_order' => (int)$info['episode_number'],
        ]);

        // Refresh w/ stuff we just added
        $media->load('content');

        if ($details == true) {
            $media = $this->updateMediaAndSyncTime($media, $media_stub_details);
        }

        return $media;
    }

    public function updateEpisodeDetails(SeriesEpisode $episode, $details)
    {
        return $this->updateMediaAndSyncTime($episode->media, $details);
    }

    private function updateMediaAndSyncTime(Media $media, $info)
    {
        $media->update(array_merge($info, [
            'imdb_last_synced_at' => Carbon::now(),
        ]));

        return $media;
    }
} // end MediaRepository
