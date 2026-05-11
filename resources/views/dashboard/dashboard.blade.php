@extends('layouts.app')

@section('content')
<div class="p-2 space-y-6">
    {{-- 1. TOP STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- ... (Bagian Stats sudah benar, pastikan variabel $ringkasan['persentase'] terbaca) ... --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Siswa</p>
                    <p class="text-2xl font-black text-slate-800">{{ number_format($ringkasan['total_siswa'] ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <p class="text-[9px] font-bold text-emerald-500 mt-2">Data Real-time</p>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Unit Eskul</p>
                    <p class="text-2xl font-black text-slate-800">{{ $ringkasan['total_eskul'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center">
                    <i class="fa-solid fa-shapes"></i>
                </div>
            </div>
            <p class="text-[9px] font-bold text-slate-400 mt-2">Semua unit aktif</p>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Siswa Ber-Eskul</p>
                    <p class="text-2xl font-black text-slate-800">{{ number_format($ringkasan['total_anggota'] ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
            <p class="text-[9px] font-bold text-blue-500 mt-2">{{ $ringkasan['persentase'] ?? 0 }}% Partisipasi</p>
        </div>

        <div class="bg-slate-900 p-6 rounded-[2rem] shadow-sm flex items-center justify-between text-white">
            <div>
                <p class="text-[10px] font-bold opacity-50 uppercase">{{ date('l') }}</p>
                <p class="text-lg font-black">{{ date('d M Y') }}</p>
            </div>
            <i class="fa-solid fa-calendar-check text-2xl text-blue-500"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- MONITOR UNIT --}}
        <div class="lg:col-span-1 space-y-4">
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest italic px-2">ekstrakurikuler</h3>
            <div class="grid grid-cols-1 gap-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                @forelse($labelsEskul ?? [] as $eskul)
                <div class="bg-white p-4 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center justify-between group">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-slate-50 text-slate-400 group-hover:bg-blue-600 group-hover:text-white rounded-xl flex items-center justify-center transition-all">
                            <i class="fa-solid fa-star text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-700 leading-none">{{ $eskul }}</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-200"></i>
                </div>
                @empty
                <p class="text-xs text-slate-400 italic px-2">Tidak ada data unit.</p>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            {{-- GRAFIK --}}
            <div class="bg-white p-6 lg:p-10 rounded-[2rem] lg:rounded-[3rem] border border-slate-100 shadow-sm">
                <h3 class="text-xl lg:text-2xl font-black text-slate-800 tracking-tight">Analisis Partisipasi</h3>
                <div class="h-[250px] lg:h-[300px] w-full mt-4">
                    <canvas id="adminPartisipasiChart"></canvas>
                </div>
            </div>

            {{-- ✅ TABEL VALIDASI (DI-UPDATE) --}}
            <div class="bg-white p-6 lg:p-8 rounded-[2rem] lg:rounded-[3rem] border border-slate-100 shadow-sm overflow-x-auto">
                <h3 class="text-lg font-black text-slate-800 mb-6">Antrean Validasi</h3>
                <table class="w-full text-left min-w-[500px]">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase">
                            <th>Laporan</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans ?? [] as $laporan)
                        <tr class="border-t border-slate-50">
                            <td class="py-4">
                                <p class="text-xs font-bold">{{ $laporan->judul_kegiatan }}</p>
                                <p class="text-[9px] text-slate-400">Oleh: {{ $laporan->user->name ?? 'Siswa' }}</p>
                            </td>
                            <td class="text-xs font-black text-blue-600">{{ $laporan->nama_eskul }}</td>
                            <td>
                                {{-- Status Dinamis --}}
                                @if($laporan->status == 'valid')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-600 text-[9px] font-black rounded-lg uppercase">Valid</span>
                                @else
                                    <span class="px-2 py-1 bg-orange-100 text-orange-600 text-[9px] font-black rounded-lg uppercase">Pending</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($laporan->status != 'valid')
                                    {{-- FORM VALIDASI --}}
                                    <form action="{{ route('laporan.validasi', $laporan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 bg-slate-50 rounded-lg text-slate-400 hover:bg-blue-600 hover:text-white transition-all">
                                            <i class="fa-solid fa-check text-[10px]"></i>
                                        </button>
                                    </form>
                                @else
                                    {{-- TOMBOL BIRU JIKA SUDAH VALID --}}
                                    <div class="inline-flex w-8 h-8 bg-blue-600 rounded-lg text-white items-center justify-center shadow-lg shadow-blue-100">
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-4 text-center text-xs text-slate-400 italic">Tidak ada antrean.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT TETAP SAMA --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('adminPartisipasiChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelsEskul ?? []) !!},
                datasets: [
                    { label: 'X', data: {!! json_encode($dataX ?? []) !!}, backgroundColor: '#1e293b', borderRadius: 6 },
                    { label: 'XI', data: {!! json_encode($dataXI ?? []) !!}, backgroundColor: '#3b82f6', borderRadius: 6 },
                    { label: 'XII', data: {!! json_encode($dataXII ?? []) !!}, backgroundColor: '#94a3b8', borderRadius: 6 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { 
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection