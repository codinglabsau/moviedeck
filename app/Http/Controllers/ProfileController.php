<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;

class ProfileController extends Controller
{
    public function dashboard(User $user)
    {
        $reviews = Review::where('user_id', $user->id)
            ->with(['movie', 'user'])
            ->orderBy('created_at')
            ->take(4)
            ->get();

        return view('profile/dashboard', [
            'user' => $user,
            'reviews' => $reviews
        ]);
    }
}
