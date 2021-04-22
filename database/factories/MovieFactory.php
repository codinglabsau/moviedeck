<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {
        return [
            'title' => $this->faker->realText(20),
            'synopsis' => $this->faker->paragraph(rand(10, 20)),
            'year' => $this->faker->year,
            'poster' => Movie::randomPoster(),
            'banner' => Movie::randomBanner(),
            'trailer' => Movie::randomTrailer(),
            'duration' => $this->faker->numberBetween($min = 50, $max = 300),
        ];
    }
}
