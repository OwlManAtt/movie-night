<?php

namespace Tests\Feature\Listeners;

use App\Events;
use Tests\TestCase;
use App\Models\Media;
use App\Services\IMDB\ImdbApi;
use App\Listeners\LoadMediaMetadata;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\Event;

class LoadMediaMetadataTest extends TestCase
{
    public function test_movie_details()
    {
        $media = factory(Media::class)->states('movie')->create();

        $api = resolve(ImdbApi::class);
        $api->setTestType('movie');

        $listener = $this->resolveListener($api);
        $listener->handle(new Events\MediaChanged($media));

        $media = Media::find($media->id);
        $this->assertNotNull($media->imdb_last_synced_at);
        $this->assertNotNull($media->plot_summary);
    }

    public function test_series_details()
    {
        Event::fake();

        $media = factory(Media::class)->states('series')->create();
        $media->content->episodes()->delete(); // get rid of the ones this comes with

        $api = resolve(ImdbApi::class);
        $api->setTestType('series');

        $listener = $this->resolveListener($api);
        $listener->handle(new Events\MediaChanged($media));

        $media = Media::find($media->id);
        $this->assertNotNull($media->imdb_last_synced_at);
        $this->assertNotNull($media->plot_summary);

        $ep_count = $series->episodes()->count();
        $this->assertGreaterThan(0, $ep_count);
        Event::assertDispatched(Events\MediaChanged::class, $ep_count);
    }

    public function test_episode_details()
    {
        $series = factory(Media::class)->states('series')->create();
        $media = $series->content->episodes()->first()->media;

        $api = resolve(ImdbApi::class);
        $api->setTestType('episode');

        $listener = $this->resolveListener($api);
        $listener->handle(new Events\MediaChanged($media));

        $media = Media::find($media->id);
        $this->assertNotNull($media->imdb_last_synced_at);
        $this->assertNotNull($media->plot_summary);
    }

    private function resolveListener(ImdbApi $api = null)
    {
        $repo = resolve(MediaRepository::class);
        if ($api === null) {
            $api = resolve(ImdbApi::class);
        }

        return (new LoadMediaMetadata($api, $repo));
    }
}
