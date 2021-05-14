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

    public function create(Request $request, User $user)
    {
        $keyword = $request->input('search');

        $movies = Movie::query()
            ->select('id', 'title', 'poster')
            ->when($keyword, function ($q) use ($keyword){
                $q->where('title', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('title')
            ->paginate(10);


        return view('watchlist/create', [
            'keyword' => $request->input('title'),
            'movies' => $movies,
            'user' => $user
        ]);
    }

    public function store(Request $request, User $user, Movie $movie)
    {
        if ($user->movies()->where('id',$movie->id)->exists()) {
            return redirect("profile/$user->id/watchlist")
                ->with('message', 'Movie not added, already on your watchlist');
        } else {
            $user->movies()
                 ->syncWithoutDetaching([$request->input('movie_id')]);

            return redirect("profile/$user->id/watchlist")
                ->with('message', 'Movie successfully added to your watchlist');
        }
    }

    public function destroy(User $user, Movie $movie)
    {
        $user->movies()->detach($movie->id);

        return redirect("profile/$user->id/watchlist");
    }
}
