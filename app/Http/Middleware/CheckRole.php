<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role == 'guru' && Auth::user()->role == 'guru') {
            return $next($request);
        } elseif ($role == 'siswa' && Auth::user()->role == 'siswa') {
            return $next($request);
        }

        return redirect('/dashboard');
    }
}