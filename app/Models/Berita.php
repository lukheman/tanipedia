<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Berita extends Model
{
    use HasFactory;

    public $table = 'berita';

    public function penulis() {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
