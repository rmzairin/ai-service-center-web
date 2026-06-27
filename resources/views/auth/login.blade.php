<x-guest-layout :title="'Masuk · AI Service Center'">

    @if (session('status'))
        <div class="auth-alert">{{ session('status') }}</div>
    @endif

    <p class="auth-title">Selamat datang kembali</p>
    <p class="auth-sub">Masuk untuk melanjutkan ke AI Service Center.</p>

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="auth-input">
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="auth-input">
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-row">
            <label class="auth-checkbox">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="auth-submit">Masuk</button>
    </form>

    @if (Route::has('register'))
        <p class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    @endif

    <style>
        .auth-alert {
            background: rgba(72,202,228,0.1);
            border: 1px solid rgba(72,202,228,0.25);
            color: #48CAE4;
            font-size: 13px;
            padding: 11px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .auth-title { font-size: 19px; font-weight: 700; margin-bottom: 4px; letter-spacing: -0.01em; }
        .auth-sub { font-size: 13px; color: rgba(255,255,255,0.45); margin-bottom: 24px; }

        .auth-form { display: flex; flex-direction: column; gap: 16px; }
        .auth-field { display: flex; flex-direction: column; }
        .auth-label { font-size: 12.5px; font-weight: 500; color: rgba(255,255,255,0.6); margin-bottom: 6px; }
        .auth-input {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14px;
            color: #fff;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.15s ease, background 0.15s ease;
        }
        .auth-input::placeholder { color: rgba(255,255,255,0.3); }
        .auth-input:focus { border-color: rgba(108,99,255,0.5); background: rgba(255,255,255,0.07); }
        .auth-error { font-size: 12px; color: #F3A6A6; margin-top: 6px; }

        .auth-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
        .auth-checkbox { display: flex; align-items: center; gap: 7px; font-size: 13px; color: rgba(255,255,255,0.6); cursor: pointer; }
        .auth-checkbox input {
            width: 15px; height: 15px;
            accent-color: #6C63FF;
            cursor: pointer;
        }
        .auth-link { font-size: 13px; color: #8B85FF; text-decoration: none; }
        .auth-link:hover { text-decoration: underline; }

        .auth-submit {
            margin-top: 4px;
            background: linear-gradient(135deg, #6C63FF, #48CAE4);
            color: #fff;
            border: none;
            border-radius: 11px;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(108,99,255,0.35);
            transition: transform 0.15s ease, opacity 0.15s ease;
        }
        .auth-submit:hover { transform: translateY(-1px); opacity: 0.94; }

        .auth-footer { margin-top: 20px; text-align: center; font-size: 13px; color: rgba(255,255,255,0.4); }
        .auth-footer a { color: #8B85FF; font-weight: 500; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
    </style>

</x-guest-layout>