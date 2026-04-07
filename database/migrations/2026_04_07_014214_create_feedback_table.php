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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_aspirasi', false, true)->index();
            $table->bigInteger('admin_id', false, true)->index();
            $table->text('message');
            $table->timestamps();
            $table->index('created_at');
            
            $table->foreign('id_aspirasi')->references('id_aspirasi')->on('aspirasis')->cascadeOnDelete();
            $table->foreign('admin_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
