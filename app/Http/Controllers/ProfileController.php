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
            ->latest()
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

    public function edit(User $user)
    {
        return view('profile/edit', [
            'user' => $user
        ]);
    }

    public function update(ProfileRequest $request, User $user)
    {
        if(auth()->user()->id == $user->id || auth()->user()->is_admin) {
            $user->update($request->validated());

            return redirect("profile/$user->id")
                ->with('message', 'You\'ve successfully updated your profile');
        } else {
            return redirect('/')
                ->with('message', 'You don\'t have access to that page');
        }
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
