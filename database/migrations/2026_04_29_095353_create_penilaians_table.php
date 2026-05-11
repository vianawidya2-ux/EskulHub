<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('penilaians', function (Blueprint $table) {
        $table->id();
        $table->string('nama_anggota');
        $table->string('eskul');
        $table->integer('nilai_keaktifan')->default(0);
        $table->integer('nilai_lomba')->default(0);
        $table->string('keterangan_lomba')->nullable();
        $table->timestamps();
    });
}
};