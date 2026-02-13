<x-guest-layout>

<div class="auth-page">

    <div class="auth-container">

        <h2>Lupa Password</h2>
        <p>Masukkan email untuk menerima link reset password.</p>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       class="form-input">
            </div>

            <button type="submit" class="btn-primary full">
                Kirim Link Reset
            </button>

            <div class="auth-footer">
                <a href="{{ route('login') }}">← Kembali ke Login</a>
            </div>

        </form>

    </div>

</div>

</x-guest-layout>
