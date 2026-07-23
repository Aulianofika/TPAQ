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
        Schema::create('eraports', function (Blueprint $table) {
            $table->increments('id_eraport');
            
            $table->unsignedInteger('id_santri');
            $table->foreign('id_santri')->references('id_santri')->on('santris')->cascadeOnDelete();
            
            $table->string('kelompok', 25)->nullable();
            $table->string('tahun_pelajaran', 20)->nullable();
            
            $table->decimal('nilai_tajwid', 5, 2)->nullable();
            $table->decimal('nilai_fashahah', 5, 2)->nullable();
            $table->decimal('nilai_irama', 5, 2)->nullable();
            $table->decimal('nilai_adab', 5, 2)->nullable();
            $table->decimal('nilai_ibadah', 5, 2)->nullable();
            $table->decimal('nilai_doa', 5, 2)->nullable();
            $table->decimal('nilai_surat', 5, 2)->nullable();
            $table->decimal('nilai_sejarah', 5, 2)->nullable();
            $table->decimal('nilai_dakwah', 5, 2)->nullable();
            $table->decimal('nilai_akhlak', 5, 2)->nullable();
            
            $table->enum('ekstra_subuh', ['A', 'B', 'C', 'D'])->nullable();
            $table->enum('ekstra_rebana', ['A', 'B', 'C', 'D'])->nullable();
            $table->enum('ekstra_olahraga', ['A', 'B', 'C', 'D'])->nullable();
            
            $table->enum('sikap_disiplin', ['A', 'B', 'C', 'D'])->nullable();
            $table->enum('sikap_kebersihan', ['A', 'B', 'C', 'D'])->nullable();
            
            $table->unsignedTinyInteger('absen_sakit')->default(0);
            $table->unsignedTinyInteger('absen_izin')->default(0);
            $table->unsignedTinyInteger('absen_alpa')->default(0);
            
            $table->decimal('jumlah_nilai', 8, 2)->nullable();
            $table->decimal('rata_rata', 5, 2)->nullable();
            
            $table->string('kepala_tpa', 50)->nullable();
            $table->string('nama_pengajar', 50)->nullable();
            
            $table->date('tanggal_pelaporan')->nullable();
            $table->text('catatan_guru')->nullable();
            
            $table->unsignedTinyInteger('caturwulan')->nullable();
            $table->enum('status_kenaikan', ['Naik', 'Tetap', 'Lulus'])->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eraports');
    }
};
