<?php

namespace App\Http\Middleware;

use Closure;
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
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        if ($role === 'admin' && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses admin.');
        }

        if ($role === 'kasir' && !$user->isKasir() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses kasir.');
        }

        return $next($request);
    }
}