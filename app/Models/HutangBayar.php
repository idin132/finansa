<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HutangBayar extends Model
{
    use HasFactory;

    // Nama tabel manual sesuai migration
    protected $table = 'hutang_bayar';

    protected $guarded = ['id'];

    /**
     * Relasi balik ke model Hutang
     */
    public function hutang()
    {
        return $this->belongsTo(Hutang::class, 'id_hutang', 'id');
    }
}