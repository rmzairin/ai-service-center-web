<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Service Center — Asisten cerdas untuk setiap pertanyaan</title>
    <meta name="description" content="AI Service Center menjawab pertanyaan pelanggan Anda secara instan, 24/7, dengan basis pengetahuan yang selalu Anda kendalikan.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --bg-deep: #0a0820;
            --bg-1: #0f0c29;
            --bg-2: #302b63;
            --bg-3: #24243e;
            --violet: #6C63FF;
            --violet-soft: #8A82FF;
            --cyan: #48CAE4;
            --ink: #F5F5FF;
            --ink-dim: rgba(245,245,255,0.55);
            --ink-faint: rgba(245,245,255,0.32);
            --line: rgba(255,255,255,0.09);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background: var(--bg-deep);
            color: var(--ink);
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, .display {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            letter-spacing: -0.02em;
        }

        a { color: inherit; text-decoration: none; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; scroll-behavior: auto !important; }
        }

        :focus-visible {
            outline: 2px solid var(--cyan);
            outline-offset: 3px;
            border-radius: 4px;
        }

        /* ================= Background atmosphere ================= */
        .atmosphere {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 70% 50% at 20% -10%, rgba(108,99,255,0.30), transparent 60%),
                radial-gradient(ellipse 60% 45% at 100% 15%, rgba(72,202,228,0.16), transparent 55%),
                radial-gradient(ellipse 80% 60% at 50% 110%, rgba(48,43,99,0.5), transparent 60%),
                linear-gradient(160deg, var(--bg-1), var(--bg-3) 55%, var(--bg-deep));
            pointer-events: none;
        }
        .grain {
            position: fixed;
            inset: 0;
            z-index: 1;
            opacity: 0.025;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        .shell { position: relative; z-index: 2; }

        /* ================= Topbar ================= */
        .topbar {
            max-width: 1180px;
            margin: 0 auto;
            padding: 22px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand { display: flex; align-items: center; gap: 10px; }
        .brand-mark {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--violet), var(--cyan));
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 6px 18px rgba(108,99,255,0.35);
        }
        .brand-mark svg { width: 18px; height: 18px; color: #fff; }
        .brand-name { font-family: 'Space Grotesk', sans-serif; font-weight: 600; font-size: 15.5px; }

        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .btn-ghost {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink-dim);
            padding: 9px 16px;
            border-radius: 9px;
            transition: color 0.15s ease, background 0.15s ease;
        }
        .btn-ghost:hover { color: var(--ink); background: rgba(255,255,255,0.06); }
        .btn-solid {
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            padding: 9px 18px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--violet), var(--cyan));
            box-shadow: 0 6px 18px rgba(108,99,255,0.3);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-solid:hover { transform: translateY(-1px); box-shadow: 0 8px 22px rgba(108,99,255,0.42); }

        /* ================= Hero ================= */
        .hero {
            max-width: 1180px;
            margin: 0 auto;
            padding: 56px 24px 40px;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 56px;
            align-items: center;
        }
        @media (max-width: 980px) {
            .hero { grid-template-columns: 1fr; padding-top: 28px; gap: 40px; }
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--cyan);
            background: rgba(72,202,228,0.1);
            border: 1px solid rgba(72,202,228,0.25);
            border-radius: 20px;
            padding: 6px 14px;
            margin-bottom: 22px;
        }
        .eyebrow-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--cyan);
            box-shadow: 0 0 8px rgba(72,202,228,0.9);
            animation: blink 2s ease-in-out infinite;
        }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.35; } }

        .hero h1 {
            font-size: clamp(32px, 4.4vw, 50px);
            font-weight: 700;
            line-height: 1.08;
            margin-bottom: 20px;
        }
        .hero h1 .accent {
            background: linear-gradient(135deg, var(--violet-soft), var(--cyan));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .hero p.lede {
            font-size: 16px;
            line-height: 1.65;
            color: var(--ink-dim);
            max-width: 480px;
            margin-bottom: 30px;
        }

        .hero-ctas { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 36px; }
        .btn-primary-lg {
            font-size: 14.5px;
            font-weight: 600;
            color: #fff;
            padding: 13px 24px;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--violet), var(--cyan));
            box-shadow: 0 10px 28px rgba(108,99,255,0.35);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-primary-lg:hover { transform: translateY(-2px); box-shadow: 0 14px 34px rgba(108,99,255,0.45); }
        .btn-primary-lg svg { width: 16px; height: 16px; }
        .btn-secondary-lg {
            font-size: 14.5px;
            font-weight: 600;
            color: var(--ink);
            padding: 13px 22px;
            border-radius: 11px;
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.03);
            transition: background 0.15s ease, border-color 0.15s ease;
        }
        .btn-secondary-lg:hover { background: rgba(255,255,255,0.07); border-color: rgba(255,255,255,0.18); }

        .trust-row { display: flex; align-items: center; gap: 22px; flex-wrap: wrap; }
        .trust-item { display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: var(--ink-faint); }
        .trust-item svg { width: 15px; height: 15px; color: var(--cyan); flex-shrink: 0; }

        /* ---- Signature element: live chat mock ---- */
        .chat-mock {
            background: rgba(255,255,255,0.045);
            border: 1px solid var(--line);
            border-radius: 22px;
            backdrop-filter: blur(18px);
            box-shadow: 0 30px 70px rgba(5,3,20,0.5);
            overflow: hidden;
            position: relative;
        }
        .orbit {
            position: absolute;
            top: -40px; right: -40px;
            width: 180px; height: 180px;
            pointer-events: none;
        }
        .orbit span {
            position: absolute;
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--cyan);
            box-shadow: 0 0 10px rgba(72,202,228,0.8);
            animation: orbit-spin 9s linear infinite;
        }
        .orbit span:nth-child(2) { background: var(--violet-soft); box-shadow: 0 0 10px rgba(138,130,255,0.8); animation-duration: 13s; animation-direction: reverse; }
        .orbit span:nth-child(3) { background: var(--cyan); opacity: 0.6; animation-duration: 16s; }
        @keyframes orbit-spin {
            from { transform: rotate(0deg) translateX(90px) rotate(0deg); }
            to   { transform: rotate(360deg) translateX(90px) rotate(-360deg); }
        }

        .chat-mock-head {
            display: flex; align-items: center; gap: 11px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--line);
        }
        .chat-mock-avatar {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--violet), var(--cyan));
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .chat-mock-avatar svg { width: 17px; height: 17px; color: #fff; }
        .chat-mock-head h4 { font-size: 13.5px; font-weight: 600; }
        .chat-mock-head span { font-size: 11.5px; color: var(--ink-faint); }
        .live-pill {
            margin-left: auto;
            display: flex; align-items: center; gap: 5px;
            font-size: 10.5px; color: var(--cyan);
            background: rgba(72,202,228,0.1);
            border: 1px solid rgba(72,202,228,0.25);
            border-radius: 20px;
            padding: 4px 9px;
        }
        .live-pill .eyebrow-dot { width: 5px; height: 5px; }

        .chat-mock-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            min-height: 230px;
        }
        .mm-row { display: flex; align-items: flex-end; gap: 9px; opacity: 0; animation: rise 0.5s ease forwards; }
        .mm-row.user { flex-direction: row-reverse; }
        @keyframes rise { to { opacity: 1; transform: translateY(0); } from { transform: translateY(6px); } }

        .mm-row[data-step="1"] { animation-delay: 0.3s; }
        .mm-row[data-step="2"] { animation-delay: 2.0s; }
        .mm-row[data-step="3"] { animation-delay: 4.0s; }

        .mm-av {
            width: 24px; height: 24px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .mm-av svg { width: 12px; height: 12px; color: rgba(255,255,255,0.5); }
        .mm-av.user-av { background: linear-gradient(135deg, var(--violet), var(--cyan)); }
        .mm-av.user-av svg { color: #fff; }

        .mm-bubble {
            max-width: 78%;
            padding: 10px 14px;
            border-radius: 14px;
            font-size: 12.5px;
            line-height: 1.55;
        }
        .mm-bubble.bot { background: rgba(255,255,255,0.06); border: 1px solid var(--line); border-bottom-left-radius: 4px; color: rgba(255,255,255,0.85); }
        .mm-bubble.user { background: linear-gradient(135deg, var(--violet), #5558b8); border-bottom-right-radius: 4px; color: #fff; }

        .typing-row { display: flex; align-items: flex-end; gap: 9px; opacity: 0; animation: type-show 0.4s ease forwards; animation-delay: 1.0s; }
        @keyframes type-show { to { opacity: 1; } }
        .typing-dots {
            display: flex; gap: 4px;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 10px 13px;
        }
        .typing-dots span { width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.4); animation: bounce 1.3s infinite; }
        .typing-dots span:nth-child(2) { animation-delay: 0.15s; }
        .typing-dots span:nth-child(3) { animation-delay: 0.3s; }
        @keyframes bounce { 0%, 80%, 100% { transform: translateY(0); opacity: 0.4; } 40% { transform: translateY(-4px); opacity: 1; } }

        .chat-mock-foot {
            padding: 14px 18px;
            border-top: 1px solid var(--line);
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(0,0,0,0.15);
        }
        .fake-input {
            flex: 1;
            font-size: 12.5px;
            color: var(--ink-faint);
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--line);
            border-radius: 11px;
            padding: 9px 13px;
        }
        .fake-send {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--violet), var(--cyan));
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .fake-send svg { width: 15px; height: 15px; color: #fff; }

        /* ================= Logos / stats strip ================= */
        .stats-strip {
            max-width: 1180px;
            margin: 0 auto;
            padding: 28px 24px 64px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        @media (max-width: 700px) { .stats-strip { grid-template-columns: 1fr; } }
        .stat-card {
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.03);
            border-radius: 16px;
            padding: 22px 24px;
        }
        .stat-num { font-family: 'Space Grotesk', sans-serif; font-size: 28px; font-weight: 700; margin-bottom: 4px; }
        .stat-num .unit { font-size: 16px; color: var(--ink-dim); }
        .stat-label { font-size: 12.5px; color: var(--ink-faint); }

        /* ================= Features ================= */
        .section { max-width: 1180px; margin: 0 auto; padding: 70px 24px; }
        .section-head { max-width: 560px; margin-bottom: 44px; }
        .section-eyebrow {
            font-size: 12px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase;
            color: var(--violet-soft); margin-bottom: 12px;
        }
        .section-head h2 { font-size: clamp(24px, 3vw, 32px); font-weight: 700; line-height: 1.25; margin-bottom: 12px; }
        .section-head p { font-size: 14.5px; color: var(--ink-dim); line-height: 1.6; }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }
        @media (max-width: 900px) { .feature-grid { grid-template-columns: 1fr; } }

        .feature-card {
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.03);
            border-radius: 18px;
            padding: 26px;
            transition: border-color 0.2s ease, background 0.2s ease, transform 0.2s ease;
        }
        .feature-card:hover { border-color: rgba(108,99,255,0.35); background: rgba(255,255,255,0.05); transform: translateY(-3px); }
        .feature-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(108,99,255,0.18), rgba(72,202,228,0.18));
            border: 1px solid rgba(108,99,255,0.25);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }
        .feature-icon svg { width: 19px; height: 19px; color: var(--cyan); }
        .feature-card h3 { font-size: 15.5px; font-weight: 600; margin-bottom: 8px; }
        .feature-card p { font-size: 13px; color: var(--ink-dim); line-height: 1.6; }

        /* ================= How it works ================= */
        .flow-rail {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            position: relative;
        }
        @media (max-width: 900px) { .flow-rail { grid-template-columns: 1fr; gap: 14px; } }
        .flow-step {
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.03);
            border-radius: 16px;
            padding: 24px;
        }
        .flow-tag {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 12px; font-weight: 600;
            color: var(--cyan);
            margin-bottom: 14px;
            display: block;
        }
        .flow-step h3 { font-size: 15px; font-weight: 600; margin-bottom: 8px; }
        .flow-step p { font-size: 13px; color: var(--ink-dim); line-height: 1.6; }

        /* ================= CTA band ================= */
        .cta-band {
            max-width: 1180px;
            margin: 0 auto 70px;
            padding: 56px 40px;
            border-radius: 26px;
            background: linear-gradient(135deg, rgba(108,99,255,0.16), rgba(72,202,228,0.10));
            border: 1px solid rgba(108,99,255,0.25);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        @media (max-width: 600px) { .cta-band { padding: 40px 22px; } }
        .cta-band h2 { font-size: clamp(22px, 3vw, 30px); font-weight: 700; margin-bottom: 14px; }
        .cta-band p { font-size: 14.5px; color: var(--ink-dim); margin-bottom: 26px; max-width: 460px; margin-inline: auto; }

        /* ================= Footer ================= */
        footer {
            max-width: 1180px;
            margin: 0 auto;
            padding: 28px 24px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid var(--line);
            font-size: 12.5px;
            color: var(--ink-faint);
            flex-wrap: wrap;
            gap: 12px;
        }
    </style>
</head>
<body>

    <div class="atmosphere"></div>
    <div class="grain"></div>

    <div class="shell">

        {{-- TOPBAR --}}
        <div class="topbar">
            <div class="brand">
                <div class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg>
                </div>
                <span class="brand-name">AI Service Center</span>
            </div>

            @if (Route::has('login'))
                <div class="topbar-actions">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-solid">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-solid">Daftar Gratis</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        {{-- HERO --}}
        <div class="hero">
            <div>
                <span class="eyebrow"><span class="eyebrow-dot"></span> Asisten AI aktif 24/7</span>
                <h1>Jawaban instan untuk <span class="accent">setiap pertanyaan</span> pelanggan Anda</h1>
                <p class="lede">AI Service Center memahami basis pengetahuan bisnis Anda dan menjawab pertanyaan pelanggan secara natural, kapan saja — tanpa antrean, tanpa menunggu jam kerja.</p>

                <div class="hero-ctas">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary-lg">
                            Buka Dashboard
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary-lg">
                                Mulai Gratis
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        @endif
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn-secondary-lg">Sudah punya akun? Masuk</a>
                        @endif
                    @endauth
                </div>

                <div class="trust-row">
                    <span class="trust-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Respons rata-rata di bawah 2 detik
                    </span>
                    <span class="trust-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
                        Data Anda tetap privat
                    </span>
                </div>
            </div>

            {{-- Signature element: live chat mock --}}
            <div class="chat-mock">
                <div class="orbit" aria-hidden="true">
                    <span></span><span></span><span></span>
                </div>
                <div class="chat-mock-head">
                    <div class="chat-mock-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg>
                    </div>
                    <div>
                        <h4>Asisten AI</h4>
                        <span>Siap membantu Anda 24/7</span>
                    </div>
                    <span class="live-pill"><span class="eyebrow-dot"></span> Live</span>
                </div>

                <div class="chat-mock-body">
                    <div class="mm-row" data-step="1">
                        <div class="mm-av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg></div>
                        <div class="mm-bubble bot">Halo! Ada yang bisa saya bantu hari ini? 👋</div>
                    </div>

                    <div class="mm-row user" data-step="2">
                        <div class="mm-av user-av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                        <div class="mm-bubble user">Status pengiriman pesanan ORD-2201?</div>
                    </div>

                    <div class="typing-row">
                        <div class="mm-av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg></div>
                        <div class="typing-dots"><span></span><span></span><span></span></div>
                    </div>

                    <div class="mm-row" data-step="3">
                        <div class="mm-av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg></div>
                        <div class="mm-bubble bot">Pesanan Anda sedang dikirim, estimasi tiba besok sore. 📦</div>
                    </div>
                </div>

                <div class="chat-mock-foot">
                    <div class="fake-input">Ketik pertanyaan Anda...</div>
                    <div class="fake-send">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATS STRIP --}}
        <div class="stats-strip">
            <div class="stat-card">
                <div class="stat-num">&lt;2<span class="unit">dtk</span></div>
                <div class="stat-label">Rata-rata waktu respons pertama</div>
            </div>
            <div class="stat-card">
                <div class="stat-num">24<span class="unit">/7</span></div>
                <div class="stat-label">Selalu aktif, tanpa jam istirahat</div>
            </div>
            <div class="stat-card">
                <div class="stat-num">100<span class="unit">%</span></div>
                <div class="stat-label">Basis pengetahuan dalam kendali Anda</div>
            </div>
        </div>

        {{-- FEATURES --}}
        <div class="section">
            <div class="section-head">
                <p class="section-eyebrow">Mengapa AI Service Center</p>
                <h2>Dibangun untuk menjawab, bukan sekadar membalas</h2>
                <p>Setiap jawaban berasal dari basis pengetahuan yang Anda susun sendiri — bukan tebakan generik dari internet.</p>
            </div>

            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
                    </div>
                    <h3>Basis pengetahuan Anda sendiri</h3>
                    <p>Susun pertanyaan dan jawaban yang relevan dengan bisnis Anda. Asisten AI menjawab persis sesuai apa yang Anda ajarkan.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3>Balasan dalam hitungan detik</h3>
                    <p>Tidak ada antrean, tidak ada waktu tunggu. Pelanggan mendapat jawaban begitu pertanyaan dikirim, jam berapa pun.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    </div>
                    <h3>Terus belajar dari masukan</h3>
                    <p>Setiap percakapan dan penilaian pelanggan masuk ke panel admin, membantu Anda menyempurnakan jawaban dari waktu ke waktu.</p>
                </div>
            </div>
        </div>

        {{-- HOW IT WORKS --}}
        <div class="section" style="padding-top: 0;">
            <div class="section-head">
                <p class="section-eyebrow">Cara kerja</p>
                <h2>Tiga langkah dari pertanyaan ke jawaban</h2>
            </div>

            <div class="flow-rail">
                <div class="flow-step">
                    <span class="flow-tag">Langkah 1</span>
                    <h3>Pelanggan bertanya</h3>
                    <p>Pengguna menulis pertanyaan dengan bahasa sehari-hari, tanpa format atau kata kunci khusus.</p>
                </div>
                <div class="flow-step">
                    <span class="flow-tag">Langkah 2</span>
                    <h3>AI mencocokkan konteks</h3>
                    <p>Sistem mencari jawaban paling relevan dari basis pengetahuan yang sudah Anda susun di panel admin.</p>
                </div>
                <div class="flow-step">
                    <span class="flow-tag">Langkah 3</span>
                    <h3>Jawaban terkirim</h3>
                    <p>Pelanggan menerima balasan yang jelas dan langsung — dan bisa memberi penilaian untuk membantu sistem belajar.</p>
                </div>
            </div>
        </div>

        {{-- CTA BAND --}}
        <div class="cta-band">
            <h2>Siap memberi jawaban instan untuk pelanggan Anda?</h2>
            <p>Mulai susun basis pengetahuan Anda hari ini dan biarkan Asisten AI bekerja sepanjang waktu.</p>
            <div class="hero-ctas" style="justify-content: center;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary-lg">Buka Dashboard</a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary-lg">Mulai Gratis</a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn-secondary-lg">Masuk</a>
                    @endif
                @endauth
            </div>
        </div>

        {{-- FOOTER --}}
        <footer>
            <span>© {{ date('Y') }} AI Service Center</span>
            <span>Dibangun dengan Laravel</span>
        </footer>

    </div>

</body>
</html>