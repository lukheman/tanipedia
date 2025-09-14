<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\StatusKonsultasi;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';

    protected $primaryKey = 'id_konsultasi';

    protected $guarded = [];

    protected $casts = [
        'status' => StatusKonsultasi::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_petani', 'id_petani');
    }

    public function penyuluh()
    {
        return $this->belongsTo(Penyuluh::class, 'id_penyuluh', 'id_penyuluh');
    }

    public function tanaman(): BelongsTo
    {
        return $this->belongsTo(Tanaman::class, 'id_tanaman', 'id_tanaman');
    }

    public function pesan(): HasMany {
        return $this->hasMany(Pesan::class, 'id_konsultasi');
    }

    public function accept()
    {
        $this->status = StatusKonsultasi::ACCEPTED;
        $this->save();
    }

    public function reject()
    {
        $this->status = StatusKonsultasi::REJECTED;
        $this->save();
    }

}
