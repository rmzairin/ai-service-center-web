<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M_KnowledgeBase extends Model
{
    protected $table = 'knowledge_base';

    protected $fillable = [
        'category_id',
        'question',
        'answer',
        'keywords',
        'status',
        'created_by',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(M_KnowledgeCategories::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}