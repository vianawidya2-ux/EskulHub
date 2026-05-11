<?php

namespace App\Http\Controllers;

use App\Models\Eskul;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EskulController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 1. Ambil daftar eskul sesuai hak akses (PERBAIKAN)
        if ($user->role == 0) { 
            // Admin bisa melihat semua list eskul
            $eskuls = Eskul::all();
        } elseif ($user->role == 1) { 
            // Pembina hanya melihat eskul yang dia bina berdasarkan id_pembina
            $eskuls = Eskul::where('id_pembina', $user->id)->get(); 
        } else { 
            // Siswa HANYA melihat eskul yang dia ikuti saja
            $eskuls = Eskul::where('nama_eskul', $user->eskul)->get();
        }

        foreach ($eskuls as $e) {
            $namaEskul = trim($e->nama_eskul);

            // 2. Cari Anggota (Siswa) yang eskulnya sama dengan baris ini
            $anggotaEskul = User::where('role', 2)
                                ->where('eskul', $namaEskul)
                                ->get();

            // 3. CARI PEMBINA
            // Cari user yang ID-nya sama dengan id_pembina di tabel eskul
            $pembina = User::where('id', $e->id_pembina)->first();

            // Cadangan: jika ID tidak cocok, cari berdasarkan role & nama eskul
            if (!$pembina) {
                $pembina = User::where('role', 1)
                               ->where('eskul', $namaEskul)
                               ->first();
            }

            // Set data tambahan untuk dikirim ke View
            $e->nama_pembina = $pembina ? $pembina->name : 'Belum Ditentukan';
            $e->jumlah_anggota = $anggotaEskul->count();

            // 4. Hitung Keaktifan (21 hari terakhir)
            $idAnggotas = $anggotaEskul->pluck('id');
            $jumlahAktif = 0;
            
            if ($idAnggotas->isNotEmpty()) {
                $jumlahAktif = DB::table('absensis')
                    ->whereIn('user_id', $idAnggotas)
                    ->where('created_at', '>=', Carbon::now()->subDays(21))
                    ->distinct('user_id')
                    ->count();
            }

            $e->jumlah_aktif = $jumlahAktif;
            $e->status_keaktifan = ($jumlahAktif > 0) ? 'Aktif' : 'Tidak Aktif';
        }

        return view('data-eskul', compact('eskuls'));
    }
}
