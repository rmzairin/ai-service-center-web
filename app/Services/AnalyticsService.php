<?php

namespace App\Services;

use App\Models\M_ChatSession;
use App\Models\M_ChatMessages;
use App\Models\M_ChatFeedbacks;
use App\Models\M_KnowledgeBase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Statistik utama untuk kartu ringkasan
     */
    public function getSummary(): array
    {
        $totalSessions   = M_ChatSession::count();
        $todaySessions   = M_ChatSession::whereDate('created_at', today())->count();
        $totalMessages   = M_ChatMessages::count();
        $totalUsers      = User::count();
        $avgRating       = M_ChatFeedbacks::avg('rating');
        $totalFeedbacks  = M_ChatFeedbacks::count();
        $totalKnowledge  = M_KnowledgeBase::where('status', 'active')->count();

        return [
            'total_sessions'  => $totalSessions,
            'today_sessions'  => $todaySessions,
            'total_messages'  => $totalMessages,
            'total_users'     => $totalUsers,
            'avg_rating'      => round($avgRating ?? 0, 1),
            'total_feedbacks' => $totalFeedbacks,
            'total_knowledge' => $totalKnowledge,
        ];
    }

    /**
     * Data chat per hari (7 hari terakhir) untuk grafik
     */
    public function getChatPerDay(int $days = 7): array
    {
        $data = M_ChatSession::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Isi hari yang kosong dengan 0
        $result = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d M');
            $found = $data->firstWhere('date', $date);
            $result[] = [
                'date'  => $label,
                'total' => $found ? $found->total : 0,
            ];
        }

        return $result;
    }

    /**
     * Distribusi rating feedback
     */
    public function getRatingDistribution(): array
    {
        $ratings = M_ChatFeedbacks::select(
                'rating',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('rating')
            ->orderBy('rating')
            ->get()
            ->keyBy('rating');

        $result = [];
        for ($i = 1; $i <= 5; $i++) {
            $result[] = [
                'star'  => $i,
                'total' => $ratings->has($i) ? $ratings[$i]->total : 0,
            ];
        }

        return $result;
    }

    /**
     * Source chat (web, mobile, whatsapp)
     */
    public function getChatBySource(): array
    {
        return M_ChatSession::select(
                'source',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('source')
            ->get()
            ->map(fn($item) => [
                'source' => $item->source,
                'total'  => $item->total,
            ])
            ->toArray();
    }

    /**
     * Feedback terbaru
     */
    public function getRecentFeedbacks(int $limit = 5)
    {
        return M_ChatFeedbacks::with('session.user')
            ->latest()
            ->limit($limit)
            ->get();
    }
}