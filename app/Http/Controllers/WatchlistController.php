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
        if(auth()->user()->id == $user->id) {
            $watchlist = $user->movies()
                ->select('id', 'title', 'poster')
                ->orderByDesc('movie_user.created_at')
                ->paginate(15);

            return view('watchlist/index',[
                'watchlist' => $watchlist,
                'user' => $user
            ]);
        } else {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }
    }

    public function create(User $user)
    {
        if(auth()->user()->id == $user->id) {
            return redirect('search')
                ->with('user', $user);
        } else {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }
    }

    public function store(Request $request, User $user)
    {
        if(auth()->user()->id == $user->id) {
            if ($user->movies()->where('id',$request->input('movie_id'))->exists()) {
                return redirect("profile/$user->id/watchlist")
                    ->with('message', 'Movie not added, already on your watchlist');
            } else {
                $user->movies()
                    ->syncWithoutDetaching([$request->input('movie_id')]);

                return redirect("profile/$user->id/watchlist")
                    ->with('message', 'Movie successfully added to your watchlist');
            }
        } else {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }
    }

    public function showMovie(User $user, Movie $movie)
    {
        return redirect("movies/$movie->id");
    }

    public function destroy(User $user, Movie $movie)
    {
        if(auth()->user()->id == $user->id) {
            $user->movies()->detach($movie->id);

            return redirect("profile/$user->id/watchlist");
        } else {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }
    }
}
