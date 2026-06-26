<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'AI Service Center' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ---------- Top bar ---------- */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .top-bar-left { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-dot {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #6C63FF, #48CAE4);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .logo-dot svg { width: 17px; height: 17px; color: #fff; }
        .brand-name { font-size: 15px; font-weight: 500; color: #fff; letter-spacing: 0.3px; }

        .nav-links { display: none; align-items: center; gap: 4px; margin-left: 28px; }
        @media (min-width: 700px) { .nav-links { display: flex; } }
        .nav-link {
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            padding: 7px 13px;
            border-radius: 8px;
            transition: background 0.12s ease, color 0.12s ease;
        }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .nav-link.is-active { color: #fff; background: rgba(108, 99, 255, 0.22); }

        .top-bar-right { display: flex; align-items: center; gap: 10px; position: relative; }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px;
            padding: 5px 12px 5px 6px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .user-avatar {
            width: 26px; height: 26px;
            background: linear-gradient(135deg, #6C63FF, #48CAE4);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
            font-weight: 500;
            color: #fff;
            flex-shrink: 0;
        }
        .user-pill span { font-size: 13px; color: rgba(255,255,255,0.85); }
        .user-pill svg { width: 13px; height: 13px; color: rgba(255,255,255,0.4); }

        .user-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 170px;
            background: #211f3d;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 6px;
            box-shadow: 0 14px 34px rgba(0,0,0,0.35);
            display: none;
            z-index: 50;
        }
        .user-menu.is-open { display: block; }
        .user-menu a, .user-menu button {
            display: block;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            color: rgba(255,255,255,0.75);
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            padding: 9px 12px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }
        .user-menu a:hover, .user-menu button:hover { background: rgba(255,255,255,0.06); color: #fff; }

        /* ---------- Mobile burger & panel ---------- */
        [x-cloak] { display: none !important; }

        .mobile-burger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 9px;
            color: rgba(255,255,255,0.8);
            cursor: pointer;
            margin-left: 8px;
        }
        .mobile-burger svg { width: 18px; height: 18px; }
        @media (min-width: 700px) { .mobile-burger { display: none; } }

        .mobile-panel {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1A1830;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 10px 16px 14px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            z-index: 90;
        }
        @media (min-width: 700px) { .mobile-panel { display: none !important; } }

        .mobile-link {
            font-size: 14px;
            font-weight: 500;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 8px;
            transition: background 0.12s ease, color 0.12s ease;
        }
        .mobile-link:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .mobile-link.is-active { color: #fff; background: rgba(108, 99, 255, 0.22); }

        /* ---------- Page wrap ---------- */
        .main-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- TOP BAR --}}
    <div class="top-bar" x-data="{ mobileOpen: false }">
        <a href="{{ route('dashboard') }}" class="top-bar-left">
            <div class="logo-dot">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg>
            </div>
            <span class="brand-name">AI Service Center</span>
        </a>

        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">Dashboard</a>
            <a href="{{ route('chat.index') }}" class="nav-link {{ request()->routeIs('chat.index') ? 'is-active' : '' }}">Chat</a>
            <a href="{{ route('chat.history') }}" class="nav-link {{ request()->routeIs('chat.history') || request()->routeIs('chat.detail') ? 'is-active' : '' }}">Riwayat</a>
        </div>

        <button class="mobile-burger" type="button" @click="mobileOpen = !mobileOpen" aria-label="Menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" y1="6" x2="20" y2="6" x-show="!mobileOpen"/>
                <line x1="4" y1="12" x2="20" y2="12" x-show="!mobileOpen"/>
                <line x1="4" y1="18" x2="20" y2="18" x-show="!mobileOpen"/>
                <line x1="6" y1="6" x2="18" y2="18" x-show="mobileOpen" x-cloak/>
                <line x1="18" y1="6" x2="6" y2="18" x-show="mobileOpen" x-cloak/>
            </svg>
        </button>

        <div class="top-bar-right" x-data="{ open: false }" @click.outside="open = false">
            <button class="user-pill" type="button" @click="open = !open">
                <span class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</span>
                <span>{{ Auth::user()->name ?? 'User' }}</span>
                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            <div class="user-menu" :class="{ 'is-open': open }">
                <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            </div>
        </div>

        {{-- Mobile nav panel --}}
        <div class="mobile-panel" x-show="mobileOpen" x-cloak @click.outside="mobileOpen = false">
            <a href="{{ route('dashboard') }}" class="mobile-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">Dashboard</a>
            <a href="{{ route('chat.index') }}" class="mobile-link {{ request()->routeIs('chat.index') ? 'is-active' : '' }}">Chat</a>
            <a href="{{ route('chat.history') }}" class="mobile-link {{ request()->routeIs('chat.history') || request()->routeIs('chat.detail') ? 'is-active' : '' }}">Riwayat</a>
        </div>
    </div>

    {{-- KONTEN --}}
    <div class="main-wrap">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>