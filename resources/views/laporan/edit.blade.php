@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama kamu --}}

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-2xl shadow-sm p-8 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Edit Laporan Kegiatan</h2>

        <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul Kegiatan</label>
                    <input type="text" name="judul_kegiatan" value="{{ $laporan->judul_kegiatan }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Kegiatan</label>
                    <input type="date" name="tanggal_kegiatan" value="{{ $laporan->tanggal_kegiatan }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">{{ $laporan->deskripsi_kegiatan }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Hadir</label>
                        <input type="number" name="jumlah_hadir" value="{{ $laporan->jumlah_hadir }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Izin</label>
                        <input type="number" name="jumlah_izin" value="{{ $laporan->jumlah_izin }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status Validasi</label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Menunggu" {{ $laporan->status == 'Menunggu' ? 'selected' : '' }}>MENUNGGU</option>
                        <option value="Lunas" {{ $laporan->status == 'Lunas' ? 'selected' : '' }}>LUNAS</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                <a href="{{ route('dashboard') }}" class="bg-slate-100 text-slate-600 px-6 py-2 rounded-lg font-bold hover:bg-slate-200 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection