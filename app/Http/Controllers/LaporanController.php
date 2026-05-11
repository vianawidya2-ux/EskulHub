<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKegiatan;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggal = $request->input('tanggal');

        // Eager loading user
        $query = LaporanKegiatan::with('user');

        // Filter otomatis sesuai eskul pembina/siswa
        if (Auth::user()->role != 0) {
            $query->where('nama_eskul', Auth::user()->eskul);
        }

        if ($search) {
            $query->where('nama_eskul', 'LIKE', "%{$search}%");
        }

        if ($tanggal) {
            $query->whereDate('tanggal_kegiatan', $tanggal);
        }

        $semua_laporan = $query->latest()->get();

        return view('laporan', compact('semua_laporan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_eskul' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'deskripsi' => 'required|string', // Sesuai nama kolom di HeidiSQL kamu
            'jumlah_hadir' => 'required|numeric|min:0',
            'jumlah_izin' => 'required|numeric|min:0',
        ]);

        LaporanKegiatan::create([
            'user_id' => Auth::id(),
            'nama_eskul' => $request->nama_eskul,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'deskripsi' => $request->deskripsi, // Sesuai kolom DB
            'jumlah_hadir' => $request->jumlah_hadir,
            'jumlah_izin' => $request->jumlah_izin,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil disimpan!');
    }

    public function edit($id)
    {
        $laporan = LaporanKegiatan::findOrFail($id);
        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama_eskul' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'deskripsi' => 'required|string', // Sesuaikan kolom DB
            'jumlah_hadir' => 'required|numeric',
            'jumlah_izin' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $laporan = LaporanKegiatan::findOrFail($id);

        // Update secara manual agar tidak error jika ada kolom yang tidak ada di DB
        $laporan->update([
            'nama_eskul' => $request->nama_eskul,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'deskripsi' => $request->deskripsi,
            'jumlah_hadir' => $request->jumlah_hadir,
            'jumlah_izin' => $request->jumlah_izin,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $laporan = LaporanKegiatan::find($id);

        if ($laporan) {
            $laporan->delete();
            return redirect()->back()->with('success', 'Laporan berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Laporan gagal dihapus.');
    }
}