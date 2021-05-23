<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Movie;
use App\Models\MovieUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovieUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'movie_id' => Movie::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
