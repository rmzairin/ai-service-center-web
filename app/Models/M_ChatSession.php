<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_ChatSession extends Model
{
    protected $table = 'chat_sessions';
    protected $fillable = ['user_id', 'session_code', 'status', 'source', 'started_at', 'ended_at'];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime', 
        ];
    }

    public function messages(): HasMany
    {
        return $this->hasMany(M_ChatMessages::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
