<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['nickname', 'email', 'discord_id', 'avatar_url', 'mfa_enabled'];

    protected $hidden = ['remember_token'];

    public function getAvatarUrlAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        // Default avatar URLs are the #1234 part of the name modulus 5 (e.g. 1234 % 5).
        // See <https://discordapp.com/developers/docs/reference#image-formatting>
        $discriminator = substr($this->nickname, strpos($this->nickname, '#') + 1) ?: '0000';
        return sprintf('https://cdn.discordapp.com/embed/avatars/%s.png', ($discriminator % 5));
    } // end getAvatarUrlAttribute

} // end User
