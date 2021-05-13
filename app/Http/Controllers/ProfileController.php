<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Movie;
use App\Models\Review;
use App\Models\MovieUser;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function dashboard(User $user)
    {
        $reviews = Review::select('id', 'rating', 'title', 'created_at', 'movie_id', 'user_id')
            ->where('user_id', $user->id)
            ->with(['movie:id,title,poster', 'user:id,name'])
            ->orderBy('created_at')
            ->take(4)
            ->get();

        $review_count = Review::where('user_id', $user->id)
            ->count();

        $watchlist = $user->movies()
                          ->select('id', 'title', 'poster')
                          ->take(3)
                          ->get();

        $watchlist_count = MovieUser::where('user_id', $user->id)
            ->count();

        return view('profile/dashboard', [
            'user' => $user,
            'reviews' => $reviews,
            'review_count' => $review_count,
            'watchlist' => $watchlist,
            'watchlist_count' => $watchlist_count
        ]);
    }

    public function reviews(User $user)
    {
        $reviews = Review::select('id', 'rating', 'title', 'created_at', 'movie_id', 'user_id')
            ->where('user_id', $user->id)
            ->with(['movie:id,title,poster', 'user:id,name'])
            ->paginate(8);

        $review_count = Review::where('user_id', $user->id)
            ->count();

        return view('profile/reviews', [
            'reviews' => $reviews,
            'review_count' => $review_count,
            'user' => $user
        ]);
    }

    public function watchlist(User $user)
    {
        if(auth()->user()->id == $user->id) {
            $watchlist = $user->movies()
                ->select('id', 'title', 'poster')
                ->orderBy('created_at')
                ->paginate(15);

            return view('profile/watchlist',[
                'watchlist' => $watchlist,
                'user' => $user
            ]);
        } else {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }
    }

    public function watchlistSearch(User $user)
    {
        return view('profile/watchlist_search', [
            'user' => $user
        ]);
    }

    public function watchlistCreate(ProfileRequest $request, User $user)
    {
        $validated = implode($request->validated());

        $output = Movie::select('id', 'title', 'poster')
            ->where('title', 'like', '%'.$validated.'%')
            ->paginate(10);

        return view('profile/watchlist_create',[
            'validated' => $validated,
            'output' => $output,
            'user' => $user
        ]);
    }

    public function watchlistStore(User $user, Movie $movie)
    {
        MovieUser::create([
            'user_id' => $user->id,
            'movie_id' => $movie->id
        ]);

        return redirect("profile/$user->id/watchlist")
            ->with('message', 'Movie successfully added to your watchlist');
    }
}
