<?php

namespace Database\Factories;

use App\Models\Genre_Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreMovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genre_Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'genre_id' => numberBetween(1, 20),
            'movie_id' => numberBetween(1, 20),
        ];
    }
}
