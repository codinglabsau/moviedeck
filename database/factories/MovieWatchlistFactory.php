<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Watchlist;
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
            'movie_id' => Movie::all()->random()->id,
            'watchlist_id' => Watchlist::all()->random()->id,
        ];
    }
}
