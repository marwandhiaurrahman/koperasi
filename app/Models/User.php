<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Anggota\Entities\Anggota;
use Modules\Pinjaman\Entities\Pinjaman;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nik',
        'name',
        'tempat_lahir',
        'tanggal_lahir',
        'gender',
        'alamat',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'agama',
        'perkawinan',
        'pekerjaan',
        'negara',
        'foto',
        'phone',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the transaksis for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'anggota_id', 'id');
    }
    public function pinjamans()
    {
        return $this->hasMany(Pinjaman::class, 'anggota_id', 'id');
    }

    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'user_id', 'id');
    }
}
