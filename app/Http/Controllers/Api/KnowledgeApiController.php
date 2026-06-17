<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\KnowledgeService;

class KnowledgeApiController extends Controller
{
    protected KnowledgeService $knowledgeService;

    public function __construct(KnowledgeService $knowledgeService)
    {
        $this->knowledgeService = $knowledgeService;
    }

    /**
     * Kirim semua knowledge aktif ke Python
     */
    public function active()
    {
        $knowledge = $this->knowledgeService->getActiveKnowledgeForAI();

        $data = $knowledge->map(function ($item) {
            return [
                'id'       => $item->id,
                'question' => $item->question,
                'answer'   => $item->answer,
                'keywords' => $item->keywords,
                'category' => $item->category->category_name ?? null,
            ];
        });

        return response()->json([
            'total' => $data->count(),
            'data'  => $data,
        ]);
    }
}