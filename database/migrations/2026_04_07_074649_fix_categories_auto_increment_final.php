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
        Schema::table('input_aspirasi', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->integer('id_kategori', true, true)->autoIncrement()->change();
        });

        Schema::table('input_aspirasi', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('input_aspirasi', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->integer('id_kategori', false, true)->change();
        });

        Schema::table('input_aspirasi', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->cascadeOnDelete();
        });
    }
};
