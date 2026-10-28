<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    /**
     * Menyeleksi apakah pengguna yang masuk memiliki hak akses Admin
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika pengguna sudah login dan rolenya adalah admin, izinkan masuk
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin (kasir), tolak akses secara paksa dengan kode 403
        abort(403, 'Akses Ditolak! Halaman manajemen ini dilindungi dan hanya dapat dibuka oleh Admin atau Owner Restoran.');
    }
}