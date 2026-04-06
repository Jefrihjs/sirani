<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) // Tambahkan Request $request di sini
    {
        $user = auth()->user(); 
        $userId = $user->id;
        $tahun = date('Y'); 

        // 1. Ambil bulan dari Request (Pilihan User), jika kosong pakai bulan sekarang
        $bulan = $request->input('bulan', date('n'));

        // ================= KPI (Ganti now()->month dengan variabel $bulan) =================
        $totalMenit = DB::table('laporan_kegiatan')
            ->where('user_id', $userId)
            ->whereMonth('tanggal', $bulan) // Dinamis sesuai pilihan
            ->whereYear('tanggal', now()->year)
            ->sum('durasi_menit');

        $jumlahLaporan = DB::table('laporan_kegiatan')
            ->where('user_id', $userId)
            ->whereMonth('tanggal', $bulan) // Dinamis sesuai pilihan
            ->whereYear('tanggal', now()->year)
            ->count();

        $targetMenit = 6000;

        $persenKPI = $targetMenit > 0
            ? min(100, round(($totalMenit / $targetMenit) * 100))
            : 0;

        // Status logic
        if ($persenKPI >= 100) {
            $status = 'Tercapai';
            $badgeClass = 'bg-emerald-100 text-emerald-600 border-emerald-200';
        } elseif ($persenKPI >= 75) {
            $status = 'On Track';
            $badgeClass = 'bg-blue-100 text-blue-600 border-blue-200';
        } elseif ($persenKPI >= 50) {
            $status = 'Perlu Ditingkatkan';
            $badgeClass = 'bg-amber-100 text-amber-600 border-amber-200';
        } else {
            $status = 'Belum Optimal';
            $badgeClass = 'bg-rose-100 text-rose-600 border-rose-200';
        }

        // ================= KEGIATAN TERAKHIR =================
        $kegiatanTerakhir = DB::table('laporan_kegiatan')
            ->join('master_kegiatan', 'laporan_kegiatan.master_kegiatan_id', '=', 'master_kegiatan.id')
            ->where('laporan_kegiatan.user_id', $userId)
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

        // ================= GRAFIK =================
        $grafikBulanan = DB::table('laporan_kegiatan')
            ->selectRaw('MONTH(tanggal) as bulan_grafik, SUM(durasi_menit) as total_menit')
            ->where('user_id', $userId)
            ->whereYear('tanggal', $tahun)
            ->groupByRaw('MONTH(tanggal)')
            ->orderByRaw('MONTH(tanggal)')
            ->get();

        $dataGrafik = array_fill(1, 12, 0);
        foreach ($grafikBulanan as $row) {
            $dataGrafik[$row->bulan_grafik] = (int) $row->total_menit;
        }
        $dataGrafik = array_values($dataGrafik);

        // 2. Tambahkan 'bulan' ke dalam compact agar View bisa membacanya
        return view('dashboard.index', compact(
            'user',
            'tahun',
            'bulan', // Tambahan ini penting!
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