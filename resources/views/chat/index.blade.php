@extends('layouts.users')

@section('content')

<style>
    * { box-sizing: border-box; }

    .chat-page {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        max-width: 760px;
        width: 100%;
        margin: 0 auto;
        padding: 24px 16px 32px;
        gap: 16px;
    }

    .status-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }

    .status-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(72, 202, 228, 0.12);
        border: 1px solid rgba(72, 202, 228, 0.25);
        border-radius: 20px;
        padding: 4px 12px;
    }

    .status-dot {
        width: 7px; height: 7px;
        background: #48CAE4;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    .status-badge span { font-size: 12px; color: #48CAE4; font-weight: 500; }
    .session-info { font-size: 12px; color: rgba(255,255,255,0.4); }

    .chat-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        padding: 14px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .bot-avatar {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #6C63FF, #48CAE4);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .bot-avatar svg { width: 18px; height: 18px; color: #fff; }

    .bot-info h3 { font-size: 14px; font-weight: 500; color: #fff; margin: 0; }
    .bot-info span { font-size: 12px; color: rgba(255,255,255,0.45); }

    .chat-box {
        height: 340px;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.1) transparent;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
        gap: 10px;
        padding: 40px 20px;
        text-align: center;
        margin: auto;
    }
    .empty-icon {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, rgba(108,99,255,0.18), rgba(72,202,228,0.18));
        border: 1px solid rgba(108,99,255,0.25);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .msg-row {
        display: flex;
        align-items: flex-end;
        gap: 10px;
    }
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

    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .typing-dots {
        display: flex;
        gap: 4px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 10px 14px;
    }
    .typing-dots span {
        width: 6px; height: 6px;
        background: rgba(255,255,255,0.4);
        border-radius: 50%;
        animation: bounce 1.4s infinite;
    }
    .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
    .typing-dots span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes bounce {
        0%, 80%, 100% { transform: translateY(0); opacity: 0.4; }
        40% { transform: translateY(-5px); opacity: 1; }
    }

    .chat-input-area {
        padding: 14px 16px;
        border-top: 1px solid rgba(255,255,255,0.06);
        display: flex;
        gap: 10px;
        align-items: flex-end;
        background: rgba(0,0,0,0.2);
    }

    .input-wrap {
        flex: 1;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 14px;
        display: flex;
        align-items: center;
        padding: 10px 14px;
        gap: 8px;
        transition: border-color 0.2s;
    }
    .input-wrap:focus-within { border-color: rgba(108,99,255,0.5); }
    .input-wrap input {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        font-size: 13.5px;
        color: #fff;
        font-family: 'Inter', sans-serif;
    }
    .input-wrap input::placeholder { color: rgba(255,255,255,0.3); }
    .input-wrap input:disabled { opacity: 0.5; cursor: not-allowed; }

    .send-btn {
        width: 42px; height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6C63FF, #48CAE4);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.15s, opacity 0.15s;
    }
    .send-btn svg { width: 18px; height: 18px; color: #fff; }
    .send-btn:hover { transform: scale(1.05); }
    .send-btn:active { transform: scale(0.96); }
    .send-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

    .feedback-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        padding: 20px;
    }

    .feedback-title { font-size: 14px; font-weight: 500; color: #fff; margin-bottom: 4px; }
    .feedback-sub { font-size: 12px; color: rgba(255,255,255,0.4); margin-bottom: 16px; }

    .stars { display: flex; gap: 8px; margin-bottom: 14px; }
    .star-btn {
        font-size: 26px;
        background: none;
        border: none;
        cursor: pointer;
        color: rgba(255,255,255,0.2);
        transition: color 0.15s, transform 0.15s;
        line-height: 1;
        padding: 0;
    }
    .star-btn:hover { transform: scale(1.15); }
    .star-btn.active { color: #F5C347; }

    .feedback-textarea {
        width: 100%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 13px;
        color: #fff;
        resize: none;
        outline: none;
        margin-bottom: 12px;
        font-family: 'Inter', sans-serif;
    }
    .feedback-textarea::placeholder { color: rgba(255,255,255,0.3); }
    .feedback-textarea:focus { border-color: rgba(108,99,255,0.5); }

    .submit-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #6C63FF, #48CAE4);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: transform 0.15s, opacity 0.15s;
        font-family: 'Inter', sans-serif;
    }
    .submit-btn svg { width: 15px; height: 15px; }
    .submit-btn:hover { transform: translateY(-1px); opacity: 0.9; }
    .submit-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

    .feedback-done-row {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(72,202,228,0.1);
        border: 1px solid rgba(72,202,228,0.25);
        border-radius: 12px;
        padding: 14px 18px;
    }
    .feedback-done-row span.emoji { font-size: 20px; }
    .feedback-done-row p { margin: 0; }
    .feedback-done-title { font-size: 14px; font-weight: 500; color: #fff; margin-bottom: 2px; }
    .feedback-done-sub { font-size: 12.5px; color: rgba(255,255,255,0.45); }

    .btn-new-chat {
        margin-top: 12px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        color: #fff;
        border-radius: 10px;
        padding: 9px 20px;
        font-size: 13.5px;
        font-weight: 500;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .btn-new-chat:hover { background: rgba(255,255,255,0.12); }

    .inline-success {
        display: none;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #48CAE4;
    }

    @media (max-width: 560px) {
        .chat-box { height: 300px; }
        .msg-col { max-width: 84%; }
    }
</style>

<div class="chat-page">
    <div class="main-content">

        <div class="status-bar">
            <div class="status-badge">
                <div class="status-dot"></div>
                <span>Asisten aktif</span>
            </div>
            <div class="session-info">
                Sesi #{{ $session->id }} · {{ $session->created_at->isToday() ? 'Hari ini' : $session->created_at->format('d M Y') }} {{ $session->created_at->format('H.i') }}
            </div>
        </div>

        <div class="chat-card">
            <div class="chat-header">
                <div class="bot-avatar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg>
                </div>
                <div class="bot-info">
                    <h3>{{ $botName ?? 'Asisten AI' }}</h3>
                    <span>Siap membantu Anda 24/7</span>
                </div>
            </div>

            <div class="chat-box" id="chat-box">
                @forelse($messages as $msg)
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
                <div class="empty-state" id="empty-state">
                    <div class="empty-icon">✨</div>
                    <p style="font-size: 14.5px; font-weight: 500; color: rgba(255,255,255,0.75);">{{ $botName ?? 'Asisten AI' }}</p>
                    <p style="font-size: 12.5px; color: rgba(255,255,255,0.4);">{{ $welcomeMessage ?? 'Ketik pertanyaan Anda di bawah ini' }}</p>
                </div>
                @endforelse

                <div class="typing-indicator" id="typing-wrap" style="display: none;">
                    <div class="msg-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg>
                    </div>
                    <div class="typing-dots"><span></span><span></span><span></span></div>
                </div>
            </div>

            <div class="chat-input-area">
                <div class="input-wrap">
                    <input type="text" id="message-input"
                        placeholder="{{ $session->status === 'closed' ? 'Sesi chat telah berakhir.' : 'Ketik pesan Anda...' }}"
                        {{ $session->status === 'closed' ? 'disabled' : '' }}>
                </div>
                <button class="send-btn" id="send-btn" onclick="sendMessage()" aria-label="Kirim pesan"
                        {{ $session->status === 'closed' ? 'disabled' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>

        <div class="feedback-card">
            @if($alreadyGiven || $session->status === 'closed')
                <div class="feedback-done-row">
                    <span class="emoji">✅</span>
                    <p>
                        <span class="feedback-done-title" style="display:block;">Terima kasih atas feedback Anda!</span>
                        <span class="feedback-done-sub">Masukan Anda sangat berarti untuk meningkatkan layanan kami.</span>
                    </p>
                </div>
                <a href="{{ route('chat.new') }}" class="btn-new-chat">✦ Mulai Chat Baru</a>
            @else
                <div class="feedback-title">Bagaimana pengalaman chat Anda?</div>
                <div class="feedback-sub">Berikan penilaian untuk membantu kami meningkatkan layanan</div>

                <div class="stars" id="star-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <button class="star-btn" id="star-{{ $i }}" onclick="setRating({{ $i }})">★</button>
                    @endfor
                </div>

                <textarea id="feedback-comment" class="feedback-textarea" rows="2" placeholder="Komentar opsional..."></textarea>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <button id="btn-submit-feedback" class="submit-btn" onclick="submitFeedback()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Kirim Feedback & Akhiri Chat
                    </button>
                    <span id="feedback-success" class="inline-success">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><polyline points="20 6 9 17 4 12"/></svg>
                        Feedback berhasil dikirim!
                    </span>
                </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
    const SESSION_ID = {{ $session->id }};
    const CSRF_TOKEN = '{{ csrf_token() }}';
    let selectedRating = 0;
    let isWaiting = false;

    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

    const BOT_AVATAR_SVG = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M9 13v2"/><path d="M15 13v2"/></svg>';
    const USER_AVATAR_SVG = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';

    function nowLabel() {
        const d = new Date();
        return d.getHours().toString().padStart(2, '0') + '.' + d.getMinutes().toString().padStart(2, '0');
    }

    function sendMessage() {
        if (isWaiting) return;
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        if (!message) return;

        const emptyState = document.getElementById('empty-state');
        if (emptyState) emptyState.remove();

        appendBubble('user', message);
        input.value = '';
        isWaiting = true;

        document.getElementById('typing-wrap').style.display = 'flex';
        chatBox.scrollTop = chatBox.scrollHeight;

        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body: JSON.stringify({ session_id: SESSION_ID, message: message })
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('typing-wrap').style.display = 'none';
            appendBubble('bot', data.bot_message.message);
            isWaiting = false;
        })
        .catch(() => {
            document.getElementById('typing-wrap').style.display = 'none';
            appendBubble('bot', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
            isWaiting = false;
        });
    }

    function appendBubble(type, text) {
        const isUser = type === 'user';
        const row = document.createElement('div');
        row.className = 'msg-row' + (isUser ? ' user' : '');
        row.innerHTML = `
            <div class="msg-avatar ${isUser ? 'user-av' : ''}">${isUser ? USER_AVATAR_SVG : BOT_AVATAR_SVG}</div>
            <div class="msg-col">
                <div class="bubble ${isUser ? 'user' : 'bot'}"></div>
                <div class="bubble-time">${nowLabel()}</div>
            </div>
        `;
        row.querySelector('.bubble').textContent = text;

        const typingWrap = document.getElementById('typing-wrap');
        chatBox.insertBefore(row, typingWrap);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    document.getElementById('message-input')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });

    function setRating(rating) {
        selectedRating = rating;
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`star-${i}`);
            if (star) star.classList.toggle('active', i <= rating);
        }
    }

    function submitFeedback() {
        if (selectedRating === 0) { alert('Pilih rating bintang dulu ya!'); return; }
        const comment = document.getElementById('feedback-comment').value;
        const btn = document.getElementById('btn-submit-feedback');
        if (btn) btn.disabled = true;

        fetch('{{ route("feedback.store") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body: JSON.stringify({ session_id: SESSION_ID, rating: selectedRating, comments: comment })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('star-rating').style.display = 'none';
                document.getElementById('feedback-comment').style.display = 'none';
                if (btn) btn.style.display = 'none';
                const msg = document.getElementById('feedback-success');
                if (msg) msg.style.display = 'inline-flex';

                const input = document.getElementById('message-input');
                const sendBtn = document.getElementById('send-btn');
                if (input) { input.disabled = true; input.placeholder = 'Sesi chat telah berakhir.'; }
                if (sendBtn) sendBtn.disabled = true;
            }
        })
        .catch(() => { if (btn) btn.disabled = false; });
    }
</script>
@endpush

@endsection