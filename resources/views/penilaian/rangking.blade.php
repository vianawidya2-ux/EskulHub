@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-12">
    
    {{-- BAGIAN 1: RANGKING SISWA --}}
    <div>
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Peringkat Anggota Terbaik</h1>
            <p class="text-gray-500 text-sm">Berdasarkan akumulasi nilai keaktifan dan prestasi lomba.</p>
        </div>
        <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-50">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 text-[10px] uppercase tracking-widest text-gray-400">
                    <tr>
                        <th class="px-8 py-5 text-center text-black">Posisi</th>
                        <th class="px-8 py-5 text-black">Nama Anggota</th>
                        <th class="px-8 py-5 text-black">Eskul</th>
                        <th class="px-8 py-5 text-center text-black">Total Skor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($peringkat as $index => $data)
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-8 py-6 text-center font-bold">{{ $index + 1 }}</td>
                            <td class="px-8 py-6 font-semibold text-gray-700">{{ $data->nama_anggota }}</td>
                            <td class="px-8 py-6 text-gray-500">{{ $data->eskul }}</td>
                            <td class="px-8 py-6 text-center">
                                <span class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-bold">{{ $data->total_skor }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- BAGIAN 2: RANGKING ESKUL TERAKTIF (BERDASARKAN LAPORAN) --}}
    <div>
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Eskul Teraktif</h1>
            <p class="text-gray-500 text-sm">Peringkat berdasarkan jumlah laporan kegiatan yang telah diunggah.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($rangking_eskul as $index => $eskul)
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm relative overflow-hidden group hover:border-blue-500 transition-all">
                    <div class="relative z-10">
                        <div class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-2">Rank #{{ $index + 1 }}</div>
                        <h3 class="text-xl font-black text-gray-800 mb-1">{{ $eskul->nama_eskul }}</h3>
                        <p class="text-gray-500 text-sm font-medium">{{ $eskul->total_laporan }} Laporan Kegiatan</p>
                    </div>
                    {{-- Dekorasi angka besar di background --}}
                    <div class="absolute -right-4 -bottom-4 text-8xl font-black text-gray-50 opacity-10 group-hover:text-blue-100 transition-colors">
                        {{ $index + 1 }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection