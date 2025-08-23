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
        Schema::create('edukasi', function (Blueprint $table) {
            $table->id('id_video');
            $table->foreignId('id_admin')->constrained('admin', 'id_admin')->cascadeOnDelete();
            $table->string('judul');
            $table->date('tanggal_publikasi');
            $table->string('deskripsi');
            $table->string('url_video');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edukasi');
    }
};
