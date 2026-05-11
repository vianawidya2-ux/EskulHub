<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EskulHub - Dashboard</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .sidebar-active { background: #2563eb !important; color: white !important; font-weight: 800 !important; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3); }
        
        /* Smooth transition untuk mobile sidebar */
        #sidebar { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-[#f8fafc] min-h-screen flex overflow-x-hidden"> {{-- Ganti overflow-hidden jadi overflow-x-hidden --}}

    {{-- OVERLAY --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/60 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-[#0f172a] text-white flex-shrink-0 shadow-2xl p-6 flex flex-col z-50 transform -translate-x-full lg:translate-x-0 lg:static lg:w-64 transition-transform">
        <div class="flex items-center justify-between mb-10 px-2">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center overflow-hidden shadow-lg border border-white/10">
                    <img src="{{ asset('images/logo 3.0.jpeg') }}" alt="Logo" class="w-full h-full object-cover">
                </div>
                <h1 class="text-xl font-black tracking-tight text-white italic">Eskul<span class="text-blue-400">Hub</span></h1>
            </div>
            <button id="closeSidebar" class="lg:hidden text-slate-400 hover:text-white p-2">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>

        <nav class="space-y-1.5 flex-1 overflow-y-auto pr-2">
            <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em] mb-4 ml-2 font-bold">Menu Utama</p>
            
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-white/5 p-3 rounded-xl transition px-4 {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-house w-5 text-center text-sm"></i>
                <span class="text-sm font-semibold">Beranda</span>
            </a>

            <a href="{{ route('penilaian.rangking') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-white/5 p-3 rounded-xl transition px-4 {{ request()->routeIs('penilaian.rangking') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-trophy w-5 text-center text-sm"></i>
                <span class="text-sm font-semibold">Ranking</span>
            </a>

            <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em] mt-8 mb-4 ml-2 font-bold">Informasi Umum</p>
            
            <a href="{{ route('sejarah') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-white/5 p-3 rounded-xl transition px-4 {{ request()->routeIs('sejarah') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-history w-5 text-center text-sm"></i>
                <span class="text-sm font-semibold">Sejarah</span>
            </a>

            <a href="{{ route('eskul.index') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-white/5 p-3 rounded-xl transition px-4 {{ request()->routeIs('eskul.index') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-layer-group w-5 text-center text-sm"></i>
                <span class="text-sm font-semibold">Data Eskul</span>
            </a>

            <a href="{{ route('anggota.index') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-white/5 p-3 rounded-xl transition px-4 {{ request()->routeIs('anggota.index') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-users w-5 text-center text-sm"></i>
                <span class="text-sm font-semibold">Data Anggota</span>
            </a>

            <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em] mt-8 mb-4 ml-2 font-bold">Manajemen Data</p>
            
            @if(Auth::user()->role == 0 || Auth::user()->role == 1)
            <a href="{{ route('penilaian.index') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-white/5 p-3 rounded-xl transition px-4 {{ request()->routeIs('penilaian.index') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-file-signature w-5 text-center text-sm"></i>
                <span class="text-sm font-semibold">Input Nilai</span>
            </a>
            @endif

            <a href="{{ route('absensi.index') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-white/5 p-3 rounded-xl transition px-4 {{ request()->routeIs('absensi.index') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-calendar-check w-5 text-center text-sm"></i>
                <span class="text-sm font-semibold">Absensi</span>
            </a>

            <a href="{{ route('laporan.index') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-white/5 p-3 rounded-xl transition px-4 {{ request()->routeIs('laporan.index') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-file-pdf w-5 text-center text-sm"></i>
                <span class="text-sm font-semibold">Laporan</span>
            </a>
        </nav>

        <div class="mt-auto p-4 bg-white/5 rounded-2xl border border-white/5">
            <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-1">Unit: {{ Auth::user()->eskul ?? '-' }}</p>
            <p class="text-[11px] font-bold text-blue-400 uppercase">
                @if(Auth::user()->role == 0) Admin
                @elseif(Auth::user()->role == 1) Pembina
                @else Siswa
                @endif
            </p>
        </div>
    </aside>

    {{-- CONTENT AREA --}}
    <div class="flex-1 flex flex-col min-h-screen w-full">
        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-100 p-4 flex justify-between items-center px-4 lg:px-10 shrink-0 z-30 shadow-sm">
            <div class="flex items-center gap-3">
                <button id="openSidebar" class="lg:hidden text-slate-600 p-2 hover:bg-slate-50 rounded-lg transition-colors">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                
                <div class="flex flex-col">
                    <h2 class="text-slate-800 font-black text-base lg:text-lg tracking-tight leading-none">EskulHub</h2>
                    <p class="text-slate-400 text-[8px] lg:text-[10px] font-bold tracking-widest uppercase italic mt-0.5">SMK Negeri 15 Bekasi</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2 lg:gap-6">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-slate-700 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] text-slate-400 mt-1 font-semibold uppercase">Staff Unit</p>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white w-10 h-10 lg:w-auto lg:px-5 lg:py-2.5 rounded-xl flex items-center justify-center transition-all active:scale-95 shadow-lg shadow-red-200">
                        <i class="fa-solid fa-power-off lg:hidden"></i>
                        <span class="hidden lg:inline text-[10px] font-black tracking-widest">LOGOUT</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto bg-[#f8fafc] p-4 lg:p-8">
            {{-- Hapus max-w-7xl agar benar-benar penuh --}}
            <div class="w-full mx-auto space-y-6">
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl shadow-sm animate-pulse">
                        <p class="text-xs font-bold uppercase">AKSES DITOLAK: {{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            // Mencegah body scroll saat sidebar buka di mobile
            document.body.classList.toggle('overflow-hidden');
        }

        openBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>

</body>
</html>