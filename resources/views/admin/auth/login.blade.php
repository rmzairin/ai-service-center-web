<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin · AI Service Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #11141A;
            background-image:
                radial-gradient(circle at 1px 1px, rgba(255,255,255,0.035) 1px, transparent 0);
            background-size: 28px 28px;
            color: #E4E7EB;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .panel {
            width: 100%;
            max-width: 408px;
        }
        .status-row {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 28px;
            padding-left: 2px;
        }
        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #3DDC9C;
            box-shadow: 0 0 0 0 rgba(61, 220, 156, 0.5);
            animation: pulse 2.2s ease-out infinite;
            flex-shrink: 0;
        }
        @keyframes pulse {
            0%   { box-shadow: 0 0 0 0 rgba(61, 220, 156, 0.45); }
            70%  { box-shadow: 0 0 0 7px rgba(61, 220, 156, 0); }
            100% { box-shadow: 0 0 0 0 rgba(61, 220, 156, 0); }
        }
        .status-text {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            letter-spacing: 0.02em;
            color: #7A8290;
        }
        .status-text b { color: #9FA7B5; font-weight: 500; }
        .card {
            background: #181B22;
            border: 1px solid #262A33;
            border-radius: 14px;
            padding: 36px 32px 30px;
        }
        .eyebrow {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #4D5562;
            margin: 0 0 10px;
        }
        h1 {
            font-size: 21px;
            font-weight: 600;
            margin: 0 0 6px;
            color: #F2F3F5;
            letter-spacing: -0.01em;
        }
        .sub {
            font-size: 13.5px;
            color: #6B7280;
            margin: 0 0 26px;
            line-height: 1.5;
        }
        .alert {
            background: rgba(217, 89, 89, 0.1);
            border: 1px solid rgba(217, 89, 89, 0.3);
            border-radius: 8px;
            padding: 11px 14px;
            margin-bottom: 20px;
        }
        .alert p {
            margin: 0;
            font-size: 13px;
            color: #F0A8A8;
            line-height: 1.5;
        }
        .field { margin-bottom: 18px; }
        .field label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: #8B92A0;
            margin-bottom: 7px;
        }
        .field input {
            width: 100%;
            background: #11141A;
            border: 1px solid #2A2F38;
            border-radius: 8px;
            padding: 11px 13px;
            font-size: 14.5px;
            color: #E4E7EB;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.15s ease;
        }
        .field input::placeholder { color: #4D5562; }
        .field input:focus {
            outline: none;
            border-color: #3DDC9C;
            box-shadow: 0 0 0 3px rgba(61, 220, 156, 0.12);
        }
        button[type="submit"] {
            width: 100%;
            background: #3DDC9C;
            color: #0B2C20;
            border: none;
            border-radius: 8px;
            padding: 12px 0;
            font-size: 14.5px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 6px;
            transition: background 0.15s ease, transform 0.05s ease;
            font-family: 'Inter', sans-serif;
        }
        button[type="submit"]:hover { background: #4FE6AB; }
        button[type="submit"]:active { transform: scale(0.99); }
        .footer-note {
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            color: #4D5562;
            margin-top: 22px;
            letter-spacing: 0.01em;
        }
    </style>
</head>
<body>

    <div class="panel">
        <div class="status-row">
            <span class="dot"></span>
            <span class="status-text"><b>AI Service Center</b> — sistem aktif</span>
        </div>

        <div class="card">
            <p class="eyebrow">Akses terbatas</p>
            <h1>Masuk sebagai admin</h1>
            <p class="sub">Gunakan kredensial admin untuk mengelola knowledge base, kategori, dan operasional chatbot.</p>

            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           placeholder="admin@domain.com" required autofocus>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="••••••••" required>
                </div>

                <button type="submit">Masuk ke panel admin</button>
            </form>
        </div>

        <p class="footer-note">admin.ai-service-center · v1.0</p>
    </div>

</body>
</html>