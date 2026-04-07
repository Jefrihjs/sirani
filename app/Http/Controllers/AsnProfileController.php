<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsnProfile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AsnProfileController extends Controller
{
    // ===============================
    // SHOW (LIHAT PROFIL ASN)
    // ===============================
    public function show()
    {
        $user = auth()->user();
        $profile = $user->asnProfile ?? AsnProfile::create([
            'user_id' => $user->id
        ]);

        return view('profile.show', compact(
            'user',
            'profile'
        ));
    }

    // ===============================
    // EDIT (FORM EDIT PROFIL ASN)
    // ===============================
    public function edit()
    {
        $user = auth()->user();

        $profile = AsnProfile::firstOrCreate([
            'user_id' => $user->id
        ]);

        $atasanList = User::where('id', '!=', $user->id)->get();

        return view('profile.edit', compact(
            'user',
            'profile',
            'atasanList'
        ));
    }

    // ===============================
    // UPDATE (SIMPAN PROFIL ASN)
    // ===============================
    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->asnProfile ?? AsnProfile::create([
            'user_id' => $user->id
        ]);

        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'jabatan' => 'required',
            'jenis_jabatan' => 'required',
            'unit_kerja' => 'required',
            'golongan_ruang' => 'required',
            'status_kepegawaian' => 'nullable',
        ]);

        /* ===== FOTO PROFIL ===== */
        if ($request->hasFile('photo')) {

            // hapus foto lama
            if ($user->photo && Storage::exists('public/'.$user->photo)) {
                Storage::delete('public/'.$user->photo);
            }

            // nama file baru
            $fileName = time().'_'.$user->id.'.jpg';

            // simpan file
            $request->file('photo')->storeAs('profile', $fileName, 'public');

            // update database
            $user->photo = 'profile/'.$fileName;
            $user->save();
        }
        /* ===== DATA ASN ===== */
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
