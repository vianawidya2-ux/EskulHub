<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian - EskulHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7ff; }
        .sidebar-dark { background-color: #0f172a; }
        .sidebar-active { background-color: #2563eb; color: white; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3); }
        .card-shadow { box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04); }
    </style>
</head>
<body class="antialiased text-slate-800 flex">

    {{-- SIDEBAR BIRU TUA (Sesuai Desain Konsisten) --}}
    <aside class="w-64 min-h-screen sidebar-dark text-white p-6 hidden lg:block sticky top-0">
        {{-- Logo Area --}}
        <div class="flex items-center gap-3 mb-2">
            <div class="bg-blue-600 text-white w-10 h-10 flex items-center justify-center rounded-xl shadow-lg font-black text-lg">
                EH
            </div>
            <span class="text-xl font-black tracking-tight italic">Eskul<span class="text-blue-400">Hub</span></span>
        </div>

        {{-- User Profile Mini --}}
        <div class="mb-10 ml-2 mt-4">
            <p class="text-xs font-bold text-slate-300">{{ Auth::user()->name }}</p>
            <p class="text-[10px] text-blue-400 font-medium uppercase tracking-wider">
                Role ID: {{ Auth::user()->role }} - {{ Auth::user()->role == 0 ? 'ADMIN' : (Auth::user()->role == 1 ? 'PEMBINA' : 'ANGGOTA') }}
            </p>
        </div>

        <nav class="space-y-1">
            <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em] mb-4 ml-2 font-bold">MAIN MENU</p>
            
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-800 transition text-slate-400 text-sm font-semibold">
                <i class="fas fa-home w-5 text-center"></i> Beranda
            </a>
            
            <a href="{{ route('penilaian.rangking') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-800 transition text-slate-400 text-sm font-semibold">
                <i class="fas fa-trophy w-5 text-center"></i> Ranking
            </a>

            <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em] mt-8 mb-4 ml-2 font-bold">INFORMASI UMUM</p>
            
            <a href="{{ route('sejarah') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-800 transition text-slate-400 text-sm font-semibold">
                <i class="fas fa-history w-5 text-center"></i> Sejarah
            </a>

            <a href="{{ route('eskul.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-800 transition text-slate-400 text-sm font-semibold">
                <i class="fas fa-th-large w-5 text-center"></i> Data Eskul
            </a>

            <a href="{{ route('anggota.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-800 transition text-slate-400 text-sm font-semibold">
                <i class="fas fa-users w-5 text-center"></i> Data Anggota
            </a>

            {{-- MENU MANAJEMEN --}}
            <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em] mt-8 mb-4 ml-2 font-bold">MANAJEMEN DATA</p>
            
            <a href="{{ route('penilaian.index') }}" class="flex items-center gap-3 p-3 rounded-xl sidebar-active transition text-sm font-bold">
                <i class="fas fa-edit w-5 text-center"></i> Input Penilaian
            </a>

            <a href="{{ route('absensi.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-800 transition text-slate-400 text-sm font-semibold">
                <i class="fas fa-calendar-check w-5 text-center"></i> Absensi Anggota
            </a>

            <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-800 transition text-slate-400 text-sm font-semibold">
                <i class="fas fa-file-pdf w-5 text-center"></i> Laporan
            </a>
        </nav>

        {{-- Logout Button --}}
        <div class="absolute bottom-8 left-6 right-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 p-3 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300 font-bold text-xs uppercase tracking-widest">
                    <i class="fas fa-sign-out-alt"></i> LOGOUT SYSTEM
                </button>
            </form>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 p-6 lg:p-10">
        <header class="flex justify-between items-center mb-8">
            <div class="flex flex-col">
                <h1 class="text-2xl font-extrabold text-slate-800">Daftar Nilai Anggota</h1>
                <p class="text-slate-400 text-[10px] font-bold mt-1 uppercase tracking-widest">DASHBOARD > PENILAIAN</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">
                        {{ Auth::user()->role == 0 ? 'Admin' : (Auth::user()->role == 1 ? 'Pembina' : 'Siswa') }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="bg-white rounded-[30px] card-shadow border border-slate-50 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-50/50 text-blue-600 uppercase text-[10px] font-black tracking-widest border-b border-blue-100">
                        <th class="px-8 py-5">Nama Anggota</th>
                        <th class="px-8 py-5">Eskul</th>
                        <th class="px-8 py-5 text-center">Total Skor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($penilaians as $p)
                    <tr class="hover:bg-slate-50/50 transition group">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] font-black border border-blue-100">
                                    {{ substr($p->nama_anggota, 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-700 text-sm group-hover:text-blue-600 transition">{{ $p->nama_anggota }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4 text-slate-500 font-semibold uppercase text-xs tracking-wider">
                            {{ $p->eskul }}
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-lg font-black text-xs shadow-sm">
                                {{ $p->total_skor }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-10 text-center text-slate-400 italic">Belum ada data penilaian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <footer class="mt-20 py-8 text-center border-t border-slate-100">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">© 2026 ESKULHUB - CREATIVE DIGITAL SCHOOL</p>
        </footer>
    </main>
</body>
</html>