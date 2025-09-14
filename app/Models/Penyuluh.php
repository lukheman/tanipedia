<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penyuluh extends Authenticatable
{
    protected $table = 'penyuluh';

    protected $primaryKey = 'id_penyuluh';

    protected $guarded = [];

    public function getRoleAttribute()
    {
        return Role::AHLIPERTANIAN;
    }

    public function getIdAttribute()
    {
        return $this->id_penyuluh;
    }

    public function desa(): HasOne
    {
        return $this->hasOne(Desa::class, 'id_desa');
    }

    public function tanaman(): BelongsTo
    {
        return $this->belongsTo(Tanaman::class, 'id_tanaman');
    }

    public function konsultasi(): HasMany
    {
        return $this->hasMany(Konsultasi::class, 'id_penyuluh');
    }

}
