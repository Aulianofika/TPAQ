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
        // 1. Move data where jenis = 'pengurus' to pengurus table
        $pengurus = DB::table('pengajars')->where('jenis', 'pengurus')->get();
        
        foreach ($pengurus as $p) {
            DB::table('pengurus')->insert([
                'nama' => $p->nama,
                'jenis_kelamin' => $p->jenis_kelamin ?? 'L',
                'is_kepala' => $p->is_kepala ?? false,
                'no_hp' => $p->no_hp,
                'alamat' => $p->alamat,
                'quote' => $p->quote,
                'foto' => $p->foto,
                'user_id' => $p->user_id,
                'created_at' => $p->created_at,
                'updated_at' => $p->updated_at,
            ]);
        }
        
        // 2. Delete the moved records from pengajars table
        DB::table('pengajars')->where('jenis', 'pengurus')->delete();

        // 3. Drop columns from pengajars table
        Schema::table('pengajars', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'is_kepala', 'quote']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
