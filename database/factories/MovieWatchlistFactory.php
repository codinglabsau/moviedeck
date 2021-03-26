<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MovieWatchlist;
use App\Models\Watchlist;
use App\Models\Movie;

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
            'movie_id' => Movie::factory(),
            'watchlist_id' => Watchlist::factory(),
        ];
    }
}
