<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    public $table = 'konsultasi';

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function hasil()
    {
        return $this->hasOne(HasilKonsultasi::class, 'id', 'id_solusi');
    }
}
