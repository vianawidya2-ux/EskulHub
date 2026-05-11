@extends('layouts.app')

@section('content')


    {{-- 2. KONTEN UTAMA --}}
    <main class="flex-1 p-10">
        <section class="max-w-5xl mx-auto">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-600 rounded-2xl flex items-center gap-3 font-bold text-sm shadow-sm">
                <i class="fas fa-check-circle text-lg"></i> {{ session('success') }}
            </div>
            @endif

            {{-- FORM INPUT --}}
            <form action="{{ route('absensi.simpan') }}" method="POST" class="mb-10">
                @csrf
                <div class="bg-white p-8 rounded-[35px] shadow-sm border border-slate-100 relative overflow-hidden">
                    {{-- Dekorasi Aksen --}}
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/5 rounded-full -mr-16 -mt-16"></div>

                    <h3 class="font-bold text-slate-800 text-lg mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-[#f97316] rounded-full"></span>
                        Kirim Kehadiran Saya
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        {{-- NAMA (Otomatis) --}}
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Nama Anda</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="w-full bg-slate-100 border-none rounded-2xl px-5 py-4 text-sm font-bold text-slate-500 cursor-not-allowed" readonly>
                        </div>

                        {{-- UNIT ESKUL --}}
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Unit Eskul</label>
                            <select name="unit_eskul" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-orange-500 cursor-pointer appearance-none" required>
                                <option value="" disabled selected>-- Pilih Eskul --</option>
                                @foreach($list_eskul as $eskul)
                                    <option value="{{ $eskul }}">{{ $eskul }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TANGGAL --}}
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Tanggal</label>
                            <input type="text" value="{{ date('d F Y') }}" class="w-full bg-slate-100 border-none rounded-2xl px-5 py-4 text-sm font-bold text-slate-500 cursor-not-allowed" readonly>
                        </div>

                        {{-- STATUS --}}
                        <div class="md:col-span-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Status Kehadiran</label>
                            <select name="status" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-blue-500 cursor-pointer appearance-none" required>
                                <option value="Hadir">Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Alfa">Alfa</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-slate-800 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg hover:bg-orange-600 hover:shadow-orange-200 transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Presensi Sekarang
                    </button>
                </div>
            </form>

            {{-- TABEL RIWAYAT --}}
            <div class="bg-white rounded-[35px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-lg">Log Kehadiran Terbaru</h3>
                    <span class="text-[10px] bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-black uppercase tracking-tighter">Real-time Data</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-blue-600 uppercase tracking-widest border-b border-blue-50 bg-blue-50/30">
                                <th class="px-8 py-5">Nama Anggota</th>
                                <th class="px-8 py-5">Unit Eskul</th>
                                <th class="px-8 py-5">Tanggal</th>
                                <th class="px-8 py-5">Status</th>
                                @if(Auth::user()->role <= 1) <th class="px-8 py-5 text-center">Aksi</th> @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($absensi as $data)
                            <tr class="hover:bg-slate-50/80 transition-all group">
                                <td class="px-8 py-4 font-bold text-slate-700 text-sm">
                                    {{ $data->nama_manual ?? $data->user->name }}
                                </td>
                                <td class="px-8 py-4 text-xs font-semibold text-slate-500">
                                    <span class="bg-slate-100 px-2 py-1 rounded-md">{{ $data->unit_eskul ?? 'Umum' }}</span>
                                </td>
                                <td class="px-8 py-4 text-sm text-slate-400 italic">
                                    {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-8 py-4">
                                    <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase 
                                        {{ $data->status == 'Hadir' ? 'bg-green-100 text-green-600' : '' }}
                                        {{ $data->status == 'Sakit' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                        {{ $data->status == 'Izin' ? 'bg-blue-100 text-blue-600' : '' }}
                                        {{ $data->status == 'Alfa' ? 'bg-red-100 text-red-600' : '' }}">
                                        {{ $data->status }}
                                    </span>
                                </td>
                                @if(Auth::user()->role <= 1)
                                <td class="px-8 py-4 text-center">
                                    <form action="{{ route('absensi.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Hapus data absensi ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <i class="fas fa-folder-open text-4xl text-slate-200"></i>
                                        <p class="text-slate-400 italic font-bold text-sm">Belum ada rekaman kehadiran hari ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection