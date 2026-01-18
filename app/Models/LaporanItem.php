<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanItem extends Model
{
    use HasFactory;

    protected $fillable = [
    'laporan_id',
    'barang_id',
    'nama_barang',
    'satuan',
    'jumlah',
    'harga',
    'total_harga',
    'keterangan',
];


    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
