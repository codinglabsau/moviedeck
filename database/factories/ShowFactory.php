<?php

namespace Database\Factories;

use App\Models\Show;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Show::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'synopsis' => $this->faker->realText(),
            'year' => $this->faker->date('Y'),
            'poster' => $this->faker->imageUrl(600, 800, "movie", true),
            'trailer' => $this->faker->url,
            'seasons' => $this->faker->numberBetween(1, 20),
        ];
    }
}
