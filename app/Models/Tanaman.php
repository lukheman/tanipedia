<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tanaman extends Model
{
    use HasFactory;

    protected $table = 'tanaman';

    protected $primaryKey = 'id_tanaman';

    protected $guarded = [];

    public function penyuluh(): HasMany
    {
        return $this->hasMany(Penyuluh::class, 'id_tanaman');
    }

    public function konsultasi(): HasMany
    {
        return $this->hasMany(Konsultasi::class, 'id_tanaman');
    }
}
