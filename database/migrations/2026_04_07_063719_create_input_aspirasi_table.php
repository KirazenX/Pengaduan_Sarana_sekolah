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
        Schema::create('input_aspirasi', function (Blueprint $table) {
            $table->bigIncrements('id_pelaporan');
            $table->string('nis', 20)->index();
            $table->integer('id_kategori', false, true)->index();
            $table->string('lokasi', 50);
            $table->string('keterangan', 50);
            $table->timestamps();
            
            $table->foreign('nis')->references('nis')->on('users')->cascadeOnDelete();
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_aspirasi');
    }
};
