<?php

namespace App\Models;

use App\Enums\Role;
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

    public function desa()
    {
        return $this->hasOne(Desa::class, 'id_desa');
    }
}
