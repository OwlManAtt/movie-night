<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_no_avatar()
    {
        $user = factory(User::class)->create(['avatar_url' => null]);
        $this->assertContains('embed', $user->avatar_url);
    } // end test_no_avatar

    public function test_populated_passes_through()
    {
        $url = 'https://cdn.discordapp.com/avatars/147877205949546496/486f0f3cb3361f5b00ea39a9f4475651.jpg';
        $user = factory(User::class)->create(['avatar_url' => $url]);

        $this->assertEquals($user->avatar_url, $url);
    } // end test_redirects_to_cdn
} // end UserTest
