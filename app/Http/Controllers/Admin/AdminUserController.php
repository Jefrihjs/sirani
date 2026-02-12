<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:users,nip',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,pegawai'
        ]);

        User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_active' => 1
        ]);

        return redirect()->route('admin.users.index')
            ->with('success','User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error','Tidak bisa edit akun sendiri.');
        }

        $request->validate([
            'name' => 'required',
            'nip' => 'required',
            'role' => 'required|in:admin,pegawai',
            'is_active' => 'required|boolean'
        ]);

        $user->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'role' => $request->role,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('admin.users.index')
            ->with('success','User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error','Tidak bisa hapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success','User berhasil dihapus.');
    }
}
