<?php

namespace Tests\Feature\Controllers;

use App\Events;
use Tests\TestCase;
use App\Models\Media;
use App\Models\SeriesEpisode;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

class MediaControllerTest extends TestCase
{
    public function test_index_loads()
    {
        $this->get('/media')->assertOk();
    } // end test_index_loads

    public function test_index_datatable_ajax()
    {
        $media = factory(Media::class)->states('movie', 'imdb-data')->create(['title' => 'Great Movie']);

        $response = $this->getJson('/media?draw=1', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'recordsTotal' => 1,
                'data' => [
                    0 => ['title' => $media->title],
                ],
            ]);
    } // end test_index_datatable_ajax

    public function test_index_searches_titles()
    {
        $media = factory(Media::class)->states('movie', 'imdb-data')->create(['title' => 'Alphanumeric Title']);
        factory(Media::class)->states('movie', 'imdb-data')->create(['title' => "Mike's Cool and Good Adventure"]);

        $url = $this->buildDatatablesUrl('/media', ['id', 'title', 'imdb_rating', 'year_released', 'runtime', 'created_at'], $media->title);
        $response = $this->getJson($url, ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'recordsTotal' => 2,
                'recordsFiltered' => 1,
                'data' => [
                    0 => ['imdb_id' => $media->imdb_id],
                ],
            ]);
    } // end test_index_searches_titles

    public function test_index_search_ignores_apostrophes()
    {
        factory(Media::class)->states('movie', 'imdb-data')->create(['title' => 'Alphanumeric Title']);
        $media = factory(Media::class)->states('movie', 'imdb-data')->create(['title' => "Mike's Cool and Good Adventure"]);

        $url = $this->buildDatatablesUrl('/media', ['id', 'title', 'imdb_rating', 'year_released', 'runtime', 'created_at'], str_replace("'", '', $media->title));
        $response = $this->getJson($url, ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'recordsTotal' => 2,
                'recordsFiltered' => 1,
                'data' => [
                    0 => ['imdb_id' => $media->imdb_id],
                ],
            ]);
    } // end test_index_search_ignores_nonalphanum_characters

    public function test_no_episodes()
    {
        $series = factory(Media::class)->states('series', 'imdb-data')->create(['title' => 'Just the Series Record']);

        $response = $this->getJson('/media?draw=1', ['X-Requested-With' => 'XMLHttpRequest'])
        ->assertOk()
        ->assertJson([
            'recordsTotal' => 1,
            'data' => [
                0 => [
                    'title' => $series->title,
                ]
            ]
        ]);
    }

    public function test_create_media()
    {
        Event::fake();

        $response = $this->post(route('media.store'), ['imdbId' => 'tt12345', 'title' => 'Good Movie 2', 'mediaType' => 'movie', 'releasedYear' => null, 'posterUrl' => null]);
        $response->assertOk();
        $response->assertJsonStructure(['success', 'url', 'media_id']);
        Event::assertDispatched(Events\MediaChanged::class);

        $json = json_decode($response->getContent(), JSON_OBJECT_AS_ARRAY);

        $media = Media::find($json['media_id']);
        $this->assertNotNull($media);
    } // end test_create_media

    public function test_create_media_with_weird_year()
    {
        Event::fake();

        $this->post(route('media.store'), ['imdbId' => 'tt12345', 'title' => 'Good Movie 2', 'mediaType' => 'movie', 'releasedYear' => '1999-', 'posterUrl' => null])
            ->assertOk();
    } // end test_create_media_with_weird_year

    private function buildDatatablesUrl($base, $columns, $filter = null)
    {
        $url = $base . '?draw=1';

        $url_parts = [
            urlencode('order[0][column]') . '=' . urlencode('0'),
            urlencode('order[0][dir]') . '=' . urlencode('desc'),
        ];

        foreach ($columns as $idx => $column) {
            $url_parts[] = urlencode("columns[$idx][data]") . '=' . urlencode($column);
        }

        if ($filter !== null) {
            $url_parts[] = urlencode("search[value]") . '=' . urlencode($filter);
        }

        return $url . join('&', $url_parts);
    } // end buildDatatableUrl
} // end MediaControllerTest
