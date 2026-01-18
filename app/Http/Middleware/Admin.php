<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/login');    // belum login
        }

        if (auth()->user()->is_admin != 1) {
            return redirect()->route('dashboard');  // USER diarahkan ke dashboard user
        }

        return $next($request);
    }
}
