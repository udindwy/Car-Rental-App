<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  string  ...$roles → daftar role yang boleh masuk
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika belum login atau role tidak ada dalam daftar, tolak akses
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            abort(403, 'AKSI INI TIDAK DIIZINKAN.');
        }

        return $next($request);
    }
}
