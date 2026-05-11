<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sejarah extends Model
{
    // Tambahkan baris ini karena nama tabel kamu unik (sejarah)
    protected $table = 'sejarah'; 

    protected $fillable = [
        'nama_eskul',
        'konten_sejarah'
    ];
}