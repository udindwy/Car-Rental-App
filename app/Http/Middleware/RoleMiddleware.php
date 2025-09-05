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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Periksa apakah pengguna sudah login dan apakah perannya ada di dalam daftar yang diizinkan.
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            // Jika tidak, tolak akses dengan halaman 403 (Forbidden).
            abort(403, 'AKSI INI TIDAK DIIZINKAN.');
        }

        // Jika diizinkan, lanjutkan ke halaman yang dituju.
        return $next($request);
    }
}
