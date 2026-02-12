@extends('layouts.dashboard')

@section('title', 'Manajemen User')

@section('content')

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Manajemen User</h2>
        <p class="card-subtitle">Daftar seluruh pengguna sistem SIRANI</p>
    </div>

    <div class="card-body">

        <div style="margin-bottom: 16px;">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                + Tambah User
            </a>
        </div>

        <div class="table-wrapper">
            <table class="custom-table">
                <thead>
                    <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        @if($user->role === 'admin')
                            <span class="badge badge-success">Admin</span>
                        @else
                            <span class="badge badge-secondary">Pegawai</span>
                        @endif
                    </td>

                    <td>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="is_active" value="0">

                                <label class="switch">
                                    <input type="checkbox"
                                        name="is_active"
                                        value="1"
                                        onchange="this.form.submit()"
                                        {{ $user->is_active ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </form>

                        @else
                            <span class="text-muted">Akun Anda</span>
                        @endif
                    </td>

                    <td>
                        @if($user->id !== auth()->id())
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                            class="btn btn-sm btn-outline-primary">
                                Edit
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>

            </table>
            <div style="margin-top:20px;">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
