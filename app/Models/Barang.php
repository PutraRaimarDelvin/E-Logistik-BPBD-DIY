<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok',
        'satuan',
        'harga',
    ];

    // 🔗 RELASI KE LAPORAN ITEM
    public function laporanItems()
    {
        return $this->hasMany(LaporanItem::class, 'barang_id');
    }
    
}
