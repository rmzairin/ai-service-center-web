<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M_ChatMessages extends Model
{
    protected $table = 'chat_messages';

    protected $fillable = [
        'session_id',
        'sender_type',
        'sender_id',
        'message',
        'message_type',
        'ai_confidence',
    ];

    protected function casts(): array
    {
        return [
            'ai_confidence' => 'decimal:2',
        ];
    }

    // Relasi ke ChatSession
    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }
}