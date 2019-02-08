<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Socialite;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Events;

class DiscordLoginController extends Controller
{
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

        return redirect('/');
    } // end handleProviderCallback

    private function driver()
    {
        return Socialite::driver('discord');
    } // end driver
} // end DiscordLoginController
