<x-guest-layout :title="'Verifikasi Email · AI Service Center'">

    <p class="auth-title">Verifikasi email Anda</p>
    <p class="auth-sub">Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik link yang sudah kami kirimkan. Jika belum menerima email tersebut, kami akan dengan senang hati mengirimkannya lagi.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-alert">Link verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.</div>
    @endif

    <div class="auth-row">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="auth-submit auth-submit--inline">Kirim Ulang Email Verifikasi</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="auth-link-btn">Keluar</button>
        </form>
    </div>

    <style>
        .auth-title { font-size: 19px; font-weight: 700; margin-bottom: 4px; letter-spacing: -0.01em; }
        .auth-sub { font-size: 13px; color: rgba(255,255,255,0.5); margin-bottom: 20px; line-height: 1.65; }

        .auth-alert {
            background: rgba(72,202,228,0.1);
            border: 1px solid rgba(72,202,228,0.25);
            color: #48CAE4;
            font-size: 12.5px;
            font-weight: 500;
            padding: 11px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .auth-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }

        .auth-submit--inline {
            background: linear-gradient(135deg, #6C63FF, #48CAE4);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(108,99,255,0.35);
            transition: transform 0.15s ease, opacity 0.15s ease;
        }
        .auth-submit--inline:hover { transform: translateY(-1px); opacity: 0.94; }

        .auth-link-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.5);
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
        }
        .auth-link-btn:hover { color: #fff; }
    </style>

</x-guest-layout>