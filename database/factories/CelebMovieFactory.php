<?php

namespace Database\Factories;

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
            'celeb_id' => function() {
                return Celeb::factory()->create()->id;
            },
            'movie_id' => function() {
                return Movie::factory()->create()->id;
            }
        ];
    }
}
