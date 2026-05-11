<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\LaporanKegiatan; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // KUNCI HALAMAN: Siswa tidak boleh buka halaman Index Penilaian
        if ($user->isSiswa()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak! Anda tidak berhak masuk ke menu Penilaian.');
        }

        // Ambil data dengan perhitungan total_skor
        $query = Penilaian::select('*')
            ->selectRaw('(nilai_keaktifan + COALESCE(nilai_lomba, 0)) as total_skor');

        // Filter: Admin (0) liat semua, Pembina (1) liat eskulnya saja
        if ($user->isAdmin()) {
            $penilaians = $query->latest()->get();
        } else {
            $penilaians = $query->where('eskul', $user->eskul)->latest()->get();
        }

        return view('penilaian', compact('penilaians'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // KEAMANAN GANDA: Tolak jika ada Siswa yang mencoba kirim data lewat Inspect Element/Postman
        if ($user->isSiswa()) {
            return redirect()->back()->with('error', 'Akses Ilegal! Siswa dilarang menginput nilai.');
        }

        $request->validate([
            'nama_anggota'    => 'required|string|max:255',
            'total_skor'      => 'required|numeric|min:0|max:100',
            'eskul'           => $user->isAdmin() ? 'required|string' : 'nullable', 
        ]);

        $eskulFix = ($user->isAdmin()) ? $request->eskul : $user->eskul;

        Penilaian::create([
            'nama_anggota'    => $request->nama_anggota,
            'eskul'           => $eskulFix, 
            'nilai_keaktifan' => $request->total_skor,
            'nilai_lomba'     => 0,
        ]);

        return redirect()->back()->with('success', 'Data penilaian berhasil disimpan!');
    }

    public function ranking()
    {
        $user = Auth::user();

        $queryPeringkat = Penilaian::select('*')
            ->selectRaw('(nilai_keaktifan + COALESCE(nilai_lomba, 0)) as total_skor');

        // Siswa boleh masuk ke sini, tapi cuma lihat ranking eskul mereka sendiri
        if (!$user->isAdmin()) {
            $queryPeringkat->where('eskul', $user->eskul);
        }

        $peringkat = $queryPeringkat->orderByRaw('(nilai_keaktifan + COALESCE(nilai_lomba, 0)) DESC')->get();

        try {
            $rangking_eskul = LaporanKegiatan::select('nama_eskul', DB::raw('count(*) as total_laporan'))
                ->groupBy('nama_eskul')
                ->orderBy('total_laporan', 'desc')
                ->get();
        } catch (\Exception $e) {
            $rangking_eskul = collect();
        }

        return view('penilaian.rangking', compact('peringkat', 'rangking_eskul'));
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        if ($user->isSiswa()) {
            return redirect()->back()->with('error', 'Akses Ditolak!');
        }

        $penilaian = Penilaian::findOrFail($id);
        
        if ($user->isPembina() && $penilaian->eskul != $user->eskul) {
            return redirect()->back()->with('error', 'Anda dilarang menghapus nilai dari eskul lain!');
        }

        $penilaian->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}