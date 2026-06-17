<?php

namespace App\Services;

use App\Models\M_ChatSession;
use App\Models\M_ChatMessages;
use Illuminate\Support\Str;

class ChatService
{
    public function createSession(int $userId, string $source = 'web'): M_ChatSession
    {
        return M_ChatSession::create([
            'user_id'      => $userId,
            'session_code' => $this->generateSessionCode(),
            'status'       => 'active',
            'source'       => $source,
            'started_at'   => now(),
        ]);
    }

    protected function generateSessionCode(): string
    {
        do {
            $code = 'CHT-' . strtoupper(Str::random(8));
        } while (M_ChatSession::where('session_code', $code)->exists());

        return $code;
    }

    public function closeSession(int $sessionId): bool
    {
        $session = M_ChatSession::findOrFail($sessionId);

        return $session->update([
            'status'   => 'closed',
            'ended_at' => now(),
        ]);
    }

    public function getActiveSession(int $userId): ?M_ChatSession
    {
        return M_ChatSession::where('user_id', $userId)
            ->where('status', 'active')
            ->latest()
            ->first();
    }

    public function getOrCreateSession(int $userId, string $source = 'web'): M_ChatSession
    {
        $session = $this->getActiveSession($userId);

        if (!$session) {
            $session = $this->createSession($userId, $source);
        }

        return $session;
    }

    public function saveMessage(
        int $sessionId,
        string $senderType,
        ?int $senderId,
        string $message,
        string $messageType = 'text',
        ?float $aiConfidence = null
    ): M_ChatMessages {
        return M_ChatMessages::create([
            'session_id'    => $sessionId,
            'sender_type'   => $senderType,
            'sender_id'     => $senderId,
            'message'       => $message,
            'message_type'  => $messageType,
            'ai_confidence' => $aiConfidence,
        ]);
    }

    public function saveUserMessage(int $sessionId, int $userId, string $message, string $messageType = 'text'): M_ChatMessages
    {
        return $this->saveMessage($sessionId, 'user', $userId, $message, $messageType);
    }

    public function saveBotMessage(int $sessionId, string $message, ?float $aiConfidence = null, string $messageType = 'text'): M_ChatMessages
    {
        return $this->saveMessage($sessionId, 'bot', null, $message, $messageType, $aiConfidence);
    }

    public function saveAdminMessage(int $sessionId, int $adminId, string $message, string $messageType = 'text'): M_ChatMessages
    {
        return $this->saveMessage($sessionId, 'admin', $adminId, $message, $messageType);
    }

    public function getHistory(int $sessionId, int $limit = 50)
    {
        return M_ChatMessages::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getUserSessions(int $userId)
    {
        return M_ChatSession::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getSessionWithMessages(int $sessionId): M_ChatSession
    {
        return M_ChatSession::with('messages')->findOrFail($sessionId);
    }
}