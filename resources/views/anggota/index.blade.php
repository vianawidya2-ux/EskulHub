@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-black uppercase italic">Data Anggota Siswa</h2>
        <a href="{{ route('anggota.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold text-xs uppercase shadow-lg shadow-blue-200">
            + Tambah Anggota
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl mb-4 text-xs font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Kelas</th>
                    <th class="px-6 py-4">Eskul</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($anggotas as $anggota)
                <tr class="text-sm font-bold text-slate-700 hover:bg-slate-50/50 transition-all">
                    <td class="px-6 py-4">{{ $anggota->name }} <br> <span class="text-[10px] text-slate-400 font-normal">{{ $anggota->email }}</span></td>
                    <td class="px-6 py-4 text-xs">{{ $anggota->kelas }}</td>
                    <td class="px-6 py-4 text-xs font-black text-blue-600">{{ $anggota->eskul }}</td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic text-xs">Belum ada data anggota.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection