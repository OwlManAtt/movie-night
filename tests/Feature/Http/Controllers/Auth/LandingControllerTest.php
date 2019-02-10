<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;

class LanidngControllerTest extends TestCase
{
    public function test_redirects_good_users()
    {
        $this->actingAs($this->user)->get('/login')->assertRedirect('/');
    }

    public function test_shows_login_when_no_cookie()
    {
        $this->get('/login')
            ->assertOk()
            ->assertViewIs('landing.guest');
    }

    public function test_shows_unauthorized()
    {
        $user = factory(User::class)->create(['app_access_enabled' => false]);

        $this->actingAs($user)->get('/login')
            ->assertForbidden()
            ->assertViewIs('landing.not-authorized');
    }
}
