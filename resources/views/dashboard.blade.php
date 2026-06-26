@extends('layouts.users')

@section('content')

<style>
    * { box-sizing: border-box; }

    .dash-page {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .dash-content {
        flex: 1;
        max-width: 760px;
        width: 100%;
        margin: 0 auto;
        padding: 48px 16px 32px;
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .dash-hero { text-align: center; }
    .dash-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(108, 99, 255, 0.12);
        border: 1px solid rgba(108, 99, 255, 0.28);
        border-radius: 20px;
        padding: 5px 14px;
        margin-bottom: 18px;
        font-size: 12px;
        font-weight: 500;
        color: #B3ACFF;
    }
    .dash-badge svg { width: 13px; height: 13px; }

    .dash-title {
        font-size: 26px;
        font-weight: 600;
        color: #fff;
        letter-spacing: -0.02em;
        margin-bottom: 8px;
    }
    .dash-sub {
        font-size: 14px;
        color: rgba(255,255,255,0.45);
        max-width: 440px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .dash-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 600px) { .dash-actions { grid-template-columns: 1fr; } }

    .dash-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        padding: 26px;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        transition: transform 0.15s ease, border-color 0.15s ease, background 0.15s ease;
    }
    .dash-card:hover {
        transform: translateY(-2px);
        border-color: rgba(108, 99, 255, 0.35);
        background: rgba(255,255,255,0.06);
    }

    .dash-card-icon {
        width: 44px; height: 44px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .dash-card-icon svg { width: 21px; height: 21px; color: #fff; }
    .dash-card-icon--primary { background: linear-gradient(135deg, #6C63FF, #48CAE4); }
    .dash-card-icon--secondary { background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); }
    .dash-card-icon--secondary svg { color: rgba(255,255,255,0.7); }

    .dash-card-title { font-size: 15.5px; font-weight: 600; color: #fff; margin-bottom: 5px; }
    .dash-card-text { font-size: 12.5px; color: rgba(255,255,255,0.45); line-height: 1.5; margin-bottom: 16px; flex: 1; }

    .dash-card-cta {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
    }
    .dash-card-cta--primary { color: #B3ACFF; }
    .dash-card-cta--secondary { color: rgba(255,255,255,0.6); }
    .dash-card-cta svg { width: 14px; height: 14px; }

    .dash-tips {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 16px;
        padding: 18px 22px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }
    .dash-tips-icon {
        width: 32px; height: 32px;
        border-radius: 10px;
        background: rgba(72, 202, 228, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .dash-tips-icon svg { width: 16px; height: 16px; color: #48CAE4; }
    .dash-tips-title { font-size: 13.5px; font-weight: 600; color: #fff; margin-bottom: 3px; }
    .dash-tips-text { font-size: 12.5px; color: rgba(255,255,255,0.45); line-height: 1.6; }
</style>

<div class="dash-page">
    <div class="dash-content">

        <div class="dash-hero">
            <span class="dash-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg>
                AI Service Center
            </span>
            <h1 class="dash-title">Halo, {{ Auth::user()->name ?? 'Pengguna' }} 👋</h1>
            <p class="dash-sub">Asisten AI kami siap membantu menjawab pertanyaan Anda kapan saja. Mulai percakapan baru atau lanjutkan dari riwayat sebelumnya.</p>
        </div>

        <div class="dash-actions">
            <a href="{{ route('chat.index') }}" class="dash-card">
                <div class="dash-card-icon dash-card-icon--primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                </div>
                <p class="dash-card-title">Mulai / Lanjutkan Chat</p>
                <p class="dash-card-text">Tanyakan apa saja ke Asisten AI kami — lanjut dari sesi aktif Anda atau mulai percakapan baru.</p>
                <span class="dash-card-cta dash-card-cta--primary">
                    Buka Chat
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
            </a>

            <a href="{{ route('chat.history') }}" class="dash-card">
                <div class="dash-card-icon dash-card-icon--secondary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/><path d="M12 7v5l4 2"/></svg>
                </div>
                <p class="dash-card-title">Riwayat Percakapan</p>
                <p class="dash-card-text">Lihat kembali semua sesi chat Anda sebelumnya, beserta status dan tanggalnya.</p>
                <span class="dash-card-cta dash-card-cta--secondary">
                    Lihat Riwayat
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
            </a>
        </div>

        <div class="dash-tips">
            <div class="dash-tips-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </div>
            <div>
                <p class="dash-tips-title">Tips</p>
                <p class="dash-tips-text">Semakin spesifik pertanyaan Anda — misalnya menyertakan nomor pesanan atau nama produk — semakin cepat Asisten AI dapat membantu.</p>
            </div>
        </div>

    </div>
</div>

@endsection