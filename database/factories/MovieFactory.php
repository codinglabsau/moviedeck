<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;


class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'synopsis' => $this->faker->paragraph,
            'year' => $this->faker->year,
            'poster' => $this->faker->imageUrl(600, 700, "poster", true),
            'trailer' => $this->faker->url,
            'duration' => $this->faker->numberBetween($min = 50, $max = 300),
        ];
    }
}
