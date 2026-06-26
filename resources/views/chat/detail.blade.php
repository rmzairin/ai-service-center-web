@extends('layouts.users')

@section('content')

<style>
    * { box-sizing: border-box; }

    .detail-page { flex: 1; display: flex; flex-direction: column; }

    .detail-content {
        flex: 1;
        max-width: 760px;
        width: 100%;
        margin: 0 auto;
        padding: 24px 16px 32px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .detail-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: rgba(255,255,255,0.5);
        text-decoration: none;
        width: fit-content;
        transition: color 0.12s ease;
    }
    .detail-back:hover { color: #fff; }
    .detail-back svg { width: 14px; height: 14px; }

    .detail-head-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .detail-head-bar h1 {
        font-size: 17px;
        font-weight: 600;
        color: #fff;
        font-family: 'JetBrains Mono', monospace;
    }
    .session-status {
        font-size: 11px;
        font-weight: 500;
        padding: 4px 11px;
        border-radius: 20px;
        white-space: nowrap;
    }
    .session-status--active { background: rgba(72,202,228,0.12); color: #48CAE4; border: 1px solid rgba(72,202,228,0.25); }
    .session-status--closed { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.45); border: 1px solid rgba(255,255,255,0.1); }

    .chat-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
    }
    .chat-box {
        max-height: 520px;
        overflow-y: auto;
        padding: 22px 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.1) transparent;
    }

    .msg-row { display: flex; align-items: flex-end; gap: 10px; }
    .msg-row.user { flex-direction: row-reverse; }

    .msg-avatar {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .msg-avatar svg { width: 14px; height: 14px; color: rgba(255,255,255,0.5); }
    .msg-avatar.user-av { background: linear-gradient(135deg, #6C63FF, #48CAE4); }
    .msg-avatar.user-av svg { color: #fff; }

    .msg-col { display: flex; flex-direction: column; max-width: 75%; }
    .msg-row.user .msg-col { align-items: flex-end; }

    .bubble {
        padding: 11px 15px;
        border-radius: 16px;
        font-size: 13.5px;
        line-height: 1.6;
        word-break: break-word;
    }
    .bubble.bot {
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.88);
        border-bottom-left-radius: 4px;
    }
    .bubble.user {
        background: linear-gradient(135deg, #6C63FF, #5558b8);
        color: #fff;
        border-bottom-right-radius: 4px;
        border: 1px solid rgba(108,99,255,0.4);
    }
    .bubble-time { font-size: 10px; color: rgba(255,255,255,0.3); margin-top: 4px; }

    .detail-footer {
        padding: 16px 20px;
        border-top: 1px solid rgba(255,255,255,0.06);
        background: rgba(0,0,0,0.15);
        text-align: center;
    }
    .detail-footer p { font-size: 12.5px; color: rgba(255,255,255,0.4); margin-bottom: 10px; }

    .btn-new-chat {
        background: linear-gradient(135deg, #6C63FF, #48CAE4);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    @media (max-width: 560px) { .msg-col { max-width: 84%; } }
</style>

<div class="detail-page">
    <div class="detail-content">

        <a href="{{ route('chat.history') }}" class="detail-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Riwayat
        </a>

        <div class="detail-head-bar">
            <h1>{{ $session->session_code }}</h1>
            <span class="session-status {{ $session->status === 'active' ? 'session-status--active' : 'session-status--closed' }}">
                {{ $session->status === 'active' ? 'Aktif' : 'Selesai' }}
            </span>
        </div>

        <div class="chat-card">
            <div class="chat-box">
                @forelse($session->messages as $msg)
                    <div class="msg-row {{ $msg->sender_type === 'user' ? 'user' : '' }}">
                        <div class="msg-avatar {{ $msg->sender_type === 'user' ? 'user-av' : '' }}">
                            @if($msg->sender_type === 'user')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg>
                            @endif
                        </div>
                        <div class="msg-col">
                            <div class="bubble {{ $msg->sender_type === 'user' ? 'user' : 'bot' }}">{{ $msg->message }}</div>
                            <div class="bubble-time">{{ $msg->created_at->format('H.i') }}</div>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: rgba(255,255,255,0.4); font-size: 13px; margin: auto;">Tidak ada pesan dalam sesi ini.</p>
                @endforelse
            </div>

            @if($session->status === 'closed')
                <div class="detail-footer">
                    <p>Sesi ini telah berakhir. Ada pertanyaan lain?</p>
                    <a href="{{ route('chat.new') }}" class="btn-new-chat">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Mulai Chat Baru
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection