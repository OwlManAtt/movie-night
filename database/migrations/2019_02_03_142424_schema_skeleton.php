<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SchemaSkeleton extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('starts_at');
            $table->datetime('ends_at');
            $table->morphs('content');
            $table->integer('event_recurrence_rule_id')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('event_recurrence_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->text('ical_recurrence_rule');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('content');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('series_episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('series_id')->index();
            $table->string('title');

            $table->timestamps();
            $table->softDeletes();
        });
    } // end up

    public function down()
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_recurrence_rules');
        Schema::dropIfExists('media');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('series_episodes');
    } // end down

} // end SchemaSkeleton
