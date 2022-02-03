<?php

namespace Modules\Pinjaman\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Anggota\Entities\Anggota;
use Modules\Transaksi\Entities\Transaksi;

class Pinjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'name',
        'tanggal',
        'anggota_id',
        'tipe',
        'plafon',
        'waktu',
        'angsuran',
        'jasa',
        'saldo',
        'sisa_angsuran',
        'validasi',
        'admin_id',
        'keterangan',
    ];

    protected static function newFactory()
    {
        return \Modules\Pinjaman\Database\factories\PinjamanFactory::new();
    }
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
    public function transaksis()
    {
        return $this->belongsToMany(Transaksi::class,'pinjamen_transaksis','pinjaman_id','transaksi_id');
    }

}
