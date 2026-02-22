@extends('layouts.dashboard')
@section('title', 'Master Kegiatan')

@section('icon')
<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
        d="M2.25 6.75h7.5l2.25 3h9v9a2.25 2.25 0 01-2.25 2.25h-13.5A2.25 2.25 0 012.25 18V6.75z" />
</svg>
@endsection

@section('content')

<div class="page-wrapper">

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h1>Master Kegiatan</h1>
            <p class="page-subtitle">Daftar jenis kegiatan pribadi Anda</p>
        </div>

        <a href="{{ route('master-kegiatan.create') }}" class="link-cta">
            <span class="plus-icon">＋</span>
            Tambah Kegiatan
        </a>
    </div>


    {{-- CARD --}}
    <div class="card">
        <div class="scroll-hint">Geser tabel ke samping →</div>
        <div class="table-responsive"> 
            <table class="table-modern">

                <thead>
                    <tr>
                        <th style="width:70px;">No</th>
                        <th>Nama Kegiatan</th>
                        <th style="width:120px;">Status</th>
                        <th style="width:120px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $i => $row)
                    <tr>

                        <td>{{ $i + 1 }}</td>

                        <td>
                            <span class="badge-name">
                                {{ $row->nama_kegiatan }}
                            </span>

                            @if($row->is_global)
                                <span class="badge-global">Global</span>
                            @else
                                <span class="badge-personal">Personal</span>
                            @endif
                        </td>

                        <td>
                            @if($row->aktif)
                                <span class="badge-success">
                                    Aktif
                                </span>
                            @else
                                <span class="badge-muted">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td>
                            <div class="action-group">

                                {{-- Edit --}}
                                <a href="{{ route('master-kegiatan.edit', $row->id) }}"
                                class="action-btn edit"
                                title="Edit">
                                    ✏
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('master-kegiatan.destroy', $row->id) }}"
                                    method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="action-btn delete"
                                            title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                        🗑
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            Belum ada master kegiatan.
                            <br>
                            <small>Tambahkan kegiatan pertama Anda.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection

