<?php

namespace App\Models;

use Carbon\Carbon;
use RestCord\DiscordClient;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['nickname', 'email', 'discord_id', 'avatar_url', 'mfa_enabled', 'oauth_token', 'oauth_token_expires_at', 'oauth_refresh_token'];
    protected $hidden = ['remember_token', 'oauth_token', 'oauth_refresh_token'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'oauth_token_expires_at'];

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

    // @TODO add accessor/mutator for oauth_(refresh_)?token that encrypts/decrypts going into the DB.
    // May mitigate badness from a SQL injection attack, idk. Leaking that data wouldn't be too bad
    // with the current scopes, but it's not gr8.

    public function getIsTokenExpiredAttribute()
    {
        return Carbon::now() > $this->oauth_token_expires_at;
    } // end getIsTokenExpiredAttribute

    public function getDiscordApiAttribute()
    {
        return new DiscordClient(['tokenType' => 'OAuth', 'token' => $this->oauth_token]);
    } // end discord_api
} // end User
