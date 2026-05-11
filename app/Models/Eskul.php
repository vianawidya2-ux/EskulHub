<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eskul extends Model
{
    use HasFactory;

    // Tambahkan ini jika nama tabel kamu di database adalah 'eskuls'
    protected $table = 'eskuls'; 
    
    // Sesuaikan field yang boleh diisi
    protected $fillable = ['nama_eskul']; 
}