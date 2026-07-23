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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->increments('id_pembayaran');
            $table->unsignedInteger('id_santri');
            $table->foreign('id_santri')->references('id_santri')->on('santris')->onDelete('cascade');
            $table->string('bulan');
            $table->year('tahun');
            $table->integer('jumlah');
            $table->enum('status', ['lunas', 'belum']);
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
