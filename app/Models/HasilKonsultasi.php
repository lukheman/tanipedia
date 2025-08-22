<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilKonsultasi extends Model
{
    protected $table = 'hasil_konsultasi';

    protected $primaryKey = 'id_solusi';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Penyuluh::class, 'id_user', 'id_penyuluh');
    }

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class, 'id_konsultasi');
    }
}
