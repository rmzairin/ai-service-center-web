<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M_AiLogs extends Model
{
    protected $table = 'ai_logs';

    protected $fillable = [
        'session_id',
        'user_message',
        'ai_response',
        'response_time',
        'tokens_used',
        'model_name',
    ];

    protected function casts(): array
    {
        return [
            'response_time' => 'decimal:2',
        ];
    }

    // Relasi ke ChatSession
    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }
}