<?php

namespace App\Listeners;

use App\Events;
use App\Models\Media;
use App\Services\IMDB\ImdbApi;
use App\Repositories\MediaRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoadMediaMetadata
{
    protected $api;
    protected $repo;

    public function __construct(ImdbApi $api, MediaRepository $repo)
    {
        $this->api = $api;
        $this->repo = $repo;
    }

    public function handle($event)
    {
        $details = $this->api->findById($event->media->imdb_id);

        if ($details['Type'] === 'episode') {
            return $this->syncEpisode($event->media, $details);
        }

        if ($details['Type'] === 'series') {
            return $this->syncSeries($event->media, $details);
        }

        return $this->syncMovie($event->media, $details);
    }

    private function syncMovie(Media $media, $details)
    {
        return $this->repo->updateMovie($media->content, $this->mapBasicInfo($details));
    }

    private function syncSeries(Media $media, $details)
    {
        $episodes_to_save = [];
        $total_seasons = (int)$details['totalSeasons'] ?: 1;

        for ($season_counter=0; $season_counter < $total_seasons; $season_counter++) {
            $episode_list = $this->api->findByIdAndSeason($media->imdb_id, ($season_counter + 1));

            foreach ($episode_list['Episodes'] as $episode) {
                $episodes_to_save[] = [
                    'season_number' => $episode_list['Season'],
                    'episode_number' => $episode['Episode'],
                    'imdb_id' => $episode['imdbID'],
                    'title' => $episode['Title'],
                    'imdb_rating' => $this->parseRating($episode['imdbRating']),
                ];
            }
        }

        $media = $this->repo->updateSeries($media->content, $this->mapBasicInfo($details), $total_seasons, $episodes_to_save);

        $media->content->episodes->map->media->filter(function ($m) {
            return $m->imdb_last_synced_at === null;
        })->each(function ($m) {
            event(new Events\MediaChanged($m));
        });

        return $media;
    }

    private function syncEpisode(Media $media, $details)
    {
        return $this->repo->updateEpisodeDetails($media->content, $this->mapBasicInfo($details));
    }

    private function mapBasicInfo($api_response)
    {
        /*
        * @TODO: This should be part of the ImdbApi stuff.
        * This is mapping fields from the vendor API package to my app's fields,
        * and that does not belong in this listener.
        */
        return [
            'imdb_id' => $api_response['imdbID'],
            'title' => $api_response['Title'],
            'imdb_rating' =>  $this->parseRating($api_response['imdbRating']),
            'year_released' => $api_response['Year'],
            'runtime' => $api_response['Runtime'],
            'poster_url' => $api_response['Poster'],
            'plot_summary' => $api_response['Plot'],
        ];
    } // end mapApiToDb

    private function parseRating($rating)
    {
        if ($rating == 'N/A') {
            return null;
        }

        return $rating;
    }
}
