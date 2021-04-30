<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\User;

class ProfileController extends Controller
{
    public function dashboard()
    {
        return view('profile/dashboard');
    }
}
