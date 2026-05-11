@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#f4f7ff]">
 

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 p-6 lg:p-10">
        <header class="flex justify-between items-center mb-8">
            <div class="flex flex-col">
                <h1 class="text-2xl font-extrabold text-slate-800">Manajemen Nilai</h1>
                <p class="text-slate-400 text-[10px] font-bold mt-1 uppercase tracking-widest italic">
                    Unit: {{ Auth::user()->eskul ?? 'Semua Unit' }}
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-blue-500 font-black uppercase tracking-tighter">
                        {{ Auth::user()->role == 0 ? 'Administrator' : 'Pembina' }}
                    </p>
                </div>
            </div>
        </header>

        <section class="max-w-5xl">
            {{-- Alert Notifikasi --}}
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl flex items-center gap-3 font-bold text-sm shadow-lg shadow-emerald-100 animate-bounce">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-500 text-white rounded-2xl shadow-lg shadow-red-100">
                <ul class="list-disc list-inside text-xs font-bold uppercase tracking-wide">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- FORM INPUT NILAI --}}
            <form action="{{ route('penilaian.store') }}" method="POST" class="mb-10">
                @csrf
                <div class="bg-white p-8 rounded-[35px] shadow-sm border border-slate-50 relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-50/50 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
                    
                    <h3 class="font-bold text-slate-800 text-lg mb-6 flex items-center gap-2 relative z-10">
                        <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                        Beri Nilai Anggota
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4 relative z-10">
                        {{-- Nama Anggota --}}
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block tracking-widest ml-1">Nama Anggota</label>
                            <input type="text" name="nama_anggota" placeholder="Masukkan nama siswa..." 
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                        </div>

                        {{-- Unit Eskul --}}
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block tracking-widest ml-1">Unit Eskul</label>
                            <input type="text" name="eskul" value="{{ Auth::user()->eskul }}" 
                                class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-500 cursor-not-allowed uppercase" readonly>
                        </div>

                        {{-- Skor --}}
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block tracking-widest ml-1">Skor (0-100)</label>
                            <input type="number" name="total_skor" min="0" max="100" placeholder="0" 
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-slate-800 text-white py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg hover:bg-blue-600 hover:-translate-y-1 transition-all duration-300">
                                Simpan Nilai
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- TABEL DATA NILAI --}}
            <div class="bg-white rounded-[35px] shadow-sm border border-slate-50 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-lg">Daftar Nilai {{ Auth::user()->eskul }}</h3>
                    <span class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest">
                        Total: {{ $penilaians->count() }} Data
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-blue-50/50 text-blue-600 uppercase text-[10px] font-black tracking-widest border-b border-blue-100">
                                <th class="px-8 py-5">Identitas Anggota</th>
                                <th class="px-8 py-5">Eskul</th>
                                <th class="px-8 py-5 text-center">Skor</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($penilaians as $p)
                            <tr class="hover:bg-slate-50/50 transition group">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-black border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                            {{ substr($p->nama_anggota, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-slate-700 text-sm">{{ $p->nama_anggota }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-slate-500 font-bold text-[10px] uppercase tracking-widest">{{ $p->eskul }}</td>
                                <td class="px-8 py-4 text-center">
                                    <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-xl font-black text-xs">
                                        {{ $p->total_skor }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <form action="{{ route('penilaian.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus penilaian untuk {{ $p->nama_anggota }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg text-red-400 hover:bg-red-50 hover:text-red-600 transition flex items-center justify-center mx-auto">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <i class="fas fa-inbox text-4xl text-slate-200"></i>
                                        <p class="text-slate-400 font-bold italic text-sm uppercase tracking-widest">Data penilaian masih kosong</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <footer class="mt-20 py-8 text-center border-t border-slate-100">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] italic">© 2026 ESKULHUB - CREATIVE DIGITAL SCHOOL</p>
        </footer>
    </main>
</div>
@endsection