<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilKonsultasi extends Model
{
    public $table = 'hasil_konsultasi';

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class, 'id_konsultasi');
    }
}
