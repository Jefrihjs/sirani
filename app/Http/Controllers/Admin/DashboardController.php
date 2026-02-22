<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // ================= KPI =================
            $userId = auth()->user()->id;

            $totalMenit = DB::table('laporan_kegiatan')
                ->where('user_id', $userId)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('durasi_menit');

            $jumlahLaporan = DB::table('laporan_kegiatan')
                ->where('user_id', $userId)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count();

            $targetMenit = 6000;

            $persenKPI = $targetMenit > 0
                ? min(100, round(($totalMenit / $targetMenit) * 100))
                : 0;

            if ($persenKPI >= 100) {
                $status = 'Tercapai';
                $badgeClass = 'badge-success';
            } elseif ($persenKPI >= 75) {
                $status = 'On Track';
                $badgeClass = 'badge-success';
            } elseif ($persenKPI >= 50) {
                $status = 'Perlu Ditingkatkan';
                $badgeClass = 'badge-warning';
            } else {
                $status = 'Belum Optimal';
                $badgeClass = 'badge-warning';
            }


        $jumlahLaporan = DB::table('laporan_kegiatan')
            ->where('user_id', $userId)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        $targetMenit = 6000;

        $persenKPI = $targetMenit > 0
            ? min(100, round(($totalMenit / $targetMenit) * 100))
            : 0;


        // ================= KEGIATAN TERAKHIR =================
        $kegiatanTerakhir = DB::table('laporan_kegiatan')
            ->join(
                'master_kegiatan',
                'laporan_kegiatan.master_kegiatan_id',
                '=',
                'master_kegiatan.id'
            )
            ->where('laporan_kegiatan.user_id', auth()->user()->id)
            ->orderBy('laporan_kegiatan.tanggal', 'desc')
            ->limit(5)
            ->select(
                'master_kegiatan.nama_kegiatan',
                'laporan_kegiatan.tanggal',
                'laporan_kegiatan.jam_mulai',
                'laporan_kegiatan.jam_selesai',
                'laporan_kegiatan.durasi_menit'
            )
            ->get();

            $grafikBulanan = DB::table('laporan_kegiatan')
                ->selectRaw('MONTH(tanggal) as bulan, SUM(durasi_menit) as total_menit')
                ->where('user_id', auth()->user()->id)
                ->whereYear('tanggal', now()->year)
                ->groupByRaw('MONTH(tanggal)')
                ->orderByRaw('MONTH(tanggal)')
                ->get();

            // Siapkan array 12 bulan (default 0)
            $dataGrafik = array_fill(1, 12, 0);

            foreach ($grafikBulanan as $row) {
                $dataGrafik[$row->bulan] = (int) $row->total_menit;
            }

            $dataGrafik = array_values($dataGrafik);

            return view('dashboard.index', compact(
                'totalMenit',
                'jumlahLaporan',
                'status',
                'badgeClass', 
                'kegiatanTerakhir',
                'persenKPI',
                'targetMenit',
                'dataGrafik'
            ));

    }
}
