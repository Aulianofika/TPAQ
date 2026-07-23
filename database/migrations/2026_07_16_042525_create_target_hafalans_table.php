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
        Schema::create('target_hafalans', function (Blueprint $table) {
            $table->increments('id_target');
            $table->unsignedInteger('id_kelas');
            $table->enum('caturwulan', ['1', '2', '3']);
            $table->string('tahun_pelajaran')->nullable();
            $table->string('target');
            $table->timestamps();

            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_hafalans');
    }
};
