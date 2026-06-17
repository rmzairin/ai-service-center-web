<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class M_KnowledgeCategories extends Model
{
    protected $table = 'knowledge_categories';

    protected $fillable = [
        'category_name',
        'description',
    ];

    public function knowledgeBases(): HasMany
    {
        return $this->hasMany(M_KnowledgeBase::class, 'category_id');
    }
}