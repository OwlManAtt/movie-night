<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Media;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MediaControllerTest extends TestCase
{
    public function test_index_loads()
    {
        $this->get('/media')->assertOk();
    } // end test_index_loads

    public function test_index_datatable_ajax()
    {
        $media = factory(Media::class)->states('imdb-data')->create();

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
        $media = factory(Media::class)->states('imdb-data')->create(['title' => 'Alphanumeric Title']);
        factory(Media::class)->states('imdb-data')->create(['title' => "Mike's Cool and Good Adventure"]);

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
        factory(Media::class)->states('imdb-data')->create(['title' => 'Alphanumeric Title']);
        $media = factory(Media::class)->states('imdb-data')->create(['title' => "Mike's Cool and Good Adventure"]);

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
