<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname')->unique();
            $table->string('email')->nullable();
            $table->text('avatar_url')->nullable();
            $table->string('discord_id');
            $table->boolean('mfa_enabled');

            $table->string('oauth_token')->nullable();
            $table->datetime('oauth_token_expires_at')->nullable();
            $table->string('oauth_refresh_token')->nullable();

            $table->boolean('app_access_enabled')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
