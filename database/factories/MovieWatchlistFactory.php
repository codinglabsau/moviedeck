<?php

namespace Database\Factories;

use App\Models\MovieWatchlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieWatchlistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovieWatchlist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'movie_id' => function() {
                return Movie::factory()->create()->id;
            },
            'watchlist_id' => function() {
                return Watchlist::factory()->create()->id;
            },
        ];
    }
}
