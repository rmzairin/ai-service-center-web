<?php

namespace App\Http\Controllers;

use App\Services\KnowledgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KnowledgeController extends Controller
{
    protected KnowledgeService $knowledgeService;

    public function __construct(KnowledgeService $knowledgeService)
    {
        $this->knowledgeService = $knowledgeService;
    }

    /**
     * Daftar Knowledge (dengan search & filter kategori)
     */
    public function index(Request $request)
    {
        $knowledge = $this->knowledgeService->getAllKnowledge(
            $request->search,
            $request->category_id
        );

        $categories = $this->knowledgeService->getAllCategories();

        return view('knowledge.index', [
            'knowledge'  => $knowledge,
            'categories' => $categories,
            'search'     => $request->search,
            'categoryId' => $request->category_id,
        ]);
    }

    /**
     * Form tambah Knowledge
     */
    public function create()
    {
        $categories = $this->knowledgeService->getAllCategories();

        return view('knowledge.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Simpan Knowledge baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:knowledge_categories,id',
            'question'    => 'required|string',
            'answer'      => 'required|string',
            'keywords'    => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $this->knowledgeService->createKnowledge($request->all(), Auth::id());

        return redirect()->route('admin.knowledge.index')
            ->with('success', 'Knowledge berhasil ditambahkan.');
    }

    /**
     * Detail Knowledge
     */
    public function show(int $id)
    {
        $item = $this->knowledgeService->getKnowledgeById($id);

        return view('knowledge.show', [
            'item' => $item,
        ]);
    }

    /**
     * Form edit Knowledge
     */
    public function edit(int $id)
    {
        $item = $this->knowledgeService->getKnowledgeById($id);
        $categories = $this->knowledgeService->getAllCategories();

        return view('knowledge.edit', [
            'item'       => $item,
            'categories' => $categories,
        ]);
    }

    /**
     * Update Knowledge
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:knowledge_categories,id',
            'question'    => 'required|string',
            'answer'      => 'required|string',
            'keywords'    => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $this->knowledgeService->updateKnowledge($id, $request->all());

        return redirect()->route('admin.knowledge.index')
            ->with('success', 'Knowledge berhasil diperbarui.');
    }

    /**
     * Hapus Knowledge
     */
    public function destroy(int $id)
    {
        $this->knowledgeService->deleteKnowledge($id);

        return redirect()->route('admin.knowledge.index')
            ->with('success', 'Knowledge berhasil dihapus.');
    }

    /**
     * Toggle status active/inactive
     */
    public function toggleStatus(int $id)
    {
        $this->knowledgeService->toggleStatus($id);

        return redirect()->route('admin.knowledge.index')
            ->with('success', 'Status berhasil diubah.');
    }
}