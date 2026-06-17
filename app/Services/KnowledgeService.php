<?php

namespace App\Services;

use App\Models\M_KnowledgeBase;
use App\Models\M_KnowledgeCategories;

class KnowledgeService
{
    // ============================
    // KATEGORI
    // ============================

    public function getAllCategories()
    {
        return M_KnowledgeCategories::orderBy('category_name')->get();
    }

    public function createCategory(array $data): M_KnowledgeCategories
    {
        return M_KnowledgeCategories::create([
            'category_name' => $data['category_name'],
            'description'   => $data['description'] ?? null,
        ]);
    }

    public function updateCategory(int $id, array $data): M_KnowledgeCategories
    {
        $category = M_KnowledgeCategories::findOrFail($id);

        $category->update([
            'category_name' => $data['category_name'],
            'description'   => $data['description'] ?? null,
        ]);

        return $category;
    }

    public function deleteCategory(int $id): bool
    {
        $category = M_KnowledgeCategories::findOrFail($id);
        return $category->delete();
    }


    // ============================
    // KNOWLEDGE BASE (FAQ)
    // ============================

    public function getAllKnowledge(?string $search = null, ?int $categoryId = null)
    {
        $query = M_KnowledgeBase::with('category')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->paginate(10)->withQueryString();
    }

    public function getKnowledgeById(int $id): M_KnowledgeBase
    {
        return M_KnowledgeBase::with('category')->findOrFail($id);
    }

    public function createKnowledge(array $data, ?int $createdBy = null): M_KnowledgeBase
    {
        return M_KnowledgeBase::create([
            'category_id' => $data['category_id'],
            'question'    => $data['question'],
            'answer'      => $data['answer'],
            'keywords'    => $data['keywords'] ?? null,
            'status'      => $data['status'] ?? 'active',
            'created_by'  => $createdBy,
        ]);
    }

    public function updateKnowledge(int $id, array $data): M_KnowledgeBase
    {
        $knowledge = M_KnowledgeBase::findOrFail($id);

        $knowledge->update([
            'category_id' => $data['category_id'],
            'question'    => $data['question'],
            'answer'      => $data['answer'],
            'keywords'    => $data['keywords'] ?? null,
            'status'      => $data['status'] ?? 'active',
        ]);

        return $knowledge;
    }

    public function deleteKnowledge(int $id): bool
    {
        $knowledge = M_KnowledgeBase::findOrFail($id);
        return $knowledge->delete();
    }

    public function toggleStatus(int $id): M_KnowledgeBase
    {
        $knowledge = M_KnowledgeBase::findOrFail($id);

        $knowledge->update([
            'status' => $knowledge->status === 'active' ? 'inactive' : 'active',
        ]);

        return $knowledge;
    }


    // ============================
    // UNTUK PYTHON / AI SERVICE
    // ============================

    /**
     * Ambil semua knowledge yang aktif (untuk dikirim ke Python / index vector)
     */
    public function getActiveKnowledgeForAI()
    {
        return M_KnowledgeBase::with('category')
            ->where('status', 'active')
            ->get();
    }
}