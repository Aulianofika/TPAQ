<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE eraports MODIFY ekstra_subuh VARCHAR(255) NULL");
        DB::statement("ALTER TABLE eraports MODIFY ekstra_rebana VARCHAR(255) NULL");
        DB::statement("ALTER TABLE eraports MODIFY ekstra_olahraga VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE eraports MODIFY ekstra_subuh ENUM('A', 'B', 'C', 'D') NULL");
        DB::statement("ALTER TABLE eraports MODIFY ekstra_rebana ENUM('A', 'B', 'C', 'D') NULL");
        DB::statement("ALTER TABLE eraports MODIFY ekstra_olahraga ENUM('A', 'B', 'C', 'D') NULL");
    }
};
