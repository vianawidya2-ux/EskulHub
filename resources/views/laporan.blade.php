@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#f4f7ff]">
 

    <main class="flex-1 p-6 lg:p-10">
        {{-- HEADER --}}
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Laporan Kegiatan</h2>
                <p class="text-slate-400 text-[10px] font-bold mt-1 uppercase tracking-[0.2em] italic">Dashboard > Laporan Sistem</p>
            </div>
            <div class="hidden md:flex items-center gap-4 bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-50">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-invoice text-blue-600"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase leading-none">Total Laporan</p>
                    <p class="text-lg font-bold text-slate-800 leading-tight">{{ count($semua_laporan) }}</p>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="bg-emerald-500 text-white p-4 rounded-2xl mb-8 shadow-lg shadow-emerald-100 flex items-center animate-fade-in-down">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        {{-- FORM INPUT LAPORAN --}}
        <section class="bg-white p-8 md:p-10 rounded-[35px] shadow-sm border border-slate-50 mb-12 relative overflow-hidden group">
            <div class="absolute -right-12 -top-12 w-40 h-40 bg-blue-50/50 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
            
            <h3 class="font-bold text-slate-700 mb-8 flex items-center gap-3 text-lg relative z-10">
                <div class="w-2 h-6 bg-blue-600 rounded-full"></div>
                Buat Laporan Baru
            </h3>

            <form action="{{ route('laporan.store') }}" method="POST" class="relative z-10">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 ml-1 tracking-widest">Unit Ekstrakurikuler</label>
                        <input type="text" name="nama_eskul" placeholder="Contoh: Pramuka / Futsal" 
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 outline-none focus:ring-2 focus:ring-blue-500 transition font-semibold text-slate-600" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 ml-1 tracking-widest">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_kegiatan" 
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 outline-none focus:ring-2 focus:ring-blue-500 transition font-semibold text-slate-600 uppercase" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 ml-1 tracking-widest">Detail Deskripsi Kegiatan</label>
                        <textarea name="deskripsi_kegiatan" rows="4" placeholder="Jelaskan apa saja aktivitas yang dilakukan hari ini..." 
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 outline-none focus:ring-2 focus:ring-blue-500 transition font-medium text-slate-600" required></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 ml-1 tracking-widest">Anggota Hadir</label>
                        <div class="relative">
                            <i class="fas fa-user-check absolute left-5 top-1/2 -translate-y-1/2 text-emerald-500"></i>
                            <input type="number" name="jumlah_hadir" min="0" placeholder="0" 
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-12 pr-6 py-4 outline-none focus:ring-2 focus:ring-blue-500 transition font-bold" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 ml-1 tracking-widest">Anggota Izin/Sakit</label>
                        <div class="relative">
                            <i class="fas fa-user-clock absolute left-5 top-1/2 -translate-y-1/2 text-orange-500"></i>
                            <input type="number" name="jumlah_izin" min="0" placeholder="0" 
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-12 pr-6 py-4 outline-none focus:ring-2 focus:ring-blue-500 transition font-bold" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="mt-10 bg-[#f97316] text-white px-12 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-orange-100 hover:bg-orange-600 transition transform hover:-translate-y-1">
                    Kirim Laporan 
                </button>
            </form>
        </section>

        {{-- FILTER & PENCARIAN --}}
        <section class="bg-white p-6 rounded-[25px] shadow-sm border border-slate-50 mb-10">
            <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1 tracking-widest">Cari Eskul</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama eskul..." 
                            class="w-full pl-11 pr-4 bg-slate-50 border border-slate-100 py-3 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-xs font-bold text-slate-600">
                    </div>
                </div>

                <div class="w-full md:w-auto">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1 tracking-widest">Filter Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                        class="w-full bg-slate-50 border border-slate-100 p-3 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-xs font-bold text-slate-600">
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition shadow-md">
                        Cari Data
                    </button>

                    @if(request('search') || request('tanggal'))
                        <a href="{{ route('laporan.index') }}" class="bg-slate-100 text-slate-500 px-6 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-slate-200 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>

        {{-- RIWAYAT LAPORAN --}}
        <div class="space-y-6 mb-20">
            <h3 class="font-black text-slate-800 ml-2 uppercase text-[10px] tracking-[0.2em] flex items-center gap-2">
                <i class="fas fa-clock text-blue-600"></i> Arsip Laporan Terbaru
            </h3>
            
            @forelse($semua_laporan as $lapor)
            <div class="bg-white p-8 rounded-[30px] shadow-sm border border-slate-50 hover:border-blue-200 transition-all duration-300 group">
                <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-xl text-slate-800 group-hover:text-blue-600 transition">{{ $lapor->nama_eskul }}</h4>
                            <div class="flex items-center gap-2 mt-1 text-slate-400">
                                <i class="far fa-calendar-alt text-[10px]"></i>
                                <p class="text-[10px] font-black uppercase tracking-widest">
                                    {{ \Carbon\Carbon::parse($lapor->tanggal_kegiatan)->isoFormat('DD MMMM YYYY') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase border border-emerald-100">
                            <i class="fas fa-user-check mr-1"></i> Hadir: {{ $lapor->jumlah_hadir }}
                        </div>
                        <div class="bg-orange-50 text-orange-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase border border-orange-100">
                            <i class="fas fa-user-clock mr-1"></i> Izin: {{ $lapor->jumlah_izin }}
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-6 rounded-2xl relative">
                    <i class="fas fa-quote-left text-slate-200 absolute top-4 left-4 text-2xl"></i>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium pl-8">
                        {{ $lapor->deskripsi_kegiatan }}
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-white rounded-[35px] border-2 border-dashed border-slate-100 shadow-sm">
                <div class="mb-4">
                    <i class="fas fa-folder-open text-6xl text-slate-100"></i>
                </div>
                <p class="text-slate-400 font-black text-xs tracking-widest uppercase italic">Arsip tidak ditemukan.</p>
            </div>
            @endforelse
        </div>
    </main>
</div>
@endsection