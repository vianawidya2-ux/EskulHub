@extends('layouts.app')

@section('content')
<main class="p-6 lg:p-10">
    <header class="flex justify-between items-center mb-8">
        <div class="flex flex-col">
            <h2 class="text-slate-800 font-extrabold text-2xl">Data Ekstrakurikuler</h2>
            <p class="text-slate-400 text-[10px] font-bold tracking-widest uppercase italic">Dashboard > Data Eskul</p>
        </div>
    </header>

    <div class="bg-white rounded-[30px] shadow-sm border border-slate-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-50/50 text-blue-600 uppercase text-[10px] font-black tracking-widest border-b border-blue-100">
                        <th class="px-8 py-4">Nama Eskul</th>
                        <th class="px-8 py-4">Pembina</th>
                        <th class="px-8 py-4 text-center">Keaktifan Anggota</th>
                        <th class="px-8 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($eskuls as $e)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-5 font-bold text-slate-700 text-sm">{{ $e->nama_eskul }}</td>
                        <td class="px-8 py-5 text-slate-500 text-sm">{{ $e->nama_pembina }}</td>
                        <td class="px-8 py-5 text-center">
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg text-[10px] font-black">
                                {{ $e->jumlah_aktif }} / {{ $e->jumlah_anggota }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="{{ $e->status_keaktifan == 'Aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} px-3 py-1 rounded-lg text-[10px] font-black uppercase">
                                ● {{ $e->status_keaktifan }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-10 text-center">Data Kosong</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection