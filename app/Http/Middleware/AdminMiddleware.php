<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan pengguna login dan memiliki role Admin
        if (Auth::check() && Auth::user()->role->name === 'Admin') {
            return $next($request);
        }

        // Redirect jika bukan admin
        return redirect()->route('/')->with('error', 'You do not have permission to access this page.');
    }
}
