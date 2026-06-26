<?php

namespace App\Services;

use App\Models\M_KnowledgeDocuments;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentService
{
    /**
     * Upload dokumen baru
     */
    public function upload(UploadedFile $file, string $title, ?int $uploadedBy = null): M_KnowledgeDocuments
    {
        $originalName = $file->getClientOriginalName();

        // Ambil ekstensi dari nama file asli
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        if (empty($extension)) {
            $extension = 'pdf';
        }

        // Generate nama file unik
        $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;

        // Cara aman di Windows — pakai move() langsung ke folder tujuan
        $destinationPath = storage_path('app/public/documents');

        // Pastikan folder ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Pindahkan file ke folder tujuan
        $file->move($destinationPath, $fileName);

        // Path relatif untuk disimpan ke database
        $path = 'documents/' . $fileName;

        return M_KnowledgeDocuments::create([
            'title'       => $title,
            'file_name'   => $originalName,
            'file_path'   => $path,
            'file_type'   => $extension,
            'total_pages' => null,
            'uploaded_by' => $uploadedBy,
            'status'      => 'pending',
        ]);
    }

    /**
     * Ambil semua dokumen (dengan search opsional)
     */
    public function getAll(?string $search = null)
    {
        $query = M_KnowledgeDocuments::with('uploader')->latest();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        return $query->paginate(10)->withQueryString();
    }

    /**
     * Ambil 1 dokumen by ID
     */
    public function getById(int $id): M_KnowledgeDocuments
    {
        return M_KnowledgeDocuments::with('uploader')->findOrFail($id);
    }

    /**
     * Hapus dokumen (file fisik + record database)
     */
    public function delete(int $id): bool
    {
        $document = M_KnowledgeDocuments::findOrFail($id);

        // Hapus file fisik dari storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        return $document->delete();
    }

    /**
     * Update status dokumen (dipakai nanti setelah Python proses)
     */
    public function updateStatus(int $id, string $status, ?int $totalPages = null): M_KnowledgeDocuments
    {
        $document = M_KnowledgeDocuments::findOrFail($id);

        $document->update([
            'status'      => $status,
            'total_pages' => $totalPages ?? $document->total_pages,
        ]);

        return $document;
    }

    /**
     * Ambil semua dokumen yang sudah processed (untuk dikirim ke Python/AI)
     */
    public function getProcessedDocuments()
    {
        return M_KnowledgeDocuments::where('status', 'processed')->get();
    }
}