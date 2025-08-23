<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';

    protected $primaryKey = 'id_komentar';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_petani', 'id_petani');
    }

    public function video()
    {
        return $this->belongsTo(Edukasi::class, 'id_user', 'id');
    }
}
