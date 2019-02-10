<?php

namespace Tests\Feature\Controllers\Auth;

use Faker;
use Mockery;
use RestCord;
use Tests\TestCase;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class DiscordLoginControllerTest extends TestCase
{
    /**
     * @dataProvider guild_id_provider
     */
    public function test_user_access_grant($allowed_guild_id, $api_guild_id, $expected_value, $description)
    {
        $this->app['config']->set('movie-night.discordServer', $allowed_guild_id);

        $this->overloardRestcord($api_guild_id); // replaces getCurrentUserGuilds w/ stub
        $fake_user = $this->fakeUser();
        Socialite::shouldReceive('driver->user')->andReturn($fake_user);

        $this->get('/login/discord/callback')
            ->assertRedirect('/');

        $user = User::where('nickname', $fake_user->getNickname())->first();
        $this->assertNotNull($user);
        $this->assertEquals($expected_value, $user->app_access_enabled, $description);
    }

    public function guild_id_provider()
    {
        return [
            // config(movie-night.discordServer), ID in API response, expected app_access_enabled, description
            ['12345', '9999', false, 'Not in configured guild'],
            ['123', '123', true, 'In configured guild'],
        ];
    }

    private function overloardRestcord($id)
    {
        $guild = Mockery::mock(RestCord\Model\Guild\Guild::class);
        $guild->owner = false;
        $guild->permissions = 2146958847;
        $guild->icon = 'aaaaaa';
        $guild->id = $id;
        $guild->name = "Guild Name";

        return Mockery::mock(sprintf('overload:%s', RestCord\OverriddenGuzzleClient::class))
            ->shouldReceive('getCurrentUserGuilds')
            ->andReturn([$guild]);
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
