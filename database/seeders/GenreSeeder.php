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
            "Action",
            "Anime",
            "Adventure",
            "Comedy",
            "Classic",
            "Crime",
            "Drama",
            "Fantasy",
            "Horror",
            "Mystery",
            "Romance",
            "Thriller"
        ];

        foreach($genres as $genre) {
            DB::table('genres')->insert([
                'name' => $genre
             ]);
        }
    }
}
