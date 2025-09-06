<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna sudah login DAN perannya adalah admin atau staff
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'staff')) {
            // Jika ya, alihkan mereka ke dasbor admin yang seharusnya.
            return redirect()->route('admin.dashboard');
        }

        // Jika bukan (adalah pelanggan), izinkan mereka melanjutkan ke halaman yang dituju.
        return $next($request);
    }
}
