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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id('id_konsultasi');
            $table->foreignId('id_petani')->constrained('petani', 'id_petani')->cascadeOnDelete();
            $table->foreignId('id_solusi')->nullable()->constrained('hasil_konsultasi', 'id_solusi');
            $table->foreignId('id_tanaman')->constrained('tanaman', 'id_tanaman')->cascadeOnDelete();
            $table->text('isi');
            $table->date('tanggal_konsultasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
