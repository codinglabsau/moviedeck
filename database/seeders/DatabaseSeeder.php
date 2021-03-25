<?php

namespace Database\Seeders;

use App\Models;
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
        $this->call(GenreSeeder::class);
        \App\Models\User::factory(20)->create();
        \App\Models\Movie::factory(20)->create();
        \App\Models\Review::factory(20)->create();
        \App\Models\Celeb::factory(20)->create();
        \App\Models\Watchlist::factory(20)->create();
        \App\Models\MovieWatchlist::factory(20)->create();
        \App\Models\CelebMovie::factory(20)->create();
        \App\Models\GenreMovie::factory(20)->create();

    }
}
