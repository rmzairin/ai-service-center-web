<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\M_KnowledgeDocuments;

class DocumentApiController extends Controller
{
    public function processed()
    {
        $documents = M_KnowledgeDocuments::where('status', 'processed')
            ->orWhere('status', 'pending')
            ->get();

        $data = $documents->map(function ($doc) {
            return [
                'id'        => $doc->id,
                'title'     => $doc->title,
                'file_name' => $doc->file_name,
                'file_url'  => asset('storage/' . $doc->file_path),
                'file_path' => storage_path('app/public/' . $doc->file_path),
                'status'    => $doc->status,
            ];
        });

        return response()->json([
            'total' => $data->count(),
            'data'  => $data,
        ]);
    }
}