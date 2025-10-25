<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa';

    protected $primaryKey = 'id_desa';

    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'id_user', 'id_desa');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function jadwalPenyuluhan()
    {
        return $this->hasMany(JadwalPenyuluhan::class, 'id_desa', 'id_desa');
    }

}
