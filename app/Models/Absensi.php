<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'user_id',
        'nama_manual',
        'unit_eskul', // Pakai ini agar sinkron dengan form
        'status',
        'tanggal',
        'keterangan'
    ];

    public function user()
    {
        // Relasi agar bisa panggil $data->user->name
        return $this->belongsTo(User::class, 'user_id');
    }
}