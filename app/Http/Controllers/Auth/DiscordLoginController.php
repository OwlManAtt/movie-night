<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Socialite;
use App\Repositories\UserRepository;

class DiscordLoginController
{
    public function redirectToProvider()
    {
        return $this->driver()->redirect();
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
        ]);
        Auth::login($user, true);

        return redirect('/');
    } // end handleProviderCallback

    protected function driver()
    {
        return Socialite::driver('discord');
    } // end driver

} // end DiscordLoginController
