<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('eskuls', function (Blueprint $table) {
            // Menambahkan kolom id_pembina setelah kolom id.
            // Digunakan untuk menghubungkan eskul dengan user yang memiliki Role Pembina.
            $table->unsignedBigInteger('id_pembina')->nullable()->after('id');

            // Menambahkan foreign key agar data konsisten dengan tabel users
            $table->foreign('id_pembina')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eskuls', function (Blueprint $table) {
            // Menghapus foreign key dan kolom jika migration di-rollback
            $table->dropForeign(['id_pembina']);
            $table->dropColumn('id_pembina');
        });
    }
};