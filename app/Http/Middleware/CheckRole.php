<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah pengguna yang sedang login memiliki peran yang sesuai
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request);
        }

        // Redirect ke halaman sebelumnya atau ke halaman lain jika peran tidak sesuai
        return redirect('/')->with('error', 'You do not have permission to access this page.');
    }
}
