<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if(auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        return redirect('/');

    }
}
