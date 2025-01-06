<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id === 1) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses.');
    }
}
