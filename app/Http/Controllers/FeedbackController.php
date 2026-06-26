<?php

namespace App\Http\Controllers;

use App\Services\FeedbackService;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    protected FeedbackService $feedbackService;
    protected ChatService $chatService;

    public function __construct(FeedbackService $feedbackService, ChatService $chatService)
    {
        $this->feedbackService = $feedbackService;
        $this->chatService     = $chatService;
    }

    /**
     * Simpan feedback dari user (AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'session_id' => 'required|integer|exists:chat_sessions,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comments'   => 'nullable|string|max:500',
        ]);

        $feedback = $this->feedbackService->store(
            $request->session_id,
            $request->rating,
            $request->comments
        );

        // Hapus baris closeSession — tidak perlu close session setelah feedback

        return response()->json([
            'success'  => true,
            'message'  => 'Terima kasih atas feedback Anda!',
            'feedback' => $feedback,
        ]);
    }

    /**
     * Cek apakah session sudah diberi feedback
     */
    public function check(int $sessionId)
    {
        return response()->json([
            'already_given' => $this->feedbackService->alreadyGiven($sessionId),
        ]);
    }
}