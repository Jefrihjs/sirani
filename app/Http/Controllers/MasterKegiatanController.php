<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatan;
use Illuminate\Http\Request;

class MasterKegiatanController extends Controller
{
    public function index()
    {
        $data = MasterKegiatan::where(function ($q) {
                $q->where('user_id', auth()->id())
                ->orWhere('is_global', 1);
            })
            ->orderBy('nama_kegiatan')
            ->get();

        return view('master_kegiatan.index', compact('data'));
    }


    public function create()
    {
        return view('master_kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
        ]);

        if (auth()->user()->isAdmin() && $request->has('is_global')) {

            // 🔵 Global
            MasterKegiatan::create([
                'user_id' => null,
                'nama_kegiatan' => $request->nama_kegiatan,
                'aktif' => 1,
                'is_global' => 1,
            ]);

        } else {

            // 🟢 Personal
            MasterKegiatan::create([
                'user_id' => auth()->id(),
                'nama_kegiatan' => $request->nama_kegiatan,
                'aktif' => 1,
                'is_global' => 0,
            ]);
        }

        return redirect()->route('master-kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }


    public function edit(MasterKegiatan $master_kegiatan)
    {
        return view('master_kegiatan.edit', [
            'row' => $master_kegiatan
        ]);
    }

    public function update(Request $request, MasterKegiatan $masterKegiatan)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'aktif' => 'required|boolean',
        ]);

        $master_kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'aktif' => $request->aktif,
        ]);

        return redirect()->route('master-kegiatan.index')
            ->with('success', 'Kegiatan berhasil diupdate');
    }

    public function destroy($id)
    {
        $kegiatan = MasterKegiatan::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Cek apakah sudah dipakai di laporan
        if ($kegiatan->laporanKegiatan()->exists()) {
            return back()->with('error', 'Kegiatan sudah digunakan dalam laporan dan tidak bisa dihapus.');
        }

        $kegiatan->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }

}
