<?php

namespace Modules\Transaksi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'name',
        'group',
        'status',
    ];

    protected static function newFactory()
    {
        return \Modules\Transaksi\Database\factories\JenisTransaksiFactory::new();
    }
}
