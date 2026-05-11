<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|int  $role (1 untuk Pembina, 2 untuk Anggota)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login. Jika belum, lempar ke halaman login.
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil role user dari database (auth()->user()->role)
        // Bandingkan dengan $role yang dikirim dari routes/web.php
        if (Auth::user()->role != $role) {
            
            // Jika role tidak cocok, kembalikan ke dashboard dengan pesan peringatan
            return redirect('/dashboard')->with('error', 'Akses ditolak! Halaman ini khusus untuk Pembina.');
        }

        // 3. Jika sudah login dan role cocok, izinkan akses ke halaman tujuan
        return $next($request);
    }
}