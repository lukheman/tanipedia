<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';

    protected $primaryKey = 'id_konsultasi';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_petani');
    }

    public function hasil()
    {
        return $this->hasOne(HasilKonsultasi::class, 'id_solusi', 'id_solusi');
    }
}
