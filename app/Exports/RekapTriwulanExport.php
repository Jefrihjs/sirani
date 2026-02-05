<?php

namespace App\Exports;

use App\Models\LaporanKegiatan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class RekapTriwulanExport implements FromCollection, WithHeadings
{
    protected $tahun;
    protected $triwulan;
    protected $kegiatanId;
    protected $userId;

    public function __construct($tahun, $triwulan, $kegiatanId, $userId)
    {
        $this->tahun = $tahun;
        $this->triwulan = $triwulan;
        $this->kegiatanId = $kegiatanId;
        $this->userId = $userId;
    }

    public function collection(): Collection
    {
        $range = match ((int)$this->triwulan) {
            1 => [1, 3],
            2 => [4, 6],
            3 => [7, 9],
            4 => [10, 12],
        };

        $query = LaporanKegiatan::select(
                'master_kegiatan.nama_kegiatan',
                DB::raw('COUNT(laporan_kegiatan.id) as jumlah_laporan'),
                DB::raw('SUM(laporan_kegiatan.durasi_menit) as total_menit')
            )
            ->join('master_kegiatan', 'master_kegiatan.id', '=', 'laporan_kegiatan.master_kegiatan_id')
            ->where('laporan_kegiatan.user_id', $this->userId)
            ->whereYear('laporan_kegiatan.tanggal', $this->tahun)
            ->whereBetween(DB::raw('MONTH(laporan_kegiatan.tanggal)'), $range);

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
