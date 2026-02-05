<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatan;
use Illuminate\Http\Request;

class MasterKegiatanController extends Controller
{
    public function index()
    {
        $data = MasterKegiatan::orderBy('nama_kegiatan')->get();
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

        MasterKegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'aktif' => true,
        ]);

        return redirect()->route('master-kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan');
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

    public function destroy(MasterKegiatan $masterKegiatan)
    {
        $masterKegiatan->delete();

        return redirect()->route('master-kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus');
    }
}
