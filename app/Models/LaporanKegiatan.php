<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kegiatan';

    protected $fillable = [
        'user_id',
        'master_kegiatan_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'tempat',
        'uraian',
        'foto',
    ];

    protected $casts = [
        'foto' => 'array',
    ];
    
    public function kegiatan()
    {
        return $this->belongsTo(MasterKegiatan::class, 'master_kegiatan_id');
    }
}
