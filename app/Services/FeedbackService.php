<?php

namespace App\Services;

use App\Models\M_ChatFeedbacks;
use App\Models\M_ChatSession;

class FeedbackService
{
    /**
     * Simpan feedback dari user
     */
    public function store(int $sessionId, int $rating, ?string $comments = null): M_ChatFeedbacks
    {
        // Cek apakah session ini sudah pernah diberi feedback
        $existing = M_ChatFeedbacks::where('session_id', $sessionId)->first();

        if ($existing) {
            // Update feedback yang sudah ada
            $existing->update([
                'rating'   => $rating,
                'comments' => $comments,
            ]);
            return $existing;
        }

        return M_ChatFeedbacks::create([
            'session_id' => $sessionId,
            'rating'     => $rating,
            'comments'   => $comments,
        ]);
    }

    /**
     * Cek apakah session sudah diberi feedback
     */
    public function alreadyGiven(int $sessionId): bool
    {
        return M_ChatFeedbacks::where('session_id', $sessionId)->exists();
    }

    /**
     * Cek apakah user ini SUDAH PERNAH memberi feedback sama sekali,
     * di sesi mana pun (berlaku seumur hidup akun, bukan per sesi).
     */
    public function userHasEverGiven(int $userId): bool
    {
        return M_ChatFeedbacks::whereHas('session', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->exists();
    }

    /**
     * Ambil semua feedback (untuk admin)
     */
    public function getAll()
    {
        return M_ChatFeedbacks::with('session.user')
            ->latest()
            ->paginate(10);
    }

    /**
     * Statistik rating (untuk dashboard)
     */
    public function getStats(): array
    {
        $feedbacks = M_ChatFeedbacks::all();

        if ($feedbacks->isEmpty()) {
            return [
                'total'   => 0,
                'average' => 0,
                'counts'  => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
            ];
        }

        $counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        foreach ($feedbacks as $fb) {
            $counts[$fb->rating] = ($counts[$fb->rating] ?? 0) + 1;
        }

        return [
            'total'   => $feedbacks->count(),
            'average' => round($feedbacks->avg('rating'), 1),
            'counts'  => $counts,
        ];
    }
}