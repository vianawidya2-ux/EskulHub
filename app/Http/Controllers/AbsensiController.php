<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Daftar eskul manual (biar gak perlu bikin tabel Eskul lagi di DB)
        $list_eskul = ['Pramuka', 'Paskibra', 'PMR', 'Badminton', 'Rohis', 'Futsal', 'Bahasa Jepang', 'Paduan Suara', 
        'Tari', 'Dance', 'Pencak Silat'];

        // LOGIKA FILTER:
        if ($user->role == 0) {
            // Admin (0) bisa lihat semua data
            $absensi = Absensi::latest()->get();
        } else {
            // Pembina/Siswa melihat data berdasarkan eskul yang ada di PROFIL mereka
            // Catatan: Jika di profil masih '-', mereka tidak akan melihat history apa-apa
            $absensi = Absensi::where('unit_eskul', $user->eskul)->latest()->get();
        }

        return view('absensi', compact('absensi', 'list_eskul'));
    }

    public function simpanAbsensi(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi: 'unit_eskul' harus sesuai dengan nama 'name' di tag <select> blade kamu
        $request->validate([
            'unit_eskul'  => 'required|string', 
            'status'      => 'required|in:Hadir,Sakit,Izin,Alfa',
            'keterangan'  => 'nullable|string',
        ]);

        // 2. Simpan Data ke Database
        Absensi::create([
            'user_id'     => $user->id,
            'nama_manual' => $user->name,
            'eskul'       => $request->unit_eskul, // Ini mengambil dari dropdown
            'status'      => $request->status,
            'tanggal'     => now()->format('Y-m-d'),
            'keterangan'  => $request->keterangan ?? '-',
        ]);

        return redirect()->route('absensi.index')->with('success', 'Presensi berhasil disimpan ke unit ' . $request->unit_eskul);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        if ($user->role == 2) {
            return redirect()->back()->with('error', 'Akses ditolak!');
        }

        Absensi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}