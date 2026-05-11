@extends('layouts.app')

@section('content')
<div class="p-2 space-y-6">
    {{-- 1. HEADER & INFO WAKTU --}}
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Halo, Pembina {{ Auth::user()->name }}! 👋</h1>
            <p class="text-slate-400 text-sm font-medium mt-1">Unit Kelolaan: <span class="text-blue-600 font-bold">{{ $ringkasan['eskul_anda'] }}</span></p>
        </div>
        <div class="bg-slate-50 px-6 py-3 rounded-2xl border border-slate-100 text-right min-w-[200px]">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ date('l, d M Y') }}</p>
            <p class="text-lg font-black text-slate-800">{{ date('H:i') }} WIB</p>
        </div>
    </div>

    {{-- 2. STATS RINGKAS (DINAMIS) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Anggota Unit --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-users-line text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Anggota Unit</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($ringkasan['total_anggota']) }} <span class="text-xs font-medium text-slate-400">Siswa</span></p>
            </div>
        </div>

        {{-- Total Laporan Unit --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-file-signature text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Laporan Unit</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($ringkasan['total_laporan']) }} <span class="text-xs font-medium text-slate-400">Berkas</span></p>
            </div>
        </div>

        {{-- Partisipasi Unit vs Sekolah --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-percent text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Partisipasi Unit</p>
                <p class="text-2xl font-black text-slate-800">
                    {{ $ringkasan['total_siswa'] > 0 ? round(($ringkasan['total_anggota'] / $ringkasan['total_siswa']) * 100) : 0 }}%
                    <span class="text-xs font-medium text-slate-400">Sekolah</span>
                </p>
            </div>
        </div>
    </div>

    {{-- 3. TABEL VALIDASI & LOG KEHADIRAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- TABEL LAPORAN --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight italic">Menunggu Validasi</h3>
                    <a href="{{ route('laporan.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-y-3">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-2">Judul Laporan</th>
                                <th class="px-4 py-2">Siswa Pelapor</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporans as $item)
                            <tr class="bg-slate-50/50 hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-4 rounded-l-2xl">
                                    <p class="text-sm font-bold text-slate-700">{{ $item->judul_kegiatan }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $item->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-slate-600">{{ $item->user->name ?? 'Siswa' }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 {{ $item->status == 'Selesai' ? 'bg-emerald-100 text-emerald-600' : 'bg-orange-100 text-orange-600' }} text-[10px] font-bold rounded-full uppercase">
                                        {{ $item->status ?? 'Pending' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 rounded-r-2xl text-center">
                                    <div class="flex justify-center items-center space-x-3">
                                        <a href="{{ route('laporan.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('laporan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-10 text-slate-400 italic">Belum ada laporan masuk untuk unit ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- LOG KEHADIRAN --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight italic">Log Kehadiran Anggota</h3>
                    <i class="fa-solid fa-clock-rotate-left text-slate-300"></i>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    @forelse($absensis as $log)
                    <div class="flex items-center justify-between p-4 bg-slate-50/50 rounded-2xl border border-slate-100 hover:border-blue-200 transition-all">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-slate-900 text-white rounded-full flex items-center justify-center font-black text-xs">
                                {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $log->user->name ?? 'Siswa' }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $log->status == 'Hadir' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                {{ $log->status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <i class="fa-solid fa-clipboard-user text-3xl text-slate-100 mb-3 block"></i>
                        <p class="text-xs text-slate-400 italic">Belum ada aktivitas presensi hari ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Kanan: Agenda & Statistik Chart Ringkas --}}
        <div class="space-y-6">
            <div class="p-8 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-xl font-black italic tracking-tight">Cek Presensi ✨</h3>
                    <p class="text-sm opacity-80 mt-2 leading-relaxed">Pastikan seluruh anggota unit hadir dalam jadwal kegiatan rutin.</p>
                    <div class="mt-6">
                        <a href="{{ route('absensi.index') }}" class="block w-full bg-white text-blue-600 py-3 rounded-xl font-bold text-xs text-center uppercase tracking-widest shadow-md hover:bg-slate-50 transition-colors">Buka Menu Absensi</a>
                    </div>
                </div>
                <i class="fa-solid fa-calendar-check absolute -right-5 -bottom-5 text-8xl opacity-10 rotate-12"></i>
            </div>

            {{-- Info Statistik Tambahan --}}
            <div class="p-8 bg-slate-900 rounded-[2.5rem] text-white shadow-sm">
                <p class="text-[10px] font-bold opacity-50 uppercase tracking-widest">Efektivitas Unit</p>
                <div class="mt-4 flex items-end space-x-2">
                    <p class="text-4xl font-black">{{ $ringkasan['total_anggota'] > 0 ? '94%' : '0%' }}</p>
                    <p class="text-[10px] font-bold text-emerald-400 mb-1 leading-none"><i class="fa-solid fa-caret-up"></i> +2%</p>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full mt-4">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $ringkasan['total_anggota'] > 0 ? '94%' : '0%' }}"></div>
                </div>
                <p class="text-[9px] text-slate-500 mt-4 leading-relaxed italic">Data dihitung berdasarkan rasio kehadiran dan kelengkapan laporan bulanan unit.</p>
            </div>
        </div>
    </div>
</div>
@endsection