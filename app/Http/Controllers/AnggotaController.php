<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    private $listEskul = ['Pramuka', 'Futsal', 'PMR', 'Paskibra', 'Bahasa Jepang', 'Rohis', 'Paduan Suara', 'Tari', 'Dance', 'Badminton', 'Pencak Silat'];

    public function index()
    {
        $user = Auth::user();
        
        // Jika Pembina, hanya tampilkan anggota di unit eskulnya
        $anggotas = User::where('role', 2)
            ->when($user->role == 1, function($q) use ($user) {
                return $q->where('eskul', $user->eskul);
            })
            ->latest()->get();

        return view('anggota.index', compact('anggotas'));
    }

    public function create()
    {
        $listEskul = $this->listEskul;
        return view('anggota.create', compact('listEskul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'kelas'    => 'required',
            'eskul'    => 'required',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 2,
            'kelas'    => $request->kelas,
            'eskul'    => $request->eskul,
        ]);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $anggota = User::findOrFail($id);
        
        // Proteksi: Pembina dilarang edit anggota eskul lain
        if (Auth::user()->role == 1 && $anggota->eskul !== Auth::user()->eskul) {
            return redirect()->route('anggota.index')->with('error', 'Akses ditolak!');
        }

        $listEskul = $this->listEskul;
        return view('anggota.edit', compact('anggota', 'listEskul'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'kelas' => 'required',
            'eskul' => 'required',
        ]);
        
        $user->fill($request->only(['name', 'email', 'kelas', 'eskul']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('anggota.index')->with('success', 'Data anggota diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Proteksi hapus
        if (Auth::user()->role == 1 && $user->eskul !== Auth::user()->eskul) {
            return redirect()->route('anggota.index')->with('error', 'Akses ditolak!');
        }

        $user->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}