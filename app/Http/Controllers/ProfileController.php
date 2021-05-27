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
        if(auth()->user()->id !== $user->id) {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }

        $user->loadCount('reviews', 'movies as watchlist_count');

        $reviews = $user->reviews()
            ->select('id', 'user_id','movie_id', 'title', 'rating', 'created_at')
            ->with(['movie:id,title,poster'])
            ->latest()
            ->take(4)
            ->get();

        $watchlist = $user->movies()
                          ->select('id', 'title', 'poster')
                          ->take(3)
                          ->get();

        return view('profile/dashboard', [
            'reviews' => $reviews,
            'watchlist' => $watchlist,
            'user' => $user
        ]);
    }

    public function reviews(User $user)
    {
        $reviews = $user->reviews()
            ->select('id', 'user_id','movie_id', 'title', 'rating', 'created_at')
            ->with(['movie:id,title,poster'])
            ->latest()
            ->paginate(8);

        return view('profile/reviews', [
            'reviews' => $reviews,
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        if(auth()->user()->id !== $user->id && !auth()->user()->is_admin) {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }

        return view('profile/edit', [
            'user' => $user
        ]);
    }

    public function update(ProfileRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect("profile/$user->id")
            ->with('message', 'You\'ve successfully updated your profile');
    }

    public function makeAdmin(User $user)
    {
        $user->update(['is_admin' => true]);

        return redirect("profile/$user->id")
            ->with('message', "$user->name is now an admin");
    }

    public function removeAdmin(User $user)
    {
        $user->update(['is_admin' => false]);

        return redirect("profile/$user->id")
            ->with('message', "$user->name has been removed as an admin");
    }
}
