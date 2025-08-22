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
        Schema::create('penyuluh', function (Blueprint $table) {
            $table->id('id_penyuluh');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->default(bcrypt('password123'));
            $table->string('telepon');
            $table->date('tanggal_lahir');
            $table->string('photo')->nullable();
            $table->string('alamat')->nullable();
            $table->foreignId('id_desa')->nullable()->constrained('desa', 'id_desa')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyuluh');
    }
};
