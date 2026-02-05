<?php

namespace App\Exports;

use App\Models\LaporanKegiatan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class RekapTahunanExport implements FromCollection, WithHeadings
{
    protected $tahun;
    protected $kegiatanId;
    protected $userId;

    public function __construct($tahun, $kegiatanId, $userId)
    {
        $this->tahun = $tahun;
        $this->kegiatanId = $kegiatanId;
        $this->userId = $userId;
    }

    public function collection(): Collection
    {
        $query = LaporanKegiatan::select(
                'master_kegiatan.nama_kegiatan',
                DB::raw('COUNT(laporan_kegiatan.id) as jumlah_laporan'),
                DB::raw('SUM(laporan_kegiatan.durasi_menit) as total_menit')
            )
            ->join('master_kegiatan', 'master_kegiatan.id', '=', 'laporan_kegiatan.master_kegiatan_id')
            ->where('laporan_kegiatan.user_id', $this->userId)
            ->whereYear('laporan_kegiatan.tanggal', $this->tahun);

        if ($this->kegiatanId) {
            $query->where('laporan_kegiatan.master_kegiatan_id', $this->kegiatanId);
        }

        return $query
            ->groupBy('master_kegiatan.nama_kegiatan')
            ->orderBy('master_kegiatan.nama_kegiatan')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Kegiatan',
            'Jumlah Laporan',
            'Total Menit'
        ];
    }
}
