<?php

namespace Modules\Transaksi\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Anggota\Entities\Anggota;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'tanggal',
        'anggota_id',
        'jenis',
        'tipe',
        'nominal',
        'validasi',
        'keterangan',
        'admin_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Transaksi\Database\factories\TransaksiFactory::new();
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
    public function administrator()
    {
        return $this->belongsTo(User::class);
    }
    public function jenis_transaksi()
    {
        return $this->belongsTo(JenisTransaksi::class, 'jenis', 'kode');
    }
}
