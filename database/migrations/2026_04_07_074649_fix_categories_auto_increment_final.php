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
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
        });

        Schema::table('input_aspirasi', function (Blueprint $table) {
            // Check if foreign key exists before dropping it to avoid errors
            $foreignKeys = Schema::getForeignKeys('input_aspirasi');
            $hasForeignKey = collect($foreignKeys)->contains(fn ($fk) => $fk['columns'] === ['id_kategori']);

            if ($hasForeignKey) {
                $table->dropForeign(['id_kategori']);
            }
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->integer('id_kategori', true, true)->autoIncrement()->change();
        });

        Schema::table('input_aspirasi', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->cascadeOnDelete();
        });

        Schema::table('aspirasis', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
        });

        Schema::table('input_aspirasi', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->integer('id_kategori', false, true)->change();
        });

        Schema::table('input_aspirasi', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->cascadeOnDelete();
        });

        Schema::table('aspirasis', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->cascadeOnDelete();
        });
    }
};
