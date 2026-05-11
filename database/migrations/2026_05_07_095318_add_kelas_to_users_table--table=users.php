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
        Schema::table('users', function (Blueprint $table) {
            // Kita tambah kolom kelas setelah kolom eskul biar rapi
            $table->string('kelas')->nullable()->after('eskul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ini untuk hapus kolom kalau migration di-rollback
            $table->dropColumn('kelas');
        });
    }
};