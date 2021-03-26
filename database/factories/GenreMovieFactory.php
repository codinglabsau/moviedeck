<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GenreMovie;
use App\Models\Movie;
use App\Models\Genre;

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
            'genre_id' => rand(1, 12),
            'movie_id' => Movie::factory(),
        ];
    }
}
