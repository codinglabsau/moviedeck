<?php

namespace Database\Factories;

use App\Models\Celeb;
use App\Models\Movie;
use App\Models\CelebMovie;
use Illuminate\Database\Eloquent\Factories\Factory;

class CelebMovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CelebMovie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'celeb_id' => Celeb::all()->random()->id,
            'movie_id' => Movie::all()->random()->id,
        ];
    }
}
