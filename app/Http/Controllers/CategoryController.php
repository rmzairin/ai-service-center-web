<?php

namespace App\Http\Controllers;

use App\Services\KnowledgeService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected KnowledgeService $knowledgeService;

    public function __construct(KnowledgeService $knowledgeService)
    {
        $this->knowledgeService = $knowledgeService;
    }

    public function index()
    {
        $categories = $this->knowledgeService->getAllCategories();

        return view('knowledge.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100',
            'description'   => 'nullable|string',
        ]);

        $this->knowledgeService->createCategory($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:100',
            'description'   => 'nullable|string',
        ]);

        $this->knowledgeService->updateCategory($id, $request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->knowledgeService->deleteCategory($id);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}