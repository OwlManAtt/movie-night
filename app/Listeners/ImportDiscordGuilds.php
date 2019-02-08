<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use RestCord\Model\Guild\Guild;
use App\Repositories\UserRepository;

class ImportDiscordGuilds
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function handle(Login $event)
    {
        $api = $event->user->discord_api;

        $guilds = collect($api->user->getCurrentUserGuilds())->filter(function (Guild $guild) {
            return $guild->id == config('movie-night.discordServer');
        });

        /*
        * @TODO once we have a bot set up, load the roles for a user & store them.
        *
        * That's why this is an event -- guilds can be unavailable if that region is down :-)

        * - Check unavailable == true & throw exception (for retry)
        * - Otherwise persist group data (via repo)
        */

        $active = $guilds->count() > 0;

        $event->user->app_access_enabled = $active;
        $event->user->save();
    }
}
