<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    public $table = 'berita';

    public $guarded = [];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function getLabelJudulAttribute()
    {
        return strlen($this->judul) > 30
            ? substr($this->judul, 0, 30).'...'
            : $this->judul;
    }

    public function getExcerptAttribute()
    {

        return Str::limit(strip_tags($this->isi), 50);

    }
}
