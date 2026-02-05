<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKegiatan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $query = LaporanKegiatan::with('kegiatan')
            ->where('user_id', auth()->user()->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $totalMenit = $query->sum('durasi_menit');

        $target = 6000;
        $sisa = max($target - $totalMenit, 0);
        $persen = $target > 0 ? round(($totalMenit / $target) * 100, 2) : 0;

        // 🔥 STATUS CAPAIAN
        if ($persen >= 80) {
            $statusText = 'Aman';
            $statusColor = '#16a34a'; // hijau
        } elseif ($persen >= 50) {
            $statusText = 'Perlu Dikejar';
            $statusColor = '#f59e0b'; // kuning
        } else {
            $statusText = 'Kritis';
            $statusColor = '#dc2626'; // merah
        }

        // 🔥 KEGIATAN TERAKHIR (5 DATA)
        $kegiatanTerakhir = LaporanKegiatan::with('kegiatan')
            ->where('user_id', auth()->user()->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalMenit',
            'target',
            'sisa',
            'persen',
            'kegiatanTerakhir',
            'statusText',
            'statusColor'
        ));

    }
}
