<?php

use App\Enums\StatusJadwal;
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
        Schema::create('jadwal_penyuluhan', function (Blueprint $table) {
            $table->id('id_jadwal_penyuluhan');
            $table->foreignId('id_penyuluh')
                ->constrained('penyuluh', 'id_penyuluh')
                ->cascadeOnDelete();
            $table->foreignId('id_desa')
                ->constrained('desa', 'id_desa') // sesuaikan dengan nama tabel desa kamu
                ->cascadeOnDelete();

            $table->date('tanggal');
            $table->text('kegiatan')->nullable();
            $table->text('laporan')->nullable();
            $table->enum('status', StatusJadwal::values())->default(StatusJadwal::DIJADWALKAN->value);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_penyuluhan');
    }
};
