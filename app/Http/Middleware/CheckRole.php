<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            // Jika pengguna tidak terotentikasi, arahkan ke halaman login
            return redirect('/login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        $user = Auth::user();
        if ($user->role == $role) {
            // Jika peran pengguna sesuai, izinkan permintaan selanjutnya
            return $next($request);
        }

        // Jika peran pengguna tidak sesuai, arahkan ke dashboard dengan pesan kesalahan
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
