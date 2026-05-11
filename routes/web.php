<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// Import Controller
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\LaporanController; 
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EskulController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SejarahController;

// 1. REDIRECT UTAMA
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// ✅ PUBLIC REGISTER ROUTES
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
});

// 2. AKSES SEMUA USER (Siswa, Pembina, Admin)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ✅ FITUR VALIDASI LAPORAN (Tambahan Baru untuk Dashboard Admin/Pembina)
    Route::post('/dashboard/validasi/{id}', [DashboardController::class, 'validasiLaporan'])->name('laporan.validasi');
    
    // --- RANGKING & INFO ---
    Route::get('/rangking', [PenilaianController::class, 'ranking'])->name('penilaian.rangking');
    Route::get('/sejarah', [SejarahController::class, 'index'])->name('sejarah');
    Route::get('/data-eskul', [EskulController::class, 'index'])->name('eskul.index');

    // --- FITUR DATA ANGGOTA ---
    Route::get('/data-anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/data-anggota/tambah', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/data-anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/data-anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/data-anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/data-anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    
    // --- FITUR LAPORAN (CRUD) ---
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/tambah', [LaporanController::class, 'create'])->name('laporan.create'); // Tambahkan ini jika ada halaman form tambah
    Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit'); 
    Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy'); 
    
    // --- FITUR ABSENSI ---
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi-simpan', [AbsensiController::class, 'simpanAbsensi'])->name('absensi.simpan');
    Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');

    // --- FITUR PENILAIAN ---
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::delete('/penilaian/{id}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');

    // --- PANEL ADMIN ---
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{id}', [AdminUserController::class, 'updateRole'])->name('admin.users.update');

    // Logout
    Route::post('/logout', function () {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    })->name('logout');
});

require __DIR__.'/auth.php';