<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
        ]);

        $request->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('status', 'profile-updated');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        if (! Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah',
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function photo(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $user = auth()->user();
        if (!$user) {
            abort(403);
        }

        // Pastikan folder ada
        $path = public_path('storage/profile');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // 🔥 Resize + crop ke ukuran tetap
        $filename = time().'.jpg';

        Image::make($request->file('photo'))
            ->fit(300, 300) // ukuran FIX 300x300
            ->save($path.'/'.$filename, 80); // kualitas 80%

        // Simpan ke DB
        $user->photo = $filename;
        $user->save();

        return back();
    }



}
