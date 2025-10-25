<?php

namespace App\Models;

use App\Enums\StatusJadwal;
use Illuminate\Database\Eloquent\Model;

class JadwalPenyuluhan extends Model
{
    protected $table = 'jadwal_penyuluhan';

    protected $primaryKey = 'id_jadwal_penyuluhan';

    protected $guarded = [];

    public function casts(): array {
        return [
            'status' => StatusJadwal::class
        ];
    }

    public function desa() { 
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    public function penyuluh()
    {
        return $this->belongsTo(Penyuluh::class, 'id_penyuluh', 'id_penyuluh');
    }

}
