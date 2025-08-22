<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'petani';

    protected $primaryKey = 'id_petani';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRoleAttribute()
    {
        return Role::PETANI;
    }

    public function getIdAttribute()
    {
        return $this->id_petani;
    }

    public function berita()
    {
        return $this->hasMany(Berita::class, 'id_user', 'id');
    }

    public function video()
    {
        return $this->hasMany(Edukasi::class, 'id_user', 'id');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'id_user', 'id');
    }

    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'id_user', 'id');
    }

    public function hasilKonsultasi()
    {
        return $this->hasMany(HasilKonsultasi::class, 'id_user', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa');
    }

    // public function kecamatan() {
    //     return $this->belongsTo(kecamatan::class, 'id_user', 'id');
    // }

}
