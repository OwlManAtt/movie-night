<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Event;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Disable model events during seeding
        Event::fake();

        $this->call(MediaSeeder::class);
        $this->call(UserSeeder::class);
    } // end run
} // end DatabaseSeeder
