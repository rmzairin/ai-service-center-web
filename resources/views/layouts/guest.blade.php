<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'AI Service Center' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #fff;
            min-height: 100vh;
        }
        a { color: inherit; }

        .glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
        .glow--1 { width: 380px; height: 380px; background: rgba(108,99,255,0.25); top: -100px; left: -100px; }
        .glow--2 { width: 340px; height: 340px; background: rgba(72,202,228,0.18); bottom: -80px; right: -80px; }

        .guest-shell {
            position: relative;
            z-index: 5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
        }

        .guest-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 28px;
        }
        .guest-brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #6C63FF, #48CAE4);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .guest-brand-icon svg { width: 19px; height: 19px; color: #fff; }
        .guest-brand-name { font-size: 16px; font-weight: 600; }

        .guest-card {
            width: 100%;
            max-width: 400px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.35);
            backdrop-filter: blur(10px);
        }

        .guest-footer-link {
            margin-top: 22px;
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            text-align: center;
        }
        .guest-footer-link a { color: #8B85FF; font-weight: 500; text-decoration: none; }
        .guest-footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="glow glow--1"></div>
    <div class="glow glow--2"></div>

    <div class="guest-shell">
        <a href="{{ url('/') }}" class="guest-brand">
            <span class="guest-brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg>
            </span>
            <span class="guest-brand-name">AI Service Center</span>
        </a>

        <div class="guest-card">
            {{ $slot }}
        </div>
    </div>

</body>
</html>