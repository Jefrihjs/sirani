@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')

<div class="card">

    <h2>Edit User</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label>Nama</label>
            <input type="text" name="name"
                   value="{{ $user->name }}"
                   class="form-input" required>
        </div>

        <div style="margin-bottom:15px;">
            <label>NIP</label>
            <input type="text" name="nip"
                   value="{{ $user->nip }}"
                   class="form-input" required>
        </div>

        <div style="margin-bottom:15px;">
            <label>Email</label>
            <input type="email"
                name="email"
                value="{{ $user->email }}"
                class="form-input"
                required>
        </div>


        <div style="margin-bottom:15px;">
            <label>Role</label>
            <select name="role" class="form-input">
                <option value="pegawai"
                    {{ $user->role == 'pegawai' ? 'selected' : '' }}>
                    Pegawai
                </option>
                <option value="admin"
                    {{ $user->role == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
            </select>
        </div>

        <div style="margin-bottom:20px;">
            <label>Status</label>
            <select name="is_active" class="form-input">
                <option value="1"
                    {{ $user->is_active ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="0"
                    {{ !$user->is_active ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>
        </div>

        <div class="form-group">
            <label>Password Baru (Opsional)</label>
            <input type="password" name="password" class="form-control">
            <small>Kosongkan jika tidak ingin mengubah password</small>
        </div>

        <button type="submit" class="btn btn-primary">
            Update User
        </button>

        <a href="{{ route('admin.users.index') }}"
           class="btn btn-secondary">
            Batal
        </a>

    </form>

</div>

@endsection
