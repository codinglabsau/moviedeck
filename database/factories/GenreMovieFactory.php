<?php

namespace Database\Factories;

use App\Models\GenreMovie;
use App\Models\Genre;
use App\Models\Movie;
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
            'genre_id' => function() {
                return Genre::factory()->create()->id;
            },
            'movie_id' => function() {
                return Movie::factory()->create()->id;
            },
        ];
    }
}
