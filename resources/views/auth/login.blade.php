<x-guest-layout>
<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">
            <img src="{{ asset('img/sirani-logo.png') }}" class="login-logo" alt="SIRANI">
            <h1>SIRANI</h1>
            <p>Sistem Informasi Laporan Kinerja ASN</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            {{-- NIP --}}
            <div class="form-group">
                <label for="nip">NIP</label>
                <input id="nip"
                       type="text"
                       name="nip"
                       value="{{ old('nip') }}"
                       class="form-input"
                       required
                       autofocus>

                @error('nip')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="form-group">
                <label for="password">Password</label>

                <div class="password-wrapper">
                    <input id="password"
                        type="password"
                        name="password"
                        class="form-input password-input"
                        required>

                    <button type="button"
                            class="toggle-password"
                            onclick="togglePassword()">
                        👁
                    </button>
                </div>

                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>


            {{-- REMEMBER --}}
            <div class="form-remember">
                <label>
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>
            </div>

            {{-- BUTTON --}}
            <button type="submit" class="btn-login">
                Masuk
            </button>

            <div class="login-footer">
                <a href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            </div>
        </form>

    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</x-guest-layout>
