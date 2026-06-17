<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M_ChatFeedbacks extends Model
{
    protected $table = 'chat_feedbacks';

    protected $fillable = [
        'session_id',
        'rating',
        'comments',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }
}