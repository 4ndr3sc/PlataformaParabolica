<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotInteraction extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'question',
        'answer',
        'was_fallback',
    ];

    protected function casts(): array
    {
        return [
            'was_fallback' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}