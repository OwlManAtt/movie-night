<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use Carbon\Carbon;
use RestCord\Model\Guild\Guild;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class DiscordLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectToProvider()
    {
        return $this->driver()->scopes(['identify', 'email', 'guilds'])->redirect();
    } // end redirectToProvider

    public function handleProviderCallback(UserRepository $repo)
    {
        $discord_profile = $this->driver()->user();
        $expanded = $discord_profile->getRaw();

        $user = $repo->findOrCreate($discord_profile->getNickname(), [
            'discord_id' => $discord_profile->getId(),
            'email' => $discord_profile->getEmail(),
            'avatar_url' => $discord_profile->getAvatar(),
            'verified' => $expanded['verified'],
            'mfa_enabled' => $expanded['mfa_enabled'],
            'oauth_token' => $discord_profile->token,
            'oauth_token_expires_at' => Carbon::now()->addSeconds($discord_profile->expiresIn),
            'oauth_refresh_token' => $discord_profile->refreshToken,
        ]);

        Auth::login($user, true);

        $this->checkForAuthorizedGuild($user);

        return redirect('/');
    } // end handleProviderCallback

    /**
     * Flip app_access_enabled flag on user when appropriate
     *
     * @TODO: once we have a discord bot, spin this out into an event.
     * Guild details can be unavailable if that region is down, but this basic info
     * should always be available.
     *
     * The eventual goal is to get the roles for the server the bot is in & assign
     * app permissions based on those, but that's for the future!
     */
    private function checkForAuthorizedGuild($user)
    {
        $api = $user->discord_api;

        $guilds = collect($api->user->getCurrentUserGuilds())->filter(function (Guild $guild) {
            return $guild->id == config('movie-night.discordServer');
        });

        $active = $guilds->count() > 0;

        $user->app_access_enabled = $active;
        $user->save();

        return $user;
    }

    private function driver()
    {
        return Socialite::driver('discord');
    } // end driver
} // end DiscordLoginController
