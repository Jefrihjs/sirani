@extends('layouts.dashboard')

@section('title', 'Keamanan Akun')
@section('icon')
<svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M12 3l7 4v5c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V7l7-4z" />
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M9.5 12.5l1.5 1.5 3-3" />
</svg>
@endsection

@section('content')

<div class="page-wrapper">

    <div class="page-header">
        <div>
            <h1>Keamanan Akun</h1>
            <div class="page-subtitle">
                Ganti password akun Anda secara berkala
            </div>
        </div>
    </div>

    <div class="card">

        <form method="POST"
              action="{{ route('profile.password') }}"
              class="form-grid-2">

            @csrf
            @method('PATCH')

            <div>
                <label class="form-label">Password Lama</label>
                <div class="password-wrapper">
                    <input type="password"
                           name="current_password"
                           class="form-input"
                           required>
                    <button type="button" class="toggle-password">👁</button>
                </div>
            </div>

            <div>
                <label class="form-label">Password Baru</label>
                <div class="password-wrapper">
                    <input type="password"
                           name="password"
                           class="form-input"
                           required>
                    <button type="button" class="toggle-password">👁</button>
                </div>
            </div>

            <div>
                <label class="form-label">Konfirmasi Password Baru</label>
                <div class="password-wrapper">
                    <input type="password"
                           name="password_confirmation"
                           class="form-input"
                           required>
                    <button type="button" class="toggle-password">👁</button>
                </div>
            </div>

            <div style="align-self:end;">
                <button type="submit" class="btn-primary">
                    Ganti Password
                </button>
            </div>

        </form>

    </div>

</div>

@endsection


@push('scripts')
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
        btn.textContent = "🙈";
    } else {
        input.type = "password";
        btn.textContent = "👁";
    }
}
</script>
@endpush
