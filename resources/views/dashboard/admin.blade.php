<!-- {{-- resources/views/dashboard/admin.blade.php --}}

<div class="space-y-6">
    {{-- Header Welcome --}}
    <div class="bg-gradient-to-r from-[#1e3a8a] to-blue-600 rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold mb-2">Halo, Admin Pusat! 👋</h1>
            <p class="text-blue-100 opacity-90">Hari ini adalah waktu yang tepat untuk memantau perkembangan seluruh ekstrakurikuler.</p>
        </div>
        {{-- Dekorasi Bulat di Background --}}
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
        <div class="absolute right-20 -bottom-10 w-24 h-24 bg-white opacity-5 rounded-full"></div>
    </div>

    {{-- Statistik Ringkas (Stats Cards) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Total Siswa</p>
                <h3 class="text-2xl font-bold text-slate-800">1,240</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-50 text-[#f97316] rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-flag"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Unit Eskul</p>
                <h3 class="text-2xl font-bold text-slate-800">24</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Pembina</p>
                <h3 class="text-2xl font-bold text-slate-800">18</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Laporan</p>
                <h3 class="text-2xl font-bold text-slate-800">42</h3>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- List Unit Eskul Terpopuler --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-slate-800">Manajemen Unit Eskul</h2>
                <button class="text-sm font-bold text-blue-600 hover:underline">Lihat Semua</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-sm uppercase tracking-wider">
                            <th class="pb-4 font-semibold">Nama Eskul</th>
                            <th class="pb-4 font-semibold">Pembina</th>
                            <th class="pb-4 font-semibold text-center">Anggota</th>
                            <th class="pb-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr>
                            <td class="py-4 font-bold text-slate-700 italic">Pramuka</td>
                            <td class="py-4 text-slate-600 text-sm">Bpk. Ahmad Suhendar</td>
                            <td class="py-4 text-center"><span class="bg-slate-100 px-3 py-1 rounded-full text-xs font-bold">120 Orang</span></td>
                            <td class="py-4 text-center">
                                <button class="text-blue-500 hover:text-blue-700 mx-1"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="text-red-500 hover:text-red-700 mx-1"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 font-bold text-slate-700 italic">Paskibra</td>
                            <td class="py-4 text-slate-600 text-sm">Ibu Siti Aminah</td>
                            <td class="py-4 text-center"><span class="bg-slate-100 px-3 py-1 rounded-full text-xs font-bold">85 Orang</span></td>
                            <td class="py-4 text-center">
                                <button class="text-blue-500 hover:text-blue-700 mx-1"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="text-red-500 hover:text-red-700 mx-1"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Log Aktivitas</h2>
            <div class="space-y-6">
                <div class="flex gap-4">
                    <div class="w-2 h-2 mt-2 rounded-full bg-blue-500 shrink-0"></div>
                    <div>
                        <p class="text-sm font-bold text-slate-700">Pendaftaran Pembina Baru</p>
                        <p class="text-[11px] text-slate-400">Baru saja • Pak Budi (PMR)</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-2 h-2 mt-2 rounded-full bg-orange-500 shrink-0"></div>
                    <div>
                        <p class="text-sm font-bold text-slate-700">Laporan Bulanan Masuk</p>
                        <p class="text-[11px] text-slate-400">2 jam yang lalu • Pramuka</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-2 h-2 mt-2 rounded-full bg-green-500 shrink-0"></div>
                    <div>
                        <p class="text-sm font-bold text-slate-700">Sistem Berhasil Backup</p>
                        <p class="text-[11px] text-slate-400">5 jam yang lalu • System</p>
                    </div>
                </div>
            </div>
            
            <button class="w-full mt-8 py-3 bg-slate-50 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-100 transition">
                Lihat Log Lengkap
            </button>
        </div>
    </div>
</div> -->