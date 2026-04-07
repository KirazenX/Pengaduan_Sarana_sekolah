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
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->bigIncrements('id_aspirasi');
            $table->bigInteger('id_pelaporan', false, true)->index();
            $table->integer('id_kategori', false, true)->index();
            $table->enum('status', ['Menunggu', 'Proses', 'Selesai'])->default('Menunggu')->index();
            $table->timestamps();
            $table->index('created_at');
            
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirasis');
    }
};
