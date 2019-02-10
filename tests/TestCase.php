<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->artisan("db:seed");

        $imdb_api = resolve(\App\Services\IMDB\MockImdbApi::class);
        $this->app->instance(\App\Services\IMDB\ImdbApi::class, $imdb_api);

        $this->user = factory(\App\Models\User::class)->create();
    } // end setUp
} // end TestCase
