<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EskulHub - Manajemen Ekstrakurikuler</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8faff; }
        .hero-gradient { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .card-shadow { box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="antialiased text-slate-800">

    <nav class="bg-white py-4 px-6 md:px-12 flex justify-between items-center shadow-sm sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo 3.0.jpeg') }}" alt="Logo EskulHub" class="w-12 h-12 object-contain">
            <span class="text-2xl font-extrabold tracking-tight flex">
                <span class="text-[#1e3a8a]">Eskul</span><span class="text-[#f97316]">Hub</span>
            </span>
        </div>

        <div class="hidden md:flex gap-10 font-semibold text-slate-600">
            <a href="#" class="text-blue-600 border-b-2 border-blue-600 pb-1">Dashboard</a>
            <a href="#" class="hover:text-blue-600 transition">Data Eskul</a>
            <a href="#" class="hover:text-blue-600 transition">Data Anggota</a>
            <div class="flex items-center gap-1 hover:text-blue-600 cursor-pointer">
                <span>Ranking</span>
                <i class="fas fa-chevron-down text-xs"></i>
            </div>
        </div>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-[#f97316] text-white px-6 py-2 rounded-xl font-bold hover:bg-orange-600 transition shadow-md">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-[#f97316] text-white px-8 py-2.5 rounded-xl font-bold hover:bg-orange-600 transition shadow-lg">Login</a>
                @endauth
            @endif
        </div>
    </nav>

    <div class="hero-gradient mt-6 mx-4 md:mx-8 rounded-[40px] p-10 md:p-16 text-white flex flex-col md:flex-row items-center justify-between relative overflow-hidden shadow-2xl border-4 border-white">
        <div class="z-10 md:w-1/2">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-[1.1]">Sistem Manajemen Ekstrakurikuler Sekolah</h1>
            <p class="text-blue-50 mb-10 text-lg md:text-xl opacity-90 leading-relaxed max-w-lg">Sistem manajemen untuk mengelola ekstrakurikuler di sekolah dengan mudah.</p>
            <div class="flex gap-4">
                <button class="bg-[#f97316] px-8 py-4 rounded-2xl font-bold hover:shadow-xl transition transform hover:scale-105">Kelola Eskul</button>
                <button class="bg-white/20 backdrop-blur-xl border border-white/30 px-8 py-4 rounded-2xl font-bold hover:bg-white/30 transition">Lihat Data</button>
            </div>
        </div>
        <div class="hidden md:block w-2/5 relative">
            <img src="https://illustrations.popsy.co/white/team-success.svg" alt="Ilustrasi" class="w-full drop-shadow-2xl scale-125">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-slate-800 mb-8 px-4">Daftar Eskul</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            @php
                $eskuls = [
                    ['nama' => 'Pramuka', 'icon' => '🔥', 'count' => 150, 'color' => 'bg-orange-100 text-orange-600'],
                    ['nama' => 'Paskibra', 'icon' => '🚩', 'count' => 120, 'color' => 'bg-red-100 text-red-600'],
                    ['nama' => 'PMR', 'icon' => '➕', 'count' => 100, 'color' => 'bg-blue-100 text-blue-600'],
                    ['nama' => 'Nihongo', 'icon' => '👘', 'count' => 80, 'color' => 'bg-orange-100 text-orange-600'],
                    ['nama' => 'Paduan Suara', 'icon' => '🎵', 'count' => 70, 'color' => 'bg-teal-100 text-teal-600'],
                    ['nama' => 'Seni Tari', 'icon' => '💃', 'count' => 70, 'color' => 'bg-blue-100 text-blue-600'],
                    ['nama' => 'Dance', 'icon' => '🤸', 'count' => 50, 'color' => 'bg-amber-100 text-amber-600'],
                    ['nama' => 'Pencak Silat', 'icon' => '', 'count' => 35, 'color' => 'bg-sky-100 text-sky-600'],
                    ['nama' => 'Futsal', 'icon' => '⚽', 'count' => 35, 'color' => 'bg-sky-100 text-sky-600']
                ];
            @endphp

            @foreach($eskuls as $eskul)
            <div class="bg-white p-5 rounded-[24px] card-shadow border border-slate-50 flex items-center gap-4 hover:-translate-y-1 transition-all duration-300">
                <div class="text-3xl {{ $eskul['color'] }} w-14 h-14 flex items-center justify-center rounded-2xl shadow-inner">
                    {{ $eskul['icon'] }}
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">{{ $eskul['nama'] }}</h3>
                    <p class="text-sm text-slate-400 font-medium">{{ $eskul['count'] }} Anggota</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid lg:grid-cols-2 gap-10">
            <div class="space-y-6">
                <div class="bg-white p-8 rounded-[32px] card-shadow border border-slate-50">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600">🏆</div>
                            <div>
                                <h3 class="font-bold text-slate-800">Ilmu Tiskul</h3>
                                <div class="flex items-center gap-1 text-xs font-bold text-green-500 bg-green-50 px-2 py-0.5 rounded-full w-fit">
                                    <i class="fas fa-check-circle"></i> 99
                                </div>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-md">Prodi Manajemen</span>
                    </div>
                    <p class="text-xs text-slate-400 font-bold mb-4">Grafik rata-rata nilai Eskul dalam 6 bulan terakhir</p>
                    <div class="h-40 w-full bg-blue-50/30 rounded-2xl relative flex items-end p-2 border border-blue-50">
                        <div class="absolute inset-0 flex items-center justify-center opacity-20">
                            <i class="fas fa-chart-line text-blue-500 text-6xl"></i>
                        </div>
                    </div>
                    <div class="flex justify-between mt-3 px-2">
                        @foreach(['Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr'] as $m)
                            <span class="text-[10px] font-bold text-slate-400">{{ $m }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[32px] card-shadow border border-slate-50">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-slate-800">Ranking Eskul</h3>
                        <button class="bg-blue-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-lg">Lihat Selengkapnya</button>
                    </div>
                    <div class="h-32 w-full bg-blue-50/30 rounded-2xl relative flex items-end justify-around p-4">
                         <div class="w-10 bg-blue-200 rounded-t-lg" style="height: 40%"></div>
                         <div class="w-10 bg-blue-300 rounded-t-lg" style="height: 60%"></div>
                         <div class="w-10 bg-blue-500 rounded-t-lg" style="height: 85%"></div>
                         <div class="w-10 bg-blue-400 rounded-t-lg" style="height: 50%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[32px] card-shadow border border-slate-50">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="font-bold text-slate-800 text-xl tracking-tight">Ranking Eskul</h3>
                    <button class="text-blue-600 text-[10px] font-bold bg-blue-50 px-4 py-1.5 rounded-lg">Lihat Selengkapnya</button>
                </div>
                
                <div class="space-y-4">
                    @php
                        $ranks = [
                            ['no' => 1, 'nama' => 'Ilmu Eskul', 'score' => 88, 'icon' => '🥇', 'color' => 'bg-yellow-50'],
                            ['no' => 2, 'nama' => 'PMR', 'score' => 82, 'icon' => '🏀', 'color' => ''],
                            ['no' => 3, 'nama' => 'Paskibra', 'score' => 78, 'icon' => '🚩', 'color' => ''],
                            ['no' => 4, 'nama' => 'Futsal', 'score' => 76, 'icon' => '⚽', 'color' => ''],
                            ['no' => 5, 'nama' => 'Pramuka', 'score' => 74, 'icon' => '🔥', 'color' => ''],
                            ['no' => 6, 'nama' => 'Dance', 'score' => 50, 'icon' => '🕌', 'color' => ''],
                            ['no' => 7, 'nama' => 'Nihongo', 'score' => 35, 'icon' => '🏊', 'color' => ''],
                            ['no' => 8, 'nama' => 'Pencak silat', 'score' => 35, 'icon' => '🏊', 'color' => ''],
                            ['no' => 9, 'nama' => 'Seni Tari', 'score' => 35, 'icon' => '🏊', 'color' => ''],
                            ['no' => 10, 'nama' => 'Paduan Suara', 'score' => 35, 'icon' => '🏊', 'color' => ''],
                        ];
                    @endphp

                    @foreach($ranks as $r)
                    <div class="flex justify-between items-center p-3 rounded-2xl {{ $r['color'] }} hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 flex items-center justify-center text-xl bg-white rounded-xl shadow-sm border border-slate-50">
                                {{ $r['icon'] }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $r['nama'] }}</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Anggota Aktif</p>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 font-extrabold text-xl">
                            {{ $r['score'] }}
                        </div>
                    </div>
                    @endforeach
                </div>

                
            </div>
        </div>
    </div>

</body>
</html>