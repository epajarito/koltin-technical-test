<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id_sender',
        'user_id_receiver',
        'post_id'
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_sender', 'id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_receiver', 'id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'conversation_id', 'id');
    }
}
