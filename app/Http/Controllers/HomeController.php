<?php

namespace App\Http\Controllers;

use App\Models\Celeb;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App;


class HomeController extends Controller
{
    public function index(){
        $rated= Review::with(['movie.genres'])
                            ->selectRaw('ROUND(AVG(rating),1) as average_rating, movie_id')
                            ->groupBy('movie_id')
                            ->take(4)
                            ->get();
        $celebs= Celeb::take(4)
                        ->get();
        return view('home')->with('rated', $rated)->with('celebs', $celebs);
    }
}
