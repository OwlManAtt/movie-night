<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImdbSearchControllerTest extends TestCase
{
    public function test_nothing_found()
    {
        $this->getJson('/imdb?title=None', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertJson([
                'status' => false,
                'error' => null,
            ]);
    } // end test_nothing_found

    public function test_results_found()
    {
        $this->getJson('/imdb?title=Cop', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'status' => true,
                'error' => null,
            ])
            ->assertJsonStructure([
                'data' => [
                    'imdb' => [
                        0 => ['Poster', 'Title', 'imdbID', 'Year'],
                    ],
                ],
            ]);
    } // end test_results_found
} // end ImdbSearchControllerTest
