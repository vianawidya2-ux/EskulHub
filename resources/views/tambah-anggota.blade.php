@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Tambah Anggota Baru</h2>
    
    <form action="{{ route('anggota.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-sm">
        @csrf
        <div class="mb-4">
            <label class="block mb-2">Nama Anggota:</label>
            <input type="text" name="name" class="w-full border rounded-lg p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2">Email:</label>
            <input type="email" name="email" class="w-full border rounded-lg p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2">Password:</label>
            <input type="password" name="password" class="w-full border rounded-lg p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2">Eskul:</label>
            <input type="text" name="eskul" value="{{ Auth::user()->eskul }}" class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            <small class="text-gray-500">*Otomatis disamakan dengan eskul pembina</small>
        </div>
        <button type="submit" class="bg-[#f97316] text-white px-6 py-2 rounded-lg font-bold">
            Simpan Anggota
        </button>
    </form>
</div>
@endsection