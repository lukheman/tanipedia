<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MultiAuth
{
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::shouldUse($guard); // pakai guard yg sedang login

                return $next($request);
            }
        }

        return redirect()->route('login'); // jika semua gagal
    }
}
