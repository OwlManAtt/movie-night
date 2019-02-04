<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function findOrCreate($nickname, $profile)
    {
        $user = User::updateOrCreate(['nickname' => $nickname], [
            'email' => $profile['email'],
            'discord_id' => $profile['discord_id'],
            'avatar_url' => $profile['avatar_url'],
            'mfa_enabled' => $profile['mfa_enabled'],
        ]);

        return $user;
    } // end findOrCreate
} // end UserRepository
