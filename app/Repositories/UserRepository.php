<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function findOrCreate($nickname, $profile)
    {
        return DB::transaction(function () use ($nickname, $profile) {
            $user = User::updateOrCreate(['nickname' => $nickname], [
                'email' => $profile['email'],
                'discord_id' => $profile['discord_id'],
                'avatar_url' => $profile['avatar_url'],
                'mfa_enabled' => $profile['mfa_enabled'],
                'oauth_token' => $profile['oauth_token'],
                'oauth_token_expires_at' => $profile['oauth_token_expires_at'],
                'oauth_refresh_token' => $profile['oauth_refresh_token'],
            ]);

            return $user;
        });
    } // end findOrCreate
} // end UserRepository
