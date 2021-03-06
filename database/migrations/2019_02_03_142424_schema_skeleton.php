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

            $table->string('title');
            $table->string('imdb_id');

            $table->datetime('imdb_last_synced_at')->nullable();
            $table->double('imdb_rating', 4, 1)->nullable();
            $table->integer('year_released')->nullable();
            $table->string('runtime')->nullable();
            $table->text('poster_url')->nullable();
            $table->text('plot_summary')->nullable();

            $table->morphs('content');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_count')->nullable();
            $table->integer('episode_count')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('series_episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('series_id')->index();
            $table->integer('season')->nullable();
            $table->string('episode')->nullable();
            $table->integer('episode_order')->nullable();

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
