<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsnProfile;
use Illuminate\Support\Facades\Auth;

class AsnProfileController extends Controller
{
    // Tampilkan halaman profil (view-only + edit field tertentu)
    public function show()
    {
        $user = Auth::user();

        $profile = AsnProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'jabatan' => '',
                'jenis_jabatan' => 'Fungsional',
                'unit_kerja' => '',
                'unit_teknis' => '',
                'golongan_ruang' => '',
                'status_kepegawaian' => 'PNS',
            ]
        );

        return view('profile.asn', compact('user', 'profile'));
    }

    public function edit()
    {
        $user = auth()->user();
        $profile = $user->asnProfile;

        // daftar calon atasan (simple dulu)
        $atasanList = \App\Models\User::where('id', '!=', $user->id)->get();

        return view('profile.edit', compact('user', 'profile', 'atasanList'));
    }

    public function update(Request $request)
    {

        $user = auth()->user();
        $profile = $user->asnProfile;

        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'jabatan' => 'required',
            'jenis_jabatan' => 'required',
            'unit_kerja' => 'required',
            'golongan_ruang' => 'required',
            'status_kepegawaian' => 'required',
        ]);

        /* ================= FOTO ================= */
        if ($request->hasFile('photo')) {

    if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
        \Storage::disk('public')->delete($user->photo);
    }

    $path = $request->file('photo')->store('profile', 'public');

    $user->photo = $path;
    $user->save();
}


        /* ================= DATA PROFIL ================= */
        $profile->update([
            'jabatan' => $request->jabatan,
            'jenis_jabatan' => $request->jenis_jabatan,
            'unit_kerja' => $request->unit_kerja,
            'unit_teknis' => $request->unit_teknis,
            'golongan_ruang' => $request->golongan_ruang,
            'status_kepegawaian' => $request->status_kepegawaian,
            'atasan_id' => $request->atasan_id,
        ]);

        return redirect()
            ->route('profil.asn')
            ->with('success', 'Profil berhasil diperbarui');
    }

}
