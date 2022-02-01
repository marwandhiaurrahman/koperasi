<?php

namespace Modules\Anggota\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode',
        'tipe',
        'status',
    ];
    protected static function newFactory()
    {
        return \Modules\Anggota\Database\factories\AnggotaFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
