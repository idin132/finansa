<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_transaksi',
        'user_id',
        'tanggal',
        'jenis',
        'kategori',
        'nominal',
        'keterangan',
    ];

    public function scopeFilterJenis(Builder $query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    /**
     * Scope untuk memfilter Transaksi berdasarkan Kategori.
     */
    public function scopeFilterKategori(Builder $query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeFilterTanggal(Builder $query, $startDate, $endDate)
    {
        // Pastikan format tanggal sudah benar (YYYY-MM-DD)
        return $query->whereDate('tanggal', '>=', $startDate)
                     ->whereDate('tanggal', '<=', $endDate);
    }

}
