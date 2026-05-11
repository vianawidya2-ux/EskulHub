@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    {{-- Header --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] mb-2">Statistik & Analisis</p>
            <h1 class="text-4xl font-extrabold text-slate-800 tracking-tight">Leaderboard Eskul</h1>
            <p class="text-slate-400 text-sm font-medium mt-1">Peringkat performa ekstrakurikuler berdasarkan akumulasi skor anggota.</p>
        </div>
        
        {{-- Tombol Aksi (Hanya Admin/Pembina) --}}
        @if(Auth::check() && Auth::user()->role <= 1)
        <div class="flex gap-3">
            <a href="{{ route('penilaian.index') }}" class="bg-white text-slate-700 border border-slate-200 px-6 py-3 rounded-2xl font-bold text-xs shadow-sm hover:bg-slate-50 transition flex items-center gap-2">
                <i class="fas fa-list"></i> Data Nilai
            </a>
            {{-- Tombol input biasanya mengarah ke route 'create' --}}
            <a href="{{ route('penilaian.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-xs shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all flex items-center gap-2">
                <i class="fas fa-plus"></i> Input Nilai
            </a>
        </div>
        @endif
    </header>

    {{-- Filter Periode --}}
    <div class="bg-white p-2 rounded-[2.5rem] shadow-sm border border-slate-100 mb-10 inline-block">
        <form action="{{ route('rangking') }}" method="GET" class="flex items-center gap-2">
            <div class="flex items-center px-6 py-2 gap-3">
                <i class="fas fa-calendar-alt text-blue-500"></i>
                <select name="bulan" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-slate-700 outline-none min-w-[150px] cursor-pointer">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ ($bulanAktif ?? date('m')) == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-3 rounded-[2rem] font-bold text-xs transition duration-300">
                Update Data
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- List Ranking --}}
        <div class="lg:col-span-2">
            <div class="space-y-4 mb-10">
                @forelse($data_ranking as $index => $r)
                <div class="group bg-white p-2 rounded-[2rem] shadow-sm flex items-center justify-between border border-slate-50 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300">
                    <div class="flex items-center gap-5">
                        {{-- Badge Peringkat --}}
                        <div class="w-14 h-14 flex-shrink-0 rounded-[1.5rem] flex items-center justify-center font-black text-lg 
                            {{ $index == 0 ? 'bg-yellow-400 text-white shadow-lg shadow-yellow-100' : 
                               ($index == 1 ? 'bg-slate-300 text-white shadow-lg shadow-slate-100' : 
                               ($index == 2 ? 'bg-orange-400 text-white shadow-lg shadow-orange-100' : 'bg-blue-50 text-blue-600')) }}">
                            @if($index < 3)
                                <i class="fas fa-crown"></i>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-lg group-hover:text-blue-600 transition-colors uppercase">{{ $r->eskul }}</h3>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Skor Akumulasi</span>
                                <div class="h-1 w-1 rounded-full bg-slate-300"></div>
                                <span class="text-[10px] {{ $r->total_skor >= 80 ? 'text-emerald-500' : 'text-blue-500' }} font-black uppercase">
                                    {{ $r->total_skor >= 80 ? 'Excellent' : 'Good' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="pr-6 text-right">
                        <span class="block text-2xl font-black text-slate-800 tracking-tight">{{ number_format($r->total_skor, 0) }}</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Points</span>
                    </div>
                </div>
                @empty
                <div class="bg-white p-16 rounded-[3rem] text-center border-2 border-dashed border-slate-100">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-3xl">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Data penilaian belum tersedia</p>
                </div>
                @endforelse
            </div>

            {{-- Visualisasi Diagram --}}
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-xl">Grafik Performa</h3>
                        <p class="text-slate-400 text-xs font-medium mt-1">Visualisasi perbandingan skor {{ \Carbon\Carbon::create()->month($bulanAktif)->translatedFormat('F') }}.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Total Skor</span>
                    </div>
                </div>
                <div class="h-[350px]">
                    <canvas id="rankingChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Side Info --}}
        <div class="space-y-6">
            <div class="bg-slate-900 p-8 rounded-[3rem] text-white shadow-2xl shadow-slate-200 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full"></div>
                <i class="fas fa-shield-alt text-4xl mb-6 text-blue-400"></i>
                <h4 class="font-bold text-xl mb-3 leading-tight">Bagaimana Skor Dihitung?</h4>
                <p class="text-slate-400 text-sm leading-relaxed mb-6">
                    Sistem EskulHub mengintegrasikan variabel utama untuk menentukan peringkat otomatis:
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-xs font-semibold">
                        <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center text-blue-400"><i class="fas fa-check text-[10px]"></i></div>
                        Rata-rata kehadiran
                    </li>
                    <li class="flex items-center gap-3 text-xs font-semibold">
                        <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center text-blue-400"><i class="fas fa-star text-[10px]"></i></div>
                        Pencapaian kompetisi
                    </li>
                    <li class="flex items-center gap-3 text-xs font-semibold">
                        <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center text-blue-400"><i class="fas fa-users text-[10px]"></i></div>
                        Keaktifan program kerja
                    </li>
                </ul>
            </div>

            <div class="p-8 rounded-[3rem] border-2 border-dashed border-slate-200">
                <p class="text-slate-400 text-sm italic leading-relaxed">
                    "Kualitas sebuah organisasi tidak hanya dinilai dari hasilnya, tetapi dari konsistensi prosesnya."
                </p>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT OPTIMIZATION --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('rankingChart');
        if (!ctx) return;

        // Ambil data dari variabel PHP dengan aman
        const rawLabels = @json($data_ranking->pluck('eskul'));
        const rawData = @json($data_ranking->pluck('total_skor'));

        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: rawLabels.map(label => label.toUpperCase()),
                datasets: [{
                    label: 'Total Skor',
                    data: rawData,
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return null;
                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, '#2563eb');
                        gradient.addColorStop(1, '#60a5fa');
                        return gradient;
                    },
                    borderRadius: 12,
                    borderSkipped: false,
                    barThickness: 28
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        cornerRadius: 10,
                        displayColors: false
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#f8fafc', drawBorder: false },
                        ticks: { 
                            font: { weight: 'bold', size: 10 }, 
                            color: '#94a3b8',
                            callback: value => value + ' pts'
                        }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { font: { weight: 'bold', size: 10 }, color: '#64748b' }
                    }
                }
            }
        });
    });
</script>
@endsection