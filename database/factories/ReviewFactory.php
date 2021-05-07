<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'user_id' => User::all()->random()->id,
            'movie_id' => Movie::all()->random()->id,
            'title' => $this->faker->realText(30),
            'rating' => $this->faker->randomFloat(1, 0, 10),
            'content' => $this->faker->paragraph(rand(1, 30)),
        ];
    }
}
