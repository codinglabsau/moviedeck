<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\GenreMovie;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreMovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GenreMovie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'movie_id' => Movie::all()->random()->id,
            'genre_id' => Genre::all()->random()->id,
        ];
    }
}
