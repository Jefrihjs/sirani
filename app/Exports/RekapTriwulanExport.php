<?php

namespace App\Exports;

use App\Models\LaporanKegiatan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class RekapTriwulanExport implements 
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths
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

        $query = LaporanKegiatan::with('kegiatan')
            ->where('user_id', $this->userId)
            ->whereYear('tanggal', $this->tahun)
            ->whereBetween(DB::raw('MONTH(tanggal)'), $range);

        if ($this->kegiatanId) {
            $query->where('master_kegiatan_id', $this->kegiatanId);
        }

        $data = $query
            ->orderBy('master_kegiatan_id')
            ->orderBy('tanggal')
            ->get();

        return $data->values()->map(function ($row, $index) {
            return [
                $index + 1,
                \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y'),
                $row->kegiatan->nama_kegiatan ?? '-',
                $row->uraian,
                $row->tempat ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Kegiatan',
            'Uraian Kegiatan',
            'Keterangan',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // No
            'B' => 14,  // Tanggal
            'C' => 25,  // Nama Kegiatan
            'D' => 50,  // Uraian (dibatasi supaya tidak melebar)
            'E' => 20,  // Keterangan
        ];
    }

    public function styles(Worksheet $sheet)
{
    // Bold header
    $sheet->getStyle('A1:E1')->getFont()->setBold(true);

    // Center kolom No dan Tanggal
    $sheet->getStyle('A:A')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('B:B')->getAlignment()->setHorizontal('center');

    // Wrap text kolom Uraian
    $sheet->getStyle('D:D')->getAlignment()->setWrapText(true);

    // Vertical align top
    $sheet->getStyle('A:E')->getAlignment()->setVertical('top');

    // Auto tinggi baris
    foreach (range(1, $sheet->getHighestRow()) as $row) {
        $sheet->getRowDimension($row)->setRowHeight(-1);
    }

    // Setting kertas A4 portrait
    $sheet->getPageSetup()
        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

    $sheet->getPageSetup()
        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

    $sheet->getPageSetup()
        ->setFitToWidth(1)
        ->setFitToHeight(0);

    // Border seluruh tabel
    $lastRow = $sheet->getHighestRow();
    $sheet->getStyle("A1:E{$lastRow}")
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    return [];
}

}
