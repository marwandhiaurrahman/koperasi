<?php

namespace Modules\Pinjaman\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pinjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'tanggal',
        'anggota_id',
        'jenis',
        'plafon',
        'angsuran',
        'jasa',
        'waktu',
        'angsuranke',
        'saldo',
        'validasi',
        'user_id',
        'keterangan',
    ];

    protected static function newFactory()
    {
        return \Modules\Pinjaman\Database\factories\PinjamanFactory::new();
    }
    public function anggota()
    {
        return $this->belongsTo(User::class);
    }
    public function administrator()
    {
        return $this->belongsTo(User::class);
    }
}
