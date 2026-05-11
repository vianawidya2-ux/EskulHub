@extends('layouts.app')

@section('content')
    <main class="flex-1 p-6 lg:p-10 text-slate-800">
        <header class="flex justify-between items-center mb-8">
            <div class="flex flex-col">
                <h1 class="text-2xl font-extrabold text-slate-800">Data Anggota</h1>
                <p class="text-slate-400 text-[10px] font-bold mt-1 uppercase tracking-widest italic">Dashboard > Data Anggota</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">
                        {{ Auth::user()->role == 0 ? 'Administrator' : (Auth::user()->role == 1 ? 'Pembina' : 'Siswa') }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="bg-white rounded-[30px] shadow-sm border border-slate-50 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
                {{-- Form Pencarian Baru --}}
                <form action="{{ route('anggota.index') }}" method="GET" class="relative w-full md:w-80">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama anggota..." 
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 transition font-medium"
                    >
                </form>
                
                @if(Auth::user()->role <= 1)
                <a href="{{ route('anggota.create') }}" class="bg-[#f97316] text-white px-6 py-3 rounded-xl font-bold text-[10px] tracking-widest shadow-lg hover:bg-orange-600 transition flex items-center gap-2 uppercase">
                    <i class="fas fa-plus"></i> Tambah Anggota Baru
                </a>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-blue-50/50 text-blue-600 uppercase text-[10px] font-black tracking-widest border-b border-blue-100">
                            <th class="px-8 py-4">Nama Anggota</th>
                            <th class="px-8 py-4">Email</th>
                            <th class="px-8 py-4">Status Keaktifan</th> {{-- Kolom Baru --}}
                            <th class="px-8 py-4">Ekstrakurikuler</th>
                            @if(Auth::user()->role <= 1)
                            <th class="px-8 py-4 text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($anggotas as $a)
                        <tr class="hover:bg-slate-50/50 transition group">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] font-black border border-blue-100">
                                        {{ substr($a->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-700 text-sm group-hover:text-blue-600 transition">{{ $a->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-4 text-slate-500 text-sm font-semibold italic">{{ $a->email }}</td>
                            
                            {{-- Tampilan Status Aktif Otomatis --}}
                            <td class="px-8 py-4">
                                @if($a->status_aktif == 'Aktif')
                                    <span class="bg-green-50 text-green-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tight">
                                        <i class="fas fa-check-circle mr-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="bg-red-50 text-red-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tight">
                                        <i class="fas fa-times-circle mr-1"></i> Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-8 py-4">
                                <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tight">
                                    {{ $a->eskul ?? 'Belum Memilih' }}
                                </span>
                            </td>
                            
                            @if(Auth::user()->role <= 1)
                            <td class="px-8 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('anggota.edit', $a->id) }}" class="bg-blue-50 text-blue-600 p-2 rounded-lg hover:bg-blue-600 hover:text-white transition" title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('anggota.destroy', $a->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data anggota ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-600 p-2 rounded-lg hover:bg-red-600 hover:text-white transition" title="Hapus">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role <= 1 ? 5 : 4 }}" class="px-8 py-10 text-center text-slate-400 italic">Data anggota tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="mt-20 py-8 text-center border-t border-slate-100">
        </footer>
    </main>
@endsection