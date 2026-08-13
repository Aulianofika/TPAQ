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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->after('tanggal_bayar');
            $table->string('dicatat_oleh')->nullable()->after('bukti_pembayaran');
            $table->text('keterangan')->nullable()->after('dicatat_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'dicatat_oleh', 'keterangan']);
        });
    }
};
