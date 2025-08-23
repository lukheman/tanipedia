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
        Schema::create('hasil_konsultasi', function (Blueprint $table) {
            $table->id('id_solusi');
            $table->foreignId('id_penyuluh')->constrained('penyuluh', 'id_penyuluh')->cascadeOnDelete();
            $table->text('isi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_konsultasi');
    }
};
