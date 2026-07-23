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
        Schema::create('pengurus', function (Blueprint $table) {
            $table->increments('id_pengurus');
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->boolean('is_kepala')->default(false);
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->text('quote')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedInteger('id_user')->nullable()->nullOnDelete();
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengurus');
    }
};
