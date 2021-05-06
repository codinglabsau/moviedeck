<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function dashboard(User $user)
    {
        return view('profile/dashboard')->with('user', $user);
    }
}
