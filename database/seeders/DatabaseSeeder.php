<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(20)->create();
        \App\Models\Celeb::factory(20)->create();
//        \App\Models\Genre_Movie::factory(20)->create();
//        \App\Models\Genre_Show::factory(20)->create();
//        \App\Models\Celeb_Show::factory(20)->create();
        $this->call(GenreSeeder::class);
    }
}
