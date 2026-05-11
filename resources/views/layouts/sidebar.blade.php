<div class="w-64 bg-[#0f172a] text-white min-h-screen p-6 shadow-xl relative sticky top-0">
    {{-- LOGO AREA --}}
    <div class="text-2xl font-black mb-2 flex items-center gap-3 tracking-tight">
        <div class="bg-blue-600 text-white w-10 h-10 flex items-center justify-center rounded-xl shadow-lg shadow-blue-900/50 overflow-hidden">
            {{-- Menggunakan logo yang konsisten sesuai project EskulHub --}}
            <img src="{{ asset('images/logo 3.0.jpeg') }}" alt="Logo" class="w-full h-full object-cover">
        </div> 
        <span class="text-xl italic font-black uppercase tracking-tighter">Eskul<span class="text-blue-400">Hub</span></span>
    </div>
    
    {{-- INFO USER --}}
    <div class="mb-10 ml-2 mt-4">
        <p class="text-xs font-bold text-slate-300">{{ Auth::user()->name }}</p>
        <p class="text-[10px] text-blue-400 font-medium uppercase tracking-wider">
            Role ID: {{ Auth::user()->role }} - 
            {{ Auth::user()->role == 0 ? 'Admin' : (Auth::user()->role == 1 ? 'Pembina' : 'Anggota') }}
        </p>
    </div>

    <nav class="space-y-1">
        {{-- SECTION 1: MAIN MENU --}}
        <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em] mb-4 ml-2 font-bold">Main Menu</p>
        
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 {{ request()->is('dashboard*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} rounded-xl transition-all duration-200 group">
            <i class="fas fa-home w-5 text-center group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Beranda</span>
        </a>

        <a href="{{ route('penilaian.rangking') }}" class="flex items-center gap-3 p-3 {{ request()->is('*rangking*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} rounded-xl transition-all duration-200 group">
            <i class="fas fa-trophy w-5 text-center group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Ranking</span>
        </a>

        {{-- SECTION 2: MANAJEMEN DATA (Hanya untuk Admin & Pembina) --}}
        @if(Auth::user()->role <= 1)
            <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em] mt-8 mb-4 ml-2 font-bold">Manajemen Data</p>
            
            <a href="{{ route('penilaian.index') }}" class="flex items-center gap-3 p-3 {{ request()->is('*penilaian*') && !request()->is('*rangking*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} rounded-xl transition-all duration-200 group">
                <i class="fas fa-edit w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-semibold">Input Penilaian</span>
            </a>

            <a href="{{ route('absensi.index') }}" class="flex items-center gap-3 p-3 {{ request()->is('*absensi*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} rounded-xl transition-all duration-200 group">
                <i class="fas fa-calendar-check w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-semibold">Absensi Anggota</span>
            </a>

            <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 p-3 {{ request()->is('*laporan*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} rounded-xl transition-all duration-200 group">
                <i class="fas fa-file-pdf w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-semibold">Laporan</span>
            </a>
        @endif

        {{-- SECTION 3: INFORMASI UMUM --}}
        <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em] mt-8 mb-4 ml-2 font-bold">Informasi Umum</p>
        
        <a href="{{ route('sejarah') }}" class="flex items-center gap-3 p-3 {{ request()->is('*sejarah*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} rounded-xl transition-all duration-200 group">
            <i class="fas fa-history w-5 text-center group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Sejarah</span>
        </a>

        <a href="{{ route('eskul.index') }}" class="flex items-center gap-3 p-3 {{ request()->is('*data-eskul*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} rounded-xl transition-all duration-200 group">
            <i class="fas fa-th-large w-5 text-center group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Data Eskul</span>
        </a>

        <a href="{{ route('anggota.index') }}" class="flex items-center gap-3 p-3 {{ request()->is('*data-anggota*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} rounded-xl transition-all duration-200 group">
            <i class="fas fa-users w-5 text-center group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Data Anggota</span>
        </a>
    </nav>

    {{-- LOGOUT BUTTON --}}
    <div class="mt-12 mb-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 p-3 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300 font-bold text-[10px] uppercase tracking-widest">
                <i class="fas fa-sign-out-alt"></i> Logout System
            </button>
        </form>
    </div>
</div>