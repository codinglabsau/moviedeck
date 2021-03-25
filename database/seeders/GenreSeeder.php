<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [
            Genre::GENRE_ACTION,
            Genre::GENRE_ANIME,
            Genre::GENRE_ADVENTURE,
            Genre::GENRE_COMEDY,
            Genre::GENRE_CRIME,
            Genre::GENRE_DRAMA,
            Genre::GENRE_FANTASY,
            Genre::GENRE_HORROR,
            Genre::GENRE_MYSTERY,
            Genre::GENRE_ROMANCE,
            Genre::GENRE_THRILLER
        ];

        foreach($genres as $genre) {
            Genre::factory()->create([
                'name' => $genre
            ]);
        }
    }
}
