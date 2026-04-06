<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
       return view('profile.security', [
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
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        $path = 'profile/'.$user->id.'.jpg';

        // hapus foto lama (jaga storage tetap bersih)
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $image = Image::make($request->file('photo'))
            ->fit(400, 400)
            ->encode('jpg', 80);

        Storage::disk('public')->put($path, (string) $image);

        $user->update([
            'photo' => $path
        ]);

        return back();
    }



}
