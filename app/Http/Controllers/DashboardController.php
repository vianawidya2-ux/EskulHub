<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanKegiatan;
use App\Models\User; 
use App\Models\Absensi; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $roleUser = (int) $user->role;
        $userEskul = $user->eskul;

        // 1. Data Master
        $labelsEskul = ['Pramuka', 'Futsal', 'PMR', 'Paskibra', 'Bahasa Jepang', 'Rohis', 'Paduan Suara', 'Tari', 'Dance', 'Badminton', 'Pencak Silat'];

        // 2. Statistik
        $totalSiswa = User::where('role', 2)->count();
        
        $totalAnggotaUnit = User::where('role', 2)
            ->when($roleUser === 1, function($q) use ($userEskul) {
                return $q->where('eskul', $userEskul);
            })->count();

        // 3. Hitung Persentase (Agar tidak error di Blade)
        $persentase = $totalSiswa > 0 ? round(($totalAnggotaUnit / $totalSiswa) * 100) : 0;

        // 4. Grafik Analisis Partisipasi
        $dataX = []; $dataXI = []; $dataXII = [];
        foreach ($labelsEskul as $eskulName) {
            $dataX[]   = User::where('role', 2)->where('eskul', $eskulName)->where('kelas', 'LIKE', 'X %')->count();
            $dataXI[]  = User::where('role', 2)->where('eskul', $eskulName)->where('kelas', 'LIKE', 'XI %')->count();
            $dataXII[] = User::where('role', 2)->where('eskul', $eskulName)->where('kelas', 'LIKE', 'XII %')->count();
        }

        // 5. Tabel Laporan (Diambil untuk Antrean Validasi)
        $laporans = LaporanKegiatan::with('user')
            ->when($roleUser === 1, function($q) use ($userEskul) {
                return $q->where('nama_eskul', $userEskul);
            })->latest()->limit(5)->get();

        // 6. Log Kehadiran
        $absensis = Absensi::with('user')
            ->when($roleUser === 1, function($q) use ($userEskul) {
                return $q->where('unit_eskul', $userEskul);
            })
            ->when($roleUser === 2, function($q) use ($user) {
                return $q->where('user_id', $user->id);
            })
            ->latest()->limit(5)->get();

        // 7. Ringkasan Box
        $ringkasan = [
            'total_siswa'   => $totalSiswa,
            'total_anggota' => $totalAnggotaUnit,
            'total_laporan' => LaporanKegiatan::when($roleUser === 1, fn($q) => $q->where('nama_eskul', $userEskul))->count(),
            'total_eskul'   => count($labelsEskul),
            'eskul_anda'    => $userEskul ?? 'Umum',
            'persentase'    => $persentase 
        ];

        $viewData = compact('labelsEskul', 'dataX', 'dataXI', 'dataXII', 'ringkasan', 'laporans', 'absensis');

        // Logic Redirect View
        if ($roleUser === 0) return view('dashboard.dashboard', $viewData);
        if ($roleUser === 1) return view('dashboard.pembina', $viewData);
        
        return view('dashboard.siswa', $viewData);
    }

    // ✅ FUNGSI BARU: Validasi Laporan
    public function validasiLaporan($id)
    {
        try {
            $laporan = LaporanKegiatan::findOrFail($id);
            $laporan->status = 'valid'; // Pastikan kolom 'status' ada di DB
            $laporan->save();

            return back()->with('success', 'Laporan berhasil divalidasi!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memvalidasi laporan.');
        }
    }
}