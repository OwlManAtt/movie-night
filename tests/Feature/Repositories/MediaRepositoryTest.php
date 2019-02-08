<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Repositories\MediaRepository;

class MediaRepositoryTest extends TestCase
{
    protected $repo;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(MediaRepository::class);
    } // end setUp

    public function test_stubbing_new()
    {
        $media = $this->repo->addOrUpdateStub('tt12345', 'Test Movie', 'movie');
        $this->assertTrue($media->exists);
    } // end test_stubbing_new

    public function test_updating_existing()
    {
        $orig_media = factory(\App\Models\Media::class)->create([]);

        $media = $this->repo->addOrUpdateStub($orig_media->imdb_id, $orig_media->title, $orig_media->content_type, 'http://catpics.org/cat.png');
        $this->assertEquals($media->id, $orig_media->id);
        $this->assertNotNull($media->poster_url);
    } // end test_updating_existing
} // end DashboardControllerTest
