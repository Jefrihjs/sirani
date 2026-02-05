<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    use HasFactory;

    protected $table = 'master_kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'aktif',
    ];
}
