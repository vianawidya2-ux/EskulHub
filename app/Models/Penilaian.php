<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model {
    protected $table = 'penilaians'; // Pastikan nama tabel sama dengan di database
    protected $fillable = ['nama_anggota', 'eskul', 'nilai_keaktifan', 'nilai_lomba']; 
}