<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    use HasFactory;

    protected $table = 'hutang';
    
    // Memastikan id_hutang otomatis terisi oleh sistem jika menggunakan fill
    protected $guarded = ['id'];

    /**
     * Daftarkan accessor sisa_hutang agar muncul saat model di-convert ke array/json
     */
    protected $appends = ['sisa_hutang'];

    public function pembayarans() 
    {
        // Relasi One-to-Many ke HutangBayar
        return $this->hasMany(HutangBayar::class, 'id_hutang', 'id');
    }

    /**
     * Accessor: Menghitung sisa hutang secara otomatis
     * Akses: $hutang->sisa_hutang
     */
    public function getSisaHutangAttribute() 
    {
        return $this->nilai_pokok - $this->pembayarans->sum('nominal');
    }
}