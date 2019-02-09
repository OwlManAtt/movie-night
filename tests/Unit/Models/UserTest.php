<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserTest extends TestCase
{
    public function test_no_avatar()
    {
        $user = factory(User::class)->create(['avatar_url' => null]);
        $this->assertContains('embed', $user->avatar_url);
    } // end test_no_avatar

    public function test_populated_passes_through()
    {
        $url = 'https://cdn.discordapp.com/avatars/147877205949546496/486f0f3cb3361f5b00ea39a9f4475651.jpg';
        $user = factory(User::class)->create(['avatar_url' => $url]);

        $this->assertEquals($user->avatar_url, $url);
    } // end test_redirects_to_cdn

    /**
     * @dataProvider encrypted_fields
     */
    public function test_oauth_token_encrypted_at_rest($attribute)
    {
        $user = factory(User::class)->create();

        $plaintext = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
        $user->$attribute = $plaintext;
        $user->save();

        $raw_row = DB::table('users')->where('id', $user->id)->first();
        $this->assertNotEquals($plaintext, $raw_row->$attribute, 'Raw DB value is not encrypted');

        $user = User::find($user->id);
        $this->assertEquals($plaintext, $user->$attribute, 'Model accessor is not decrypted');
    }

    public function encrypted_fields()
    {
        return [
            ['oauth_token'],
            ['oauth_refresh_token'],
        ];
    }
} // end UserTest
