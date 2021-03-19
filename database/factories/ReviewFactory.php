<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use App;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        return [
            /**'user_id' => function() {
                return User::factory()->create()->id;
            },
            'movie_id' => function() {
                return Movie::factory()->create()->id;
            },
            'title' => $this->faker->word,
            'rating' => $this->faker->randomFloat(1, 0, 10), */
        ];
    }
}
