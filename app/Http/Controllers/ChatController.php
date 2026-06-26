<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use App\Services\AIService;
use App\Models\M_ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected ChatService $chatService;
    protected AIService $aiService;

    public function __construct(ChatService $chatService, AIService $aiService)
    {
        $this->chatService = $chatService;
        $this->aiService = $aiService;
    }

    public function index()
    {
        $userId = Auth::id();
        $feedbackService = app(\App\Services\FeedbackService::class);

        // 1. Cari session active
        $session = M_ChatSession::where('user_id', $userId)
            ->where('status', 'active')
            ->latest()
            ->first();

        // 2. Kalau session active kosong (tidak ada pesan), hapus & cari yang lain
        if ($session && !$session->messages()->exists()) {
            $session->delete();
            $session = null;
        }

        // 3. Kalau tidak ada session active, cari session AKTIF lain yang ada pesannya
        //    (tidak lagi fallback ke session yang sudah closed)
        if (!$session) {
            $session = M_ChatSession::where('user_id', $userId)
                ->where('status', 'active')
                ->whereHas('messages')
                ->latest()
                ->first();
        }

        // 4. Kalau tidak ada session sama sekali, buat baru
        if (!$session) {
            $session = $this->chatService->createSession($userId, 'web');
        }

        $messages = $this->chatService->getHistory($session->id);
        $alreadyGiven = $feedbackService->userHasEverGiven($userId);

        return view('chat.index', [
            'session'      => $session,
            'messages'     => $messages,
            'alreadyGiven' => $alreadyGiven,
        ]);
    }

    

    public function send(Request $request)
    {
        $request->validate([
            'session_id' => 'required|integer|exists:chat_sessions,id',
            'message'    => 'required|string',
        ]);

        $userId = Auth::id();

        $userMessage = $this->chatService->saveUserMessage(
            $request->session_id,
            $userId,
            $request->message
        );

        // Panggil Python AI Service
        $aiResult = $this->aiService->ask($request->message, $request->session_id);

        $botMessage = $this->chatService->saveBotMessage(
            $request->session_id,
            $aiResult['answer'],
            $aiResult['confidence']
        );

        return response()->json([
            'user_message' => $userMessage,
            'bot_message'  => $botMessage,
        ]);
    }

    public function history()
    {
        $userId = Auth::id();
        $sessions = $this->chatService->getUserSessions($userId);

        return view('chat.history', [
            'sessions' => $sessions,
        ]);
    }

    public function detail(int $sessionId)
    {
        $session = $this->chatService->getSessionWithMessages($sessionId);

        return view('chat.detail', [
            'session' => $session,
        ]);
    }
}