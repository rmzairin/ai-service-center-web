@extends('layouts.users')

@section('content')

<style>
    * { box-sizing: border-box; }

    .history-page { flex: 1; display: flex; flex-direction: column; }

    .history-content {
        flex: 1;
        max-width: 760px;
        width: 100%;
        margin: 0 auto;
        padding: 32px 16px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .history-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 12px;
    }
    .history-title { font-size: 21px; font-weight: 600; color: #fff; margin-bottom: 4px; }
    .history-sub { font-size: 13px; color: rgba(255,255,255,0.4); }

    .btn-new-chat {
        background: linear-gradient(135deg, #6C63FF, #48CAE4);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: transform 0.15s ease, opacity 0.15s ease;
        flex-shrink: 0;
    }
    .btn-new-chat:hover { transform: translateY(-1px); opacity: 0.92; }
    .btn-new-chat svg { width: 14px; height: 14px; }

    .session-list { display: flex; flex-direction: column; gap: 10px; }

    .session-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        transition: border-color 0.15s ease, background 0.15s ease;
    }
    .session-card:hover { border-color: rgba(108,99,255,0.3); background: rgba(255,255,255,0.06); }

    .session-icon {
        width: 38px; height: 38px;
        border-radius: 11px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .session-icon svg { width: 17px; height: 17px; color: rgba(255,255,255,0.55); }
    .session-icon.is-active { background: rgba(72,202,228,0.12); border-color: rgba(72,202,228,0.3); }
    .session-icon.is-active svg { color: #48CAE4; }

    .session-main { flex: 1; min-width: 0; }
    .session-code {
        font-size: 13.5px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 3px;
        font-family: 'JetBrains Mono', monospace;
    }
    .session-meta { font-size: 12px; color: rgba(255,255,255,0.4); display: flex; gap: 10px; flex-wrap: wrap; }

    .session-status {
        font-size: 11px;
        font-weight: 500;
        padding: 4px 11px;
        border-radius: 20px;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .session-status--active { background: rgba(72,202,228,0.12); color: #48CAE4; border: 1px solid rgba(72,202,228,0.25); }
    .session-status--closed { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.45); border: 1px solid rgba(255,255,255,0.1); }

    .session-chevron { width: 16px; height: 16px; color: rgba(255,255,255,0.25); flex-shrink: 0; }

    .history-empty {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255,255,255,0.4);
    }
    .history-empty-icon { font-size: 30px; margin-bottom: 12px; }
</style>

<div class="history-page">
    <div class="history-content">

        <div class="history-head">
            <div>
                <p class="history-title">Riwayat Percakapan</p>
                <p class="history-sub">{{ $sessions->count() }} sesi chat ditemukan</p>
            </div>
            <a href="{{ route('chat.new') }}" class="btn-new-chat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Chat Baru
            </a>
        </div>

        <div class="session-list">
            @forelse($sessions as $s)
                <a href="{{ route('chat.detail', $s->id) }}" class="session-card">
                    <div class="session-icon {{ $s->status === 'active' ? 'is-active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    </div>
                    <div class="session-main">
                        <p class="session-code">{{ $s->session_code }}</p>
                        <div class="session-meta">
                            <span>{{ \Illuminate\Support\Carbon::parse($s->started_at)->translatedFormat('d M Y, H.i') }}</span>
                            <span>·</span>
                            <span style="text-transform: capitalize;">{{ $s->source }}</span>
                        </div>
                    </div>
                    <span class="session-status {{ $s->status === 'active' ? 'session-status--active' : 'session-status--closed' }}">
                        {{ $s->status === 'active' ? 'Aktif' : 'Selesai' }}
                    </span>
                    <svg class="session-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            @empty
                <div class="history-empty">
                    <div class="history-empty-icon">🗂️</div>
                    <p style="font-size: 14.5px; font-weight: 500; color: rgba(255,255,255,0.6); margin-bottom: 4px;">Belum ada riwayat chat</p>
                    <p style="font-size: 13px;">Mulai percakapan pertama Anda dengan Asisten AI.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

@endsection