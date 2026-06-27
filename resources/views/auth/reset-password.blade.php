<x-guest-layout :title="'Reset Password · AI Service Center'">

    <p class="auth-title">Buat password baru</p>
    <p class="auth-sub">Masukkan password baru Anda di bawah ini.</p>

    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-field">
            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="auth-input">
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">Password Baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="auth-input">
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password_confirmation" class="auth-label">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="auth-input">
            @error('password_confirmation')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="auth-submit">Reset Password</button>
    </form>

    <style>
        .auth-title { font-size: 19px; font-weight: 700; margin-bottom: 4px; letter-spacing: -0.01em; }
        .auth-sub { font-size: 13px; color: rgba(255,255,255,0.45); margin-bottom: 24px; line-height: 1.6; }

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
    </style>

</x-guest-layout>