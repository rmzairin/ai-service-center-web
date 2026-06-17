<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M_KnowledgeDocuments extends Model
{
    protected $table = 'knowledge_documents';

    protected $fillable = [
        'title',
        'file_name',
        'file_path',
        'file_type',
        'total_pages',
        'uploaded_by',
        'status',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }
}