<?php

namespace Modules\Simpanan\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisSimpanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'kode', 'status'
    ];

    protected static function newFactory()
    {
        return \Modules\Simpanan\Database\factories\JenisSimpananFactory::new();
    }
}
