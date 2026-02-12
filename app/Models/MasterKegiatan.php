<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    use HasFactory;

    protected $table = 'master_kegiatan';

    protected $fillable = [
        'user_id',          // ← WAJIB ditambahkan
        'nama_kegiatan',
        'aktif',
        'is_global',
    ];

    // Relasi ke user pemilik kegiatan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke laporan kegiatan
    public function laporanKegiatan()
    {
        return $this->hasMany(LaporanKegiatan::class);
    }
}
