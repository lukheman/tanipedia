<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $primaryKey = 'id_berita';

    protected $guarded = [];

    public function penulis()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
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
