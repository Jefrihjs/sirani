<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\LaporanKegiatan;
use App\Models\MasterKegiatan;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class LaporanKegiatanController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil bulan real saat ini (Default Maret jika sekarang Maret)
        $bulan = $request->get('bulan', date('m')); 
        $tahun = $request->get('tahun', date('Y'));

        $data = LaporanKegiatan::with('kegiatan')
            ->where('user_id', auth()->id())
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('laporan_kegiatan.index', compact('data', 'bulan', 'tahun'));
    }

    public function rekapTriwulan(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $triwulan = $request->get('triwulan', 1);
        $kegiatanId = $request->get('kegiatan_id'); 

        $range = match ((int)$triwulan) {
            1 => [1, 3],
            2 => [4, 6],
            3 => [7, 9],
            4 => [10, 12],
        };

        $query = LaporanKegiatan::with('kegiatan')
            ->where('user_id', auth()->user()->id)
            ->whereYear('tanggal', $tahun)
            ->whereBetween(DB::raw('MONTH(tanggal)'), $range);

        if ($kegiatanId) {
            $query->where('master_kegiatan_id', $kegiatanId);
        }

        $data = $query
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $daftarKegiatan = MasterKegiatan::orderBy('nama_kegiatan')->get();

        return view('laporan_kegiatan.rekap_triwulan', compact(
            'data', 'tahun', 'triwulan', 'daftarKegiatan', 'kegiatanId'
        ));
    }

    public function rekapTahunan(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $kegiatanId = $request->get('kegiatan_id');

        $query = LaporanKegiatan::with('kegiatan')
            ->where('user_id', auth()->user()->id)
            ->whereYear('tanggal', $tahun);

        if ($kegiatanId) {
            $query->where('master_kegiatan_id', $kegiatanId);
        }

        $data = $query
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $daftarKegiatan = MasterKegiatan::orderBy('nama_kegiatan')->get();

        return view('laporan_kegiatan.rekap_tahunan', compact(
            'data', 'tahun', 'daftarKegiatan', 'kegiatanId'
        ));
    }

    public function create()
    {
        $kegiatan = MasterKegiatan::where(function ($q) {
                $q->where('user_id', auth()->id())
                ->orWhere('is_global', 1);
            })
            ->where('aktif', 1)
            ->orderBy('nama_kegiatan')
            ->get();

        return view('laporan_kegiatan.create', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'master_kegiatan_id' => 'required|exists:master_kegiatan,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'tempat' => 'required|string|max:255',
            'uraian' => 'required|string',
            'foto' => 'required|array|min:1', // Sudah saya ubah jadi min 1 sesuai request Bapak
            'foto.*' => 'image|max:2048',
        ]);

        $mulai   = Carbon::createFromFormat('H:i', $request->jam_mulai);
        $selesai = Carbon::createFromFormat('H:i', $request->jam_selesai);

        if ($selesai->lessThan($mulai)) {
            $selesai->addDay();
        }

        $durasiMenit = $mulai->diffInMinutes($selesai);

        // CEK BENTROK JAM
        $bentrok = LaporanKegiatan::where('user_id', auth()->user()->id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('jam_mulai', '<=', $request->jam_mulai)
                         ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
            })->exists();

        if ($bentrok) {
            return back()->withErrors(['jam_mulai' => 'Waktu bentrok dengan kegiatan lain'])->withInput();
        }

        $fotoPaths = [];
        foreach ($request->file('foto') as $file) {
            $img = Image::make($file)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 70);

            $filename = 'laporan_' . uniqid() . '.jpg';
            Storage::disk('public')->put('laporan_kegiatan/' . $filename, (string) $img);
            $fotoPaths[] = 'laporan_kegiatan/' . $filename;
        }

        LaporanKegiatan::create([
            'user_id' => auth()->id(),
            'master_kegiatan_id' => $request->master_kegiatan_id,
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'durasi_menit' => $durasiMenit,
            'tempat' => $request->tempat,
            'uraian' => $request->uraian,
            'foto' => $fotoPaths,
        ]);

        return redirect()->route('laporan_kegiatan.index')->with('success', 'Laporan berhasil disimpan');
    } // <--- TANDA INI TADI HILANG DI KODE BAPAK

    public function edit($id)
    {
        $laporan = LaporanKegiatan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $kegiatan = MasterKegiatan::where('aktif', true)->orderBy('nama_kegiatan')->get();
        return view('laporan_kegiatan.edit', compact('laporan', 'kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanKegiatan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'master_kegiatan_id' => 'required|exists:master_kegiatan,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tempat' => 'required|string|max:255',
            'uraian' => 'required|string',
        ]);

        $mulai   = Carbon::createFromFormat('H:i', substr($request->jam_mulai, 0, 5));
        $selesai = Carbon::createFromFormat('H:i', substr($request->jam_selesai, 0, 5));

        if ($selesai->lessThan($mulai)) { $selesai->addDay(); }
        $durasiMenit = $mulai->diffInMinutes($selesai);

        $laporan->update([
            'master_kegiatan_id' => $request->master_kegiatan_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'durasi_menit' => $durasiMenit,
            'tempat' => $request->tempat,
            'uraian' => $request->uraian,
        ]);

        return redirect()->route('laporan_kegiatan.index')->with('success', 'Laporan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $laporan = LaporanKegiatan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        foreach ($laporan->foto ?? [] as $foto) {
            Storage::disk('public')->delete($foto);
        }
        $laporan->delete();
        return redirect()->route('laporan_kegiatan.index')->with('success', 'Laporan berhasil dihapus');
    }

    public function tambahFoto(Request $request, $id)
    {
        $request->validate(['foto' => 'required|image|max:1024']);
        $laporan = LaporanKegiatan::findOrFail($id);

        $img = Image::make($request->file('foto'))->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode('jpg', 70);

        $filename = 'laporan_' . uniqid() . '.jpg';
        $path = 'laporan_kegiatan/' . $filename;
        Storage::disk('public')->put($path, (string) $img);

        $foto = $laporan->foto ?? [];
        $foto[] = $path;
        $laporan->update(['foto' => $foto]);

        return response()->json(['success' => true]);
    }

    public function hapusFoto($laporanId, $index)
    {
        $laporan = LaporanKegiatan::where('id', $laporanId)->where('user_id', auth()->id())->firstOrFail();
        $foto = $laporan->foto ?? [];

        if (count($foto) <= 2) {
            return response()->json(['message' => 'Minimal 2 foto wajib.'], 422);
        }

        if (isset($foto[$index])) {
            Storage::disk('public')->delete($foto[$index]);
            unset($foto[$index]);
            $laporan->update(['foto' => array_values($foto)]);
            return response()->json(['success' => true]);
        }

        return response()->json(['message' => 'Foto tidak ditemukan.'], 404);
    }

    public function updateFoto(Request $request, $laporanId, $index)
    {
        $request->validate(['foto' => 'required|image|max:1024']);
        $laporan = LaporanKegiatan::where('id', $laporanId)->where('user_id', auth()->id())->firstOrFail();
        $foto = $laporan->foto ?? [];

        if (isset($foto[$index])) {
            Storage::disk('public')->delete($foto[$index]);
            $path = $request->file('foto')->store('laporan_kegiatan', 'public');
            $foto[$index] = $path;
            $laporan->update(['foto' => $foto]);
            return response()->json(['success' => true]);
        }
        return response()->json(['message' => 'Foto tidak ditemukan.'], 404);
    }

    public function pdf($id)
    {
        $laporan = LaporanKegiatan::with('kegiatan')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // 1. Ambil tanggal dengan format ddmmyyyy
        $tanggal = \Carbon\Carbon::parse($laporan->tanggal)->format('dmY');

        // 2. Ambil nama laporan & bersihkan karakter aneh (spasi jadi dash)
        $namaLaporan = \Str::slug($laporan->kegiatan->nama_kegiatan ?? 'laporan-kegiatan');

        // 3. Gabungkan jadi nama file: ddmmyyyy-namalaporan.pdf
        $fileName = $tanggal . '-' . $namaLaporan . '.pdf';

        $laporan->tanggal_indo = \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->translatedFormat('d F Y');
        $laporan->jam_indo = \Carbon\Carbon::parse($laporan->jam_mulai)->format('H.i') . ' – ' . \Carbon\Carbon::parse($laporan->jam_selesai)->format('H.i');

        $pdf = PDF::loadView('laporan_kegiatan.pdf', compact('laporan'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => true,
                'chroot' => public_path(),
            ]);

        // Kembalikan stream dengan nama file yang baru
        return $pdf->stream($fileName, ["Attachment" => false]);
    }
}