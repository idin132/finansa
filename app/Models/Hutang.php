<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    use HasFactory;

    protected $table = 'hutang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_hutang',
        'pihak_pemberi',
        'nilai_pokok',
        'sisa_hutang',
        'bunga_persen',
        'total_pembayaran',
        'tanggal_pinjam',
        'tanggal_tempo',
        'status',
        'keterangan',
        'user_id'
    ];
}
