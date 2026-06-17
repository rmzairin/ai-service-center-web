<?php

namespace App\Services;

use App\Models\M_AiLogs;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AIService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.ai_service.url');
    }

    public function ask(string $message, int $sessionId): array
    {
        $startTime = microtime(true);

        try {
            $response = Http::timeout(30)->post("{$this->baseUrl}/api/chat/", [
                'message'    => $message,
                'session_id' => $sessionId,
            ]);

            $responseTime = round((microtime(true) - $startTime) * 1000, 2);

            if ($response->successful()) {
                $data = $response->json();

                $result = [
                    'answer'     => $data['answer'] ?? 'Maaf, saya belum memahami pertanyaan Anda.',
                    'confidence' => $data['confidence'] ?? null,
                    'tokens'     => $data['tokens_used'] ?? null,
                    'model'      => $data['model_name'] ?? 'unknown',
                ];

                $this->saveLog($sessionId, $message, $result['answer'], $responseTime, $result['tokens'], $result['model']);

                return $result;
            }

            throw new Exception('AI Service merespon dengan status: ' . $response->status());

        } catch (Exception $e) {
            Log::error('AIService Error: ' . $e->getMessage());

            $fallbackAnswer = $this->getFallbackResponse($message);
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);

            $this->saveLog($sessionId, $message, $fallbackAnswer, $responseTime, null, 'fallback');

            return [
                'answer'     => $fallbackAnswer,
                'confidence' => null,
                'tokens'     => null,
                'model'      => 'fallback',
            ];
        }
    }

    protected function getFallbackResponse(string $message): string
    {
        return 'Terima kasih atas pesan Anda. Sistem AI sedang dalam pengembangan, tim kami akan segera membantu Anda.';
    }

    protected function saveLog(
        int $sessionId,
        string $userMessage,
        string $aiResponse,
        float $responseTime,
        ?int $tokensUsed,
        string $modelName
    ): M_AiLogs {
        return M_AiLogs::create([
            'session_id'    => $sessionId,
            'user_message'  => $userMessage,
            'ai_response'   => $aiResponse,
            'response_time' => $responseTime,
            'tokens_used'   => $tokensUsed,
            'model_name'    => $modelName,
        ]);
    }
}