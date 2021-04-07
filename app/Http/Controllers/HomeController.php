<?php

namespace App\Http\Controllers;

use App\Models\Celeb;
use App\Models\Movie;
use App;

class HomeController extends Controller
{
    public function index(){
        $movies = Movie::with(['reviews', 'genres'])
            ->take(4)
            ->get()
            ->map(function ($movie) {
                $movie->average_rating = round($movie->reviews->average('rating'),1);
                return $movie;
            })
            ->sortByDesc('average_rating');
        $celebs= Celeb::take(4)
                        ->get();
        return view('home', ['movies'=> $movies], ['celebs' => $celebs]);
    }
}
