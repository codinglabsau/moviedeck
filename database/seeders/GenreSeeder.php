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
        $categories = [
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

        foreach($categories as $category) {
            DB::table('genres')->insert([
                'name' => $category
             ]);
        }
    }
}
