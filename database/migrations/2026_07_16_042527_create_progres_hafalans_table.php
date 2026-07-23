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
        Schema::create('progres_hafalans', function (Blueprint $table) {
            $table->increments('id_progres');
            $table->unsignedInteger('id_santri');
            $table->enum('caturwulan', ['1', '2', '3']);
            $table->string('tahun_pelajaran')->nullable();
            $table->string('capaian')->nullable();
            $table->enum('status', ['melanjutkan', 'mengulang', 'belum'])->default('belum');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_santri')->references('id_santri')->on('santris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_hafalans');
    }
};
