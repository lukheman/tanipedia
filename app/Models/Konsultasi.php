<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';

    protected $primaryKey = 'id_konsultasi';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_petani', 'id_petani');
    }

    public function hasil()
    {
        return $this->hasOne(HasilKonsultasi::class, 'id_solusi', 'id_solusi');
    }

    public function tanaman(): BelongsTo
    {
        return $this->belongsTo(Tanaman::class, 'id_tanaman', 'id_tanaman');
    }
}
