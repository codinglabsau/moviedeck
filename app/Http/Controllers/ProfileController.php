<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use App\Models\Movie;
use App\Models\Watchlist;

class ProfileController extends Controller
{
    public function dashboard(User $user)
    {
        $reviews = Review::select('id', 'rating', 'title', 'created_at', 'movie_id', 'user_id')
            ->where('user_id', $user->id)
            ->with(['movie:id,poster,title', 'user:id,name'])
            ->orderBy('created_at')
            ->take(4)
            ->get();

        $review_count = Review::where('user_id', $user->id)
            ->count();

        //$watchlist = Movie::select('id', 'title', 'poster')
            //->watchlists()
            //->where('user_id', $user->id)
            //->orderBy('watchlists.created_at')
            //->take(4)

        $watchlist_count = Watchlist::where('user_id', $user->id)
            ->count();

        return view('profile/dashboard', [
            'user' => $user,
            'reviews' => $reviews,
            'review_count' => $review_count,
            //'watchlist' => $watchlist,
            'watchlist_count' => $watchlist_count
        ]);
    }
}
