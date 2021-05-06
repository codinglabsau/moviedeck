<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;

class ProfileController extends Controller
{
    public function dashboard(User $user)
    {
        $reviews = Review::orderBy('created_at')
            ->with('movies', 'users')
            ->take(4);

        return view('profile/dashboard', [
            'user' => $user,
            'reviews' => $reviews
        ]);
    }
}
