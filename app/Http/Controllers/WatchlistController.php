<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\MovieUser;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index(User $user)
    {
        if(auth()->user()->id !== $user->id) {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }

        $watchlist = $user->movies()
            ->select('id', 'title', 'poster')
            ->orderByDesc('movie_user.created_at')
            ->paginate(15);

        return view('watchlist/index',[
            'watchlist' => $watchlist,
            'user' => $user
        ]);
    }

    public function create(Request $request, User $user)
    {
        if(auth()->user()->id !== $user->id) {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }

        return redirect('search')
            ->with('user', $user);
    }

    public function store(Request $request, User $user)
    {
        if(auth()->user()->id !== $user->id) {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }

        if ($user->movies()->where('id',$request->input('movie_id'))->exists()) {
            return redirect("profile/$user->id/watchlist")
                ->with('message', 'Movie not added, already on your watchlist');
        }

        $user->movies()
            ->syncWithoutDetaching([$request->input('movie_id')]);

        return redirect("profile/$user->id/watchlist")
            ->with('message', 'Movie successfully added to your watchlist');

    }

    public function showMovie(User $user, Movie $movie)
    {
        return redirect("movies/$movie->id");
    }

    public function destroy(User $user, Movie $movie)
    {
        if(auth()->user()->id !== $user->id) {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }

        $user->movies()->detach($movie->id);

        return redirect("profile/$user->id/watchlist");
    }
}
