<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Memeriksa apakah pengguna login dan memiliki salah satu peran yang diizinkan.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        // Belum login: arahkan ke halaman login
        if (!$user) {
            return redirect()->route('login');
        }

        // Peran tidak sesuai: kembalikan ke beranda dengan pesan peringatan
        if (!in_array($user->role, $roles)) {
            return redirect()->route('home')
                ->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }

        return $next($request);
    }
}
