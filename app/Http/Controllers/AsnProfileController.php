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
        $profile = $user->asnProfile;

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
        $profile = $user->asnProfile;

        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'jabatan' => 'required',
            'jenis_jabatan' => 'required',
            'unit_kerja' => 'required',
            'golongan_ruang' => 'required',
            'status_kepegawaian' => 'required',
        ]);

        /* ===== FOTO PROFIL ===== */
        if ($request->hasFile('photo')) {

            $path = 'profile/'.$user->id.'.jpg';

            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $image = Image::make($request->file('photo'))
                ->fit(400, 400)
                ->encode('jpg', 80);

            Storage::disk('public')->put($path, (string) $image);

            $user->photo = $path;
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
