<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['nickname', 'email', 'discord_id', 'avatar_url', 'mfa_enabled'];

    protected $hidden = ['remember_token'];

} // end User
