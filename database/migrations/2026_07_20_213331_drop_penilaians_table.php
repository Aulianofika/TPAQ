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
        Schema::dropIfExists('penilaians');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_santri');
            $table->string('penilaian_akhlak');
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_santri')->references('id_santri')->on('santris')->onDelete('cascade');
        });
    }
};
