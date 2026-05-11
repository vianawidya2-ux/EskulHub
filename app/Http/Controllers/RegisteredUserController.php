<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Awal
        // Perhatikan: eskul dan kelas dibuat 'nullable' dulu di sini 
        // supaya tidak error saat Admin/Pembina daftar.
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'eskul' => ['nullable', 'string', 'max:255'], 
            'kelas' => ['nullable', 'string', 'max:255'], 
            'kode_akses' => ['nullable', 'string', 'max:255'],
        ]);

        $kodeInput = strtoupper(trim($request->kode_akses ?? ''));
        
        // 2. LOGIKA PENENTUAN ROLE & DATA
        if ($kodeInput === 'ADMIN-SUPER') {
            $roleFinal = 0;
            $eskulFinal = 'ADMIN';
            $kelasFinal = '-';
        } elseif ($kodeInput === 'PEMBINA-SMK') {
            $roleFinal = 1;
            // Pembina wajib pilih eskul yang akan dibina
            $eskulFinal = $request->input('eskul') ?? 'Umum'; 
            $kelasFinal = 'Staff';
        } else {
            // SISWA: Di sini kita validasi manual agar siswa tidak mengosongkan data
            if (!$request->eskul || !$request->kelas) {
                return back()->withErrors(['eskul' => 'Siswa wajib mengisi Eskul dan Kelas!'])->withInput();
            }
            $roleFinal = 2;
            $eskulFinal = $request->input('eskul');
            $kelasFinal = $request->input('kelas');
        }

        // 3. Simpan ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $roleFinal, 
            'eskul' => $eskulFinal,
            'kelas' => $kelasFinal,
            'admin_code' => $request->kode_akses, // Menyimpan kode yang digunakan
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}      