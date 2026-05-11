<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('laporan_kegiatans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_eskul');
        $table->date('tanggal_kegiatan');
        $table->text('deskripsi_kegiatan'); // Untuk narasi kegiatan ngapain aja
        $table->integer('jumlah_hadir');
        $table->integer('jumlah_izin');
        $table->integer('jumlah_sakit')->default(0);
        $table->timestamps();
    });
}
};
