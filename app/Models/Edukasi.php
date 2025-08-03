<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use HasFactory;

    protected $table = 'edukasi';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'id_video', 'id');
    }

    public function getLabelJudulAttribute()
    {
        return strlen($this->judul) > 30
            ? substr($this->judul, 0, 30).'...'
            : $this->judul;
    }

    public function getLabelDeskripsiAttribute()
    {
        return strlen($this->deskripsi) > 30
            ? substr($this->deskripsi, 0, 30).'...'
            : $this->deskripsi;
    }
}
