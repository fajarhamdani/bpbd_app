<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Pastikan Auth diimpor

class AdminOnly
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek jika pengguna sudah login dan role_id adalah 1 (admin)
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        // Jika bukan admin, redirect ke halaman dengan pesan error
        return redirect()->route('home')->with('error', 'You do not have admin access.');
    }
}
