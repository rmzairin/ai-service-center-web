<?php

namespace App\Http\Controllers;

use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    protected DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function index(Request $request)
    {
        $documents = $this->documentService->getAll($request->search);

        return view('documents.index', [
            'documents' => $documents,
            'search'    => $request->search,
        ]);
    }

    public function create()
    {
        return view('documents.upload');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'required|file|mimes:pdf|max:10240', // max 10MB
        ]);

        $adminId = Auth::guard('admin')->id();

        $this->documentService->upload($request->file('file'), $request->title, $adminId);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diupload.');
    }

    public function show(int $id)
    {
        $document = $this->documentService->getById($id);

        return view('documents.detail', [
            'document' => $document,
        ]);
    }

    public function destroy(int $id)
    {
        $this->documentService->delete($id);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}