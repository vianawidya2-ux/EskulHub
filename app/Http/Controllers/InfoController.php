<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    // Fungsi untuk Pembina membuat pengumuman baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
        ]);

        // Simpan ke tabel informations (pastikan nanti buat migrationnya ya)
        DB::table('informations')->insert([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'penerbit' => auth()->user()->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Informasi berhasil dipublikasikan!');
    }
} 