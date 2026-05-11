@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto p-6">
    {{-- Hero Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-16">
        <div class="max-w-md text-center md:text-left">
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Jejak Langkah <span class="text-blue-600">{{ $sejarah->nama_eskul ?? auth()->user()->eskul }}</span>
            </h1>
            <p class="text-slate-500 text-sm mt-4 leading-relaxed font-medium">
                Mengenal lebih dekat perjalanan transformasi unit ekstrakurikuler kita dari masa ke masa.
            </p>
        </div>
        <img src="https://illustrations.popsy.co/blue/school-building.svg" class="w-56 opacity-90 drop-shadow-2xl hover:rotate-2 transition-transform duration-500" alt="Sekolah">
    </div>

    {{-- Konten Utama Sejarah --}}
    <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-50 mb-16 relative overflow-hidden group hover:shadow-xl hover:shadow-blue-500/5 transition-all">
        <div class="flex flex-col md:flex-row items-start gap-8 relative z-10">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-xl shadow-blue-100">
                <i class="fas fa-scroll text-2xl"></i>
            </div>
            <div class="space-y-6 flex-1">
                <h3 class="font-extrabold text-slate-800 text-2xl tracking-tight">Catatan Sejarah</h3>
                
                <div class="text-slate-600 leading-relaxed text-base font-medium italic border-l-4 border-blue-500 pl-6 py-2">
                    @if($sejarah)
                        {{-- nl2br untuk menjaga baris baru dari database --}}
                        {!! nl2br(e($sejarah->konten_sejarah)) !!}
                    @else
                        <p class="text-slate-400">Data sejarah untuk eskul <strong>{{ auth()->user()->eskul }}</strong> belum diinput di database.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
    </div>

    {{-- Info Tambahan (Opsional) --}}
    <h3 class="font-extrabold text-slate-800 text-2xl mb-8 flex items-center gap-4">
        <span class="w-12 h-1.5 bg-blue-600 rounded-full"></span>
        Informasi Unit
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Terakhir Diperbarui</p>
            <p class="text-sm font-bold text-slate-700">
                {{ $sejarah ? $sejarah->updated_at->format('d F Y') : '-' }}
            </p>
        </div>
        <div class="p-6 bg-blue-600 rounded-3xl shadow-lg shadow-blue-100">
            <p class="text-[10px] font-black text-blue-200 uppercase tracking-widest mb-2">Status Data</p>
            <p class="text-sm font-bold text-white">Terverifikasi Sistem EskulHub</p>
        </div>
    </div>
</section>
@endsection