<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';
    protected $guarded = [];

    // public function user() {
    //     return $this->hasMany(User::class, 'id_user', 'id');
    // }

    public function desa() {
        return $this->hasMany(Desa::class, 'id_kecamatan', 'id');
    }

}
