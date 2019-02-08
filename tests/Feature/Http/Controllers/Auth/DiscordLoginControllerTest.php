<?php

namespace Tests\Feature\Controllers\Auth;

use Faker;
use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Events\DiscordLogin;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Facades\Socialite;

class DiscordLoginControllerTest extends TestCase
{
    public function test_new_user_starts_inactive()
    {
        Event::fake();

        $fake_user = $this->fakeUser();
        Socialite::shouldReceive('driver->user')->andReturn($fake_user);

        $this->get('/login/discord/callback')
            ->assertRedirect('/');

        $user = User::where('nickname', $fake_user->getNickname())->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->app_access_enabled);
    } // end test_dashboard_loads

    public function test_fires_sync_event()
    {
        Event::fakeFor(function () {
            $fake_user = $this->fakeUser();
            Socialite::shouldReceive('driver->user')->andReturn($fake_user);

            $this->get('/login/discord/callback')
                ->assertRedirect('/');

            Event::assertDispatched(DiscordLogin::class);
        });
    }

    private function fakeUser()
    {
        $faker = resolve(Faker\Generator::class);

        $user = Mockery::mock(\Laravel\Socialite\Two\User::class)
            ->shouldReceive('getId')->andReturn($faker->randomNumber(8))
            ->shouldReceive('getNickname')->andReturn($faker->unique()->discordNickname())
            ->shouldReceive('getEmail')->andReturn($faker->optional(0.9)->freeEmail())
            ->shouldReceive('getAvatar')->andReturn($faker->discordAvatar())
            ->shouldReceive('getRaw')->andReturn([
                'verified' => $faker->boolean,
                'mfa_enabled' => $faker->boolean,
            ])
            ->getMock();

        $user->token = $faker->sha256;
        $user->refreshToken = $faker->sha256;
        $user->expiresIn = 604800;

        return $user;
    }
} // end DashboardControllerTest
