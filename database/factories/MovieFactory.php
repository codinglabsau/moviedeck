<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'title' => $this->faker->realText(20),
            'synopsis' => $this->faker->paragraph(10),
            'year' => $this->faker->year,
            'poster' => Movie::randomPoster(),
            'banner' => Movie::randomBanner(),
            'trailer' => Movie::randomTrailer(),
            'duration' => $this->faker->numberBetween($min = 50, $max = 300),
        ];
    }
}
