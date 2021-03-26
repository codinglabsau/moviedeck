<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\Movie;
use App\Models\User;

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
            'user_id' => User::factory(),
            'movie_id' => Movie::factory(),
            'title' => $this->faker->word,
            'rating' => $this->faker->randomFloat(1, 0, 10),
            'content' => $this->faker->paragraph,
        ];
    }
}
