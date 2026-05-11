@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-slate-900 p-8 text-white">
            <h2 class="text-2xl font-black italic uppercase tracking-tighter">Tambah Anggota Baru</h2>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Input data siswa untuk unit eskul</p>
        </div>

        <form action="{{ route('anggota.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-sm font-bold text-slate-700">
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Email</label>
                    <input type="email" name="email" required placeholder="budi@example.com"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-sm font-bold text-slate-700">
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-sm font-bold text-slate-700">
                </div>

                {{-- Kelas --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kelas</label>
                    <select name="kelas" required
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-sm font-bold text-slate-700">
                        <optgroup label="KELAS X">
                            <option value="X FARMASI 1">X FARMASI 1</option>
                            <option value="X FARMASI 2">X FARMASI 2</option>
                            <option value="X FARMASI 3">X FARMASI 3</option>
                            <option value="X TJKT 1">X TJKT 1</option>
                            <option value="X TJKT 2">X TJKT 2</option>
                            <option value="X TK 1">X TK 1</option>
                            <option value="X TK 2">X TK 2</option>
                            <option value="X TM 1">X TM 1</option>
                            <option value="X TM 2">X TM 2</option>
                            <option value="X KDS 1">X KDS 1</option>
                        </optgroup>
                        <optgroup label="KELAS XI">
                            <option value="XI FARMASI 1">XI FARMASI 1</option>
                            <option value="XI FARMASI 2">XI FARMASI 2</option>
                            <option value="XI FARMASI 3">XI FARMASI 3</option>
                            <option value="XI FARMASI 4">XI FARMASI 4</option>
                            <option value="XI TJKT 1">XI TJKT 1</option>
                            <option value="XI TJKT 2">XI TJKT 2</option>
                            <option value="XI TJKT 3">XI TJKT 3</option>
                            <option value="XI TK 1">XI TK 1</option>
                            <option value="XI TK 2">XI TK 2</option>
                            <option value="XI TM 1">XI TM 1</option>
                            <option value="XI TM 2">XI TM 2</option>
                            <option value="XI KDS 1">XI KDS 1</option>
                        </optgroup>
                        <optgroup label="KELAS XII">
                            <option value="XII FARMASI 1">XII FARMASI 1</option>
                            <option value="XII FARMASI 2">XII FARMASI 2</option>
                            <option value="XII FARMASI 3">XII FARMASI 3</option>
                            <option value="XII TJKT 1">XII TJKT 1</option>
                            <option value="XII TJKT 2">XII TJKT 2</option>
                            <option value="XII TK 1">XII TK 1</option>
                            <option value="XII TK 2">XII TK 2</option>
                            <option value="XII TM 1">XII TM 1</option>
                            <option value="XII TM 2">XII TM 2</option>
                        </optgroup>
                        {{-- Tambahkan kelas lainnya sesuai kebutuhan --}}
                    </select>
                </div>

                {{-- Eskul --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Unit Eskul</label>
                    <select name="eskul" required
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-sm font-bold text-slate-700">
                        <option value="">Pilih Eskul</option>
                        @foreach($listEskul as $eskul)
                            <option value="{{ $eskul }}">{{ $eskul }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('anggota.index') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest">Batal</a>
                <button type="submit" 
                    class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-blue-200 transition-all transform hover:scale-105">
                    Simpan Anggota
                </button>
            </div>
        </form>
    </div>
</div>
@endsection