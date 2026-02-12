@extends('layouts.dashboard')

@section('title', 'Tambah User')

@section('content')

<div class="card">
    <div class="card-header">
        <h2>Tambah User Baru</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label>NIP</label>
                <input type="text" name="nip" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-input">
                    <option value="pegawai">Pegawai</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

        </form>
    </div>
</div>

@endsection
