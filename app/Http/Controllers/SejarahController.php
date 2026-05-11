<?php

namespace App\Http\Controllers;

use App\Models\Sejarah; // Pastikan Model Sejarah sudah di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SejarahController extends Controller
{
    /**
     * Menampilkan halaman sejarah eskul sesuai user yang login.
     */
    public function index()
    {
        // 1. Ambil data user yang sedang login
        $user = Auth::user();

        // 2. Cari data sejarah yang nama_eskul-nya SAMA dengan eskul di profil user
        // Menggunakan first() karena kita hanya butuh satu data sejarah saja
        $sejarah = Sejarah::where('nama_eskul', $user->eskul)->first();

        // 3. Kirim data sejarah ke view 'sejarah.blade.php'
        return view('sejarah', compact('sejarah'));
    }
}