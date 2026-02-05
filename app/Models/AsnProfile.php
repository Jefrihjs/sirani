<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsnProfile extends Model
{
    use HasFactory;

    protected $table = 'asn_profiles';

    protected $fillable = [
        'user_id',
        'jabatan',
        'jenis_jabatan',
        'unit_kerja',
        'unit_teknis',
        'golongan_ruang',
        'status_kepegawaian',
        'atasan_id',
    ];

    // Relasi ke user pemilik profil
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke atasan (juga user)
    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }
}
