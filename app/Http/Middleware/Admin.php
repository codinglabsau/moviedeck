<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {

        if(Auth::check() && Auth::user()->is_admin === true) {
            return $next($request);
        }

        abort(403, 'Access denied');

    }
}
