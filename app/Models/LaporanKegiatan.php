<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Tambahkan ini agar lebih jelas

class LaporanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kegiatans';

    protected $fillable = [
        'user_id',            
        'nama_eskul',
        'judul_kegiatan',     // Pastikan nama kolom di DB sama dengan ini
        'tanggal_kegiatan',
        'deskripsi_kegiatan',
        'jumlah_hadir',
        'jumlah_izin',
        'status',             
    ];

    /**
     * Relasi ke Model User
     * Menghubungkan laporan ke siswa yang mengirimnya.
     */
    public function user()
    {
        // withDefault() sangat penting! 
        // Jika user_id kosong, dia akan mengembalikan objek kosong 
        // sehingga kodenya tidak akan error "Property on null".
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => 'Siswa Tidak Ditemukan'
        ]);
    }
}