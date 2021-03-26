<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CelebMovie;
use App\Models\Celeb;
use App\Models\Movie;

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
            'celeb_id' => Celeb::factory(),
            'movie_id' => Movie::factory(),
        ];
    }
}
