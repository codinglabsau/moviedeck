<?php

namespace Database\Factories;

use App\Models\Celeb_Show;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CelebShowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Celeb_Show::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'celeb_id' => numberBetween(1, 20),
            'show_id' => numberBetween(1, 20),
        ];
    }
}
