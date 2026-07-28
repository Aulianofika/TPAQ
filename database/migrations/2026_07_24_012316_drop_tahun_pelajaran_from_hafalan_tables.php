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
        Schema::table('target_hafalans', function (Blueprint $table) {
            $table->dropColumn('tahun_pelajaran');
        });
        Schema::table('progres_hafalans', function (Blueprint $table)  {
            $table->dropColumn('tahun_pelajaran');
        });
        Schema::table('riwayat_hafalans', function (Blueprint $table) {
            $table->dropColumn('tahun_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('target_hafalans', function (Blueprint $table) {
            $table->string('tahun_pelajaran')->nullable();
        });
        Schema::table('progres_hafalans', function (Blueprint $table) {
            $table->string('tahun_pelajaran')->nullable();
        });
        Schema::table('riwayat_hafalans', function (Blueprint $table) {
            $table->string('tahun_pelajaran')->nullable();
        });
    }
};
