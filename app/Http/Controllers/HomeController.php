<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App;


class HomeController extends Controller
{
    public function index(){
        $top_rated= Review::with(['movie.genres'])
                            ->selectRaw('AVG(rating) as average_rating, movie_id')
                            ->groupBy('movie_id')
                            ->orderByDesc('average_rating')
                            ->first();
        $movies = App\Models\Movie::all();
        return view('home')->with('movies', $movies)->with('top_rated', $top_rated);
    }
}
