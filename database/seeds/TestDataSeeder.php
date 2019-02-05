<?php

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        $this->call(MediaSeeder::class);
        $this->call(UserSeeder::class);
    } // end run

} // end DatabaseSeeder
