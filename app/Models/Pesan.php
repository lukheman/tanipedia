<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\Role;

class Pesan extends Model
{
    protected $table = 'pesan';
    protected $guarded = [];

    protected $casts = [
        'role_pengirim' => Role::class,
    ];

    public function konsultasi(): BelongsTo {
        return $this->belongsTo(Konsultasi::class, 'id_konsultasi', 'id_konsultasi');
    }

}
