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
        // First, clear out non-numeric values since they can't be converted to decimal
        DB::table('eraports')->update([
            'ekstra_subuh' => null,
            'ekstra_rebana' => null,
            'ekstra_olahraga' => null
        ]);

        Schema::table('eraports', function (Blueprint $table) {
            // Using DB::statement for altering ENUM/VARCHAR to DECIMAL because 
            // doctrine/dbal sometimes struggles with complex type changes
            DB::statement("ALTER TABLE eraports MODIFY ekstra_subuh DECIMAL(5,2) NULL");
            DB::statement("ALTER TABLE eraports MODIFY ekstra_rebana DECIMAL(5,2) NULL");
            DB::statement("ALTER TABLE eraports MODIFY ekstra_olahraga DECIMAL(5,2) NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eraports', function (Blueprint $table) {
            DB::statement("ALTER TABLE eraports MODIFY ekstra_subuh VARCHAR(255) NULL");
            DB::statement("ALTER TABLE eraports MODIFY ekstra_rebana VARCHAR(255) NULL");
            DB::statement("ALTER TABLE eraports MODIFY ekstra_olahraga VARCHAR(255) NULL");
        });
    }
};
