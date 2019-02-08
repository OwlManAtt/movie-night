<?php

namespace App\Events;

use Illuminate\Auth\Events\Login;

/**
 * For testing purposes.
 *
 * Event::fake() changes the dispatcher after the SessionGuard is set up,
 * so its already gotten the real event dispatcher injected into it.
 */
class DiscordLogin extends Login
{
    //
}
