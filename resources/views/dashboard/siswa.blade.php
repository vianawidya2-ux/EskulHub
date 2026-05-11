@extends('layouts.app')

@section('content')
<div class="p-2 space-y-6">
    {{-- 1. ROW ATAS: HEADER & STATS RINGKAS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-blue-100">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <h1 class="text-xl font-black text-slate-800">Halo, {{ Auth::user()->name }}!</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Siswa • {{ Auth::user()->kelas ?? '-' }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase">Unit Anda</p>
                <p class="text-sm font-black text-slate-700">{{ Auth::user()->eskul ?? '-' }}</p>
            </div>
        </div>
        <div class="bg-slate-900 p-6 rounded-2xl shadow-sm flex items-center justify-center text-white">
            <div class="text-center">
                <p class="text-[9px] font-bold opacity-50 uppercase italic">{{ date('l') }}</p>
                <p class="text-sm font-black">{{ date('d M Y') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- 2. KOLOM KIRI: LIST ESKUL MEMANJANG (GRID) --}}
        <div class="lg:col-span-1 space-y-4">
            <h3 class="text-sm font-black text-slate-700 ml-2 uppercase tracking-wider">Daftar Unit Eskul</h3>
            <div class="grid grid-cols-1 gap-3">
                @php
                    $icons = ['Pramuka' => 'music', 'Basket' => 'basketball', 'Seni Musik' => 'guitar', 'PMR' => 'plus-medical', 'Paskibra' => 'user-tie', 'English Club' => 'book-open', 'Futsal' => 'futbol', 'Rohis' => 'mosque', 'Jurnalistik' => 'pen-nib', 'Teater' => 'masks-theater', 'Pencak Silat' => 'hand-fist'];
                @endphp
                {{-- Loop 11 Eskul --}}
                @foreach($labelsEskul as $eskul)
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center justify-between group hover:border-blue-400 transition-all cursor-pointer {{ Auth::user()->eskul == $eskul ? 'border-l-4 border-l-blue-600 bg-blue-50/30' : '' }}">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-slate-50 text-slate-500 group-hover:text-blue-600 rounded-lg flex items-center justify-center text-xs">
                            <i class="fa-solid fa-{{ $icons[$eskul] ?? 'star' }}"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-700">{{ $eskul }}</p>
                    </div>
                    @if(Auth::user()->eskul == $eskul)
                        <span class="text-[9px] bg-blue-600 text-white px-2 py-0.5 rounded-full font-bold">MILIKMU</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- 3. KOLOM KANAN: STATISTIK ANGKATAN (DI BAWAH/SAMPING) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Card Absensi Cepat --}}
            <div class="p-8 bg-blue-600 rounded-[2.5rem] text-white shadow-xl shadow-blue-100 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-2xl font-black italic">Sudah Latihan Hari Ini?</h3>
                    <p class="text-sm opacity-80 mt-1">Klik tombol di bawah untuk mengisi daftar hadir unit {{ Auth::user()->eskul }}.</p>
                    <a href="{{ route('absensi.index') }}" class="inline-block mt-6 bg-white text-blue-600 px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg">
                        Isi Absensi Sekarang
                    </a>
                </div>
                <i class="fa-solid fa-paper-plane absolute -right-5 -bottom-5 text-8xl opacity-10 rotate-12"></i>
            </div>

            {{-- Grafik Statistik Angkatan --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-lg font-black text-slate-800 tracking-tight">Statistik Partisipasi Siswa</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Data Per Angkatan Seluruh Eskul</p>
                    </div>
                    <div class="flex space-x-3">
                        <div class="flex items-center text-[9px] font-bold text-slate-500"><span class="w-2 h-2 bg-[#1e293b] rounded-full mr-1.5"></span> X</div>
                        <div class="flex items-center text-[9px] font-bold text-slate-500"><span class="w-2 h-2 bg-[#3b82f6] rounded-full mr-1.5"></span> XI</div>
                        <div class="flex items-center text-[9px] font-bold text-slate-500"><span class="w-2 h-2 bg-[#93c5fd] rounded-full mr-1.5"></span> XII</div>
                    </div>
                </div>

                <div class="h-[350px] w-full">
                    <canvas id="partisipasiChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('partisipasiChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelsEskul) !!},
                datasets: [
                    { label: 'X', data: {!! json_encode($dataX) !!}, backgroundColor: '#1e293b', borderRadius: 4 },
                    { label: 'XI', data: {!! json_encode($dataXI) !!}, backgroundColor: '#3b82f6', borderRadius: 4 },
                    { label: 'XII', data: {!! json_encode($dataXII) !!}, backgroundColor: '#93c5fd', borderRadius: 4 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' } } },
                    y: { beginAtZero: true, grid: { color: '#f8fafc' }, ticks: { stepSize: 1 } }
                }
            }
        });
    });
</script>
@endsection 