<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'instansi',
        'jabatan',
        'no_hp',
        'tujuan',
        'jenis_bencana',
        'nama_posko',
        'tingkat_posko',
        'rt',
        'rw',
        'desa',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'foto_path',
        'surat_path',
        'surat_nama_asli',   // 🔥 WAJIB ADA
        'nomor_surat',  // ⬅ WAJIB ADA

        // admin
        'status_validasi',
        'catatan_admin',
        'validated_by',
    ];

    public function items()
    {
        return $this->hasMany(LaporanItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function isValidated(): bool
    {
        return $this->status_validasi === 'divalidasi';
    }

    public function isPending(): bool
    {
        return $this->status_validasi === 'menunggu';
    }

    public function isProcessing(): bool
    {
        return $this->status_validasi === 'diproses';
    }
}
